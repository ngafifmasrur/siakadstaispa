<?php

namespace Modules\Admission\Http\Controllers\Admin\Report;

use Modules\Admission\Models\Admission;
use Modules\Admission\Models\AdmissionPayment;
use Modules\Admission\Models\AdmissionRegistrant;
use Modules\Admission\Models\AdmissionRegistrantTransaction;

use Illuminate\Http\Request;
use Modules\Admission\Http\Controllers\Controller;

class PaymentController extends Controller
{
    /**
     * Display administration homepage.
     */
    public function index(Request $request)
    {
        $admissions = Admission::withCount(['registrants'])->with('period.instance')->get();

        return view('admission::admin.report.payments.index', compact('admissions'));
    }

    /**
     * Export the receipt.
     */
    public function receipt(Request $request)
    {
        $request->validate([
            'from'  => 'required|date_format:d-m-Y|before_or_equal:to',
            'to'  => 'required|date_format:d-m-Y|after_or_equal:from',
        ]);

        $date = [
            'from' => date('Y-m-d', strtotime($request->input('from'))).' 00:00:00',
            'to' => date('Y-m-d', strtotime($request->input('to'))).' 23:59:59'
        ];

        $payments = AdmissionRegistrantTransaction::with(['committee', 'registrant' => function ($registrant) {
                                $registrant->with(['user', 'admission.period']);
                            }])
                            ->whereHas('registrant', function($registrant) use ($request) {
                                $registrant->where('admission_id', $request->input('aid'));
                            })
                            ->whereBetween('admission_registrant_transactions.created_at', array_values($date))
                            ->get();

        return view('admission::admin.report.payments.export.receipt', compact('payments', 'date'));
    }

    /**
     * Export the not paid off.
     */
    public function notPaidOff(Request $request)
    {
        $registrants = AdmissionRegistrant::with(['user', 'transactions', 'admission.period', 'payment.items'])
                            ->has('payment')
                            ->whereNull('paid_off_at')
                            ->where('admission_id', $request->input('aid'))
                            ->get();

        return view('admission::admin.report.payments.export.not-paid-off', compact('registrants'));
    }

    /**
     * Export the per item.
     */
    public function perItem(Request $request)
    {
        $request->validate([
            'from'  => 'required|date_format:d-m-Y|before_or_equal:to',
            'to'  => 'required|date_format:d-m-Y|after_or_equal:from',
        ]);

        $date = [
            'from' => date('Y-m-d', strtotime($request->input('from'))).' 00:00:00',
            'to' => date('Y-m-d', strtotime($request->input('to'))).' 23:59:59'
        ];
        
        $cash = $request->input('cash', '');

        $payment = AdmissionPayment::with(['items', 'admission.period', 'transactions' => function($transaction) use ($date, $cash) {
                                $transaction->with('registrant.user.profile')
                                            ->when($cash, function($query, $cash) {
                                                return $query->where('cash', $cash - 1);
                                            })
                                            ->whereBetween('admission_registrant_transactions.created_at', array_values($date));
                            }])
                            ->where('admission_id', $request->input('aid'))
                            ->find($request->input('payment'));

        return view('admission::admin.report.payments.export.per-item', compact('payment', 'date'));
    }

    /**
     * Export the payments.
     */
    public function payments(Request $request)
    {
        $request->validate([
            'from'  => 'required|date_format:d-m-Y|before_or_equal:to',
            'to'  => 'required|date_format:d-m-Y|after_or_equal:from',
        ]);

        $date = [
            'from' => date('Y-m-d', strtotime($request->input('from'))).' 00:00:00',
            'to' => date('Y-m-d', strtotime($request->input('to'))).' 23:59:59'
        ];

        $payments = AdmissionRegistrantTransaction::with(['committee', 'registrant' => function ($registrant) {
                                $registrant->with(['user', 'admission.period']);
                            }])
                            ->whereHas('registrant', function($registrant) use ($request) {
                                $registrant->where('admission_id', $request->input('aid'));
                            })
                            ->whereBetween('admission_registrant_transactions.created_at', array_values($date))
                            ->get();

        $admission = Admission::with('period')->find($request->input('aid'));

        $range = $request->input('from').'-SD-'.$request->input('to');

        $pdf = \PDF::loadView('admission::admin.report.payments.export.payments', compact('payments', 'date', 'admission', 'range'))
                    ->setPaper('a4', 'portrait');

        return $pdf->stream('LAPORAN-PEMBAYARAN-'.$range.'.pdf');
    }
}
