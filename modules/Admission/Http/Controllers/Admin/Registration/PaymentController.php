<?php

namespace Modules\Admission\Http\Controllers\Admin\Registration;

use Modules\Admission\Models\Admission;
use Modules\Admission\Models\AdmissionRegistrant;
use Modules\Admission\Models\AdmissionRegistrantTransaction;
use Modules\Admission\Models\AdmissionPayment;
use Modules\Admission\Repositories\AdmissionRegistrantRepository;
use Modules\Admission\Http\Requests\Admin\Registration\Payment\TransactionRequest;

use Illuminate\Http\Request;
use Modules\Admission\Http\Controllers\Controller;

class PaymentController extends Controller
{
    /**
     * Instance the main property.
     */    
    protected $repo;

    /**
     * Create a new controller instance.
     */
    public function __construct(AdmissionRegistrantRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Index.
     */
    public function index(Request $request)
    {
        $this->authorize('acceptPaymentRegistrant', AdmissionRegistrant::class);

        $admissions = $this->repo->admission = auth()->user()->admissionCommittees->load('admission')->pluck('admission');

        $this->repo->admission = $admissions->when(!!$request->get('aid'), function ($query) use ($request) {
            return $query->where('id', $request->get('aid'));
        });

        $registrants = $this->repo->setWhere(function($query) {
                                    // $query->whereNotNull('verified_at');
                                    // $query->whereNotNull('validated_at');
                                    // $query->whereNotNull('tested_at');
                                    $query->where('is_saman', 0);
                                  })
                                  ->setLimit(request('limit', $this->repo->limit))
                                  ->onlyTrashed(request('trash', false))
                                  ->search(request('search', ''));

        return view('admission::admin.registration.payment.index', compact('admissions', 'registrants'));
    }

    /**
     * Show the registrant payments.
     */
    public function show(AdmissionRegistrant $registrant)
    {
        $this->authorize('acceptPaymentRegistrant', $registrant);

        $registrant = $registrant->load(['user', 'transactions', 'admission.payments.admission']);
        $payments = $registrant->admission->payments;

        return view('admission::admin.registration.payment.show', compact('registrant', 'payments'));
    }

    /**
     * Set the payment type of registrants.
     */
    public function set(AdmissionRegistrant $registrant, Request $request)
    {
        $this->authorize('acceptPaymentRegistrant', $registrant);

        $request->validate([
            'payment_id'      => 'required|exists:admission_payments,id'
        ]);

        if (!$registrant->payment_id) {
            $this->repo->update([
                'payment_id' => $request->input('payment_id')
            ], $registrant);
            
            return redirect()->back()
                        ->with(['success' => 'Sukses, jenis pembayaran pendaftar atas nama <strong'.$registrant->user->profile->full_name.'</strong> telah ditentukan.']);
        }

        return redirect()->back()
                        ->with(['danger' => 'Maaf, jenis pembayaran pendaftar atas nama <strong'.$registrant->user->profile->full_name.'</strong> tidak dapat dirubah.']);
    }

    /**
     * Create a new transactions.
     */
    public function create(AdmissionRegistrant $registrant)
    {
        $this->authorize('acceptPaymentRegistrant', $registrant);

        $registrant = $registrant->load(['transactions', 'payment.items']);

        $payed = [];
        if (count($registrant->transactions)) {
            foreach ($registrant->transactions as $transaction) {
                $payed[] = array_keys(json_decode($transaction->value, 1));
            }
            $payed = \Arr::flatten($payed);
        }

        $payments = $registrant->payment->items()
                        ->with('category')
                        ->whereNotIn('id', $payed)
                        ->get();

        return view('admission::admin.registration.payment.create', compact('registrant', 'payments'));
    }

    /**
     * Store a new transactions.
     */
    public function store(AdmissionRegistrant $registrant, TransactionRequest $request)
    {
        $this->authorize('acceptPaymentRegistrant', $registrant);

        $registrant = $registrant->loadCount('transactions')->load('admission.period.instance');

        if ($request->has('item')) {
            $transaction = new AdmissionRegistrantTransaction([
                'kd'            => ($registrant->kd.'/'.(str_pad($registrant->transactions_count + 1, 2, '0', STR_PAD_LEFT)).'/Pan-PMB/PB/'.numToRoman($registrant->admission->generation).'/'.$registrant->admission->period->instance->short_name.'/'.$registrant->admission->period->year),
                'value'         => $request->input('item'),
                'amount'       => array_sum($request->input('item')),
                'cash'          => $request->input('cash') ?: 0,
                'payer'         => $request->input('payer'),
                'description'   => $request->input('description'),
                'committee_id'  => auth()->user()->admissionCommittees->first()->pivot->id ?? null,
                'payed_at'      => date('Y-m-d H:i:s', strtotime($request->input('payed_at'))),
            ]);

            $registrant->transactions()->save($transaction);

            return redirect()->route('admission.admin.registration.payment.show', ['registrant' => $registrant->id])
                             ->with(['success' => 'Transaksi berhasil dibuat']);
        } else {
            return redirect()->back()
                             ->withInput()
                             ->with(['danger' => 'Transaksi gagal, tidak ada item yang dipilih']);
        }
    }

    /**
     * Mark registrant's payment as paid off.
     */
    public function paid(AdmissionRegistrant $registrant, Request $request)
    {
        $this->authorize('acceptPaymentRegistrant', $registrant);

        $request->validate([
            'paid'      => 'boolean',
            'accepted'  => 'boolean'
        ]);

        $this->repo->update([
            'paid_off_at' => $request->paid ? date('Y-m-d H:i:s') : null,
            'accepted_at' => $request->accepted ? date('Y-m-d H:i:s') : null
        ], $registrant);
        
        return redirect()->back()
                    ->with(['success' => 'Sukses, status pelunasan pendaftar atas nama <strong>'.$registrant->user->profile->full_name.'</strong> telah berhasil diperbarui.']);
    }

    /**
     * Printing receipt letter.
     */
    public function receipt(AdmissionRegistrantTransaction $transaction)
    {
        $this->authorize('acceptPaymentRegistrant', AdmissionRegistrant::class);

        $transaction = $transaction->load(['registrant.admission.period.instance', 'committee']);

        $registrant = $transaction->registrant;
        $items = $registrant->payment->items;
        $admission = $transaction->registrant->admission;
        $user = $registrant->user;

        $payed = [];
        $transactions = $registrant->transactions()
                            ->where('payed_at', '<', $transaction->payed_at)
                            ->get();

        if (count($transactions)) {
            foreach ($transactions->pluck('value')->toArray() as $value) {
                foreach ($value as $id => $amount) {
                    $payed[$id] = $amount;
                }
            }
        }

        $pdf = \PDF::loadView('admission::admin.registration.payment.pdf.receipt', compact('user', 'registrant', 'transaction', 'admission', 'items', 'payed'))
                    ->setPaper('a4', 'portrait');

        return $pdf->stream('KWITANSI-'.str_replace('/', '-', $transaction->kd).'.pdf');
    }
}
