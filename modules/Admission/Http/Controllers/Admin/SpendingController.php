<?php

namespace Modules\Admission\Http\Controllers\Admin;

use Modules\Admission\Models\Admission;
use Modules\Admission\Models\AdmissionSpending;
use Illuminate\Http\Request;
use Modules\Admission\Http\Controllers\Controller;

class SpendingController extends Controller
{
    /**
     * Display home.
     */
    public function index()
    {
        $spendings = AdmissionSpending::with('committee')->get();

        return view('admission::admin.spendings.index', compact('spendings'));
    }

    /**
     * Create .
     */
    public function create()
    {
        $admissions = Admission::with('committees')->opened()->get();

        return view('admission::admin.spendings.create', compact('admissions'));
    }

    /**
     * Store .
     */
    public function store(Request $request)
    {
        $request->validate([
            'item' => 'required|string|max:191',
            'amount' => 'required|numeric',
            'qty' => 'required|numeric',
            'unit' => 'required|in:'.join(',', array_keys(AdmissionSpending::$unit)),
            'shop' => 'required|string|max:191',
            'committee_id' => 'required|exists:admission_committees,id',
            'buyer' => 'required|string|max:191',
            'payed_at' => 'required|date_format:d-m-Y',
            'receipt' => 'nullable|file|max:1024',
        ]);

        if ($request->has('receipt')){
            $file = $request->file('receipt');
            $path = $file->store('admissions/spendings');
        }

        $spending = new AdmissionSpending([
            'item' => $request->input('item'),
            'amount' => $request->input('amount'),
            'qty' => $request->input('qty'),
            'unit' => $request->input('unit'),
            'shop' => $request->input('shop'),
            'committee_id' => $request->input('committee_id'),
            'buyer' => $request->input('buyer'),
            'payed_at' => date('Y-m-d', strtotime($request->input('payed_at'))),
            'receipt' => $path ?? null
        ]);

        $spending->save();

        return redirect()->route('admission.admin.spendings.index')
                         ->with(['success' => 'Sukses, data pengeluaran berhasil dibuat!']);
    }

    /**
     * Edit .
     */
    public function edit(AdmissionSpending $spending)
    {
        $admissions = Admission::with('committees')->opened()->get();

        return view('admission::admin.spendings.edit', compact('admissions', 'spending'));
    }

    /**
     * Update .
     */
    public function update(AdmissionSpending $spending, Request $request)
    {
        $request->validate([
            'item' => 'required|string|max:191',
            'amount' => 'required|numeric',
            'qty' => 'required|numeric',
            'unit' => 'required|in:'.join(',', array_keys(AdmissionSpending::$unit)),
            'shop' => 'required|string|max:191',
            'committee_id' => 'required|exists:admission_committees,id',
            'buyer' => 'required|string|max:191',
            'payed_at' => 'required|date_format:d-m-Y',
        ]);

        if ($request->has('receipt')){
            $file = $request->file('receipt');
            $path = $file->store('admissions/spendings');
        }

        $spending->update([
            'item' => $request->input('item'),
            'amount' => $request->input('amount'),
            'qty' => $request->input('qty'),
            'unit' => $request->input('unit'),
            'shop' => $request->input('shop'),
            'committee_id' => $request->input('committee_id'),
            'buyer' => $request->input('buyer'),
            'payed_at' => date('Y-m-d', strtotime($request->input('payed_at'))),
            'receipt' => $path ?? null
        ]);

        return redirect()->route('admission.admin.spendings.index')
                         ->with(['success' => 'Sukses, data pengeluaran berhasil diubah!']);
    }

    /**
     * Destroy .
     */
    public function destroy(AdmissionSpending $spending)
    {
        if($spending->receipt) {
            \Storage::delete($spending->receipt);
        }

        $spending->delete();

        return redirect()->route('admission.admin.spendings.index')
                         ->with(['success' => 'Sukses, data pengeluaran berhasil dihapus!']);
    }

    /**
     * Display report.
     */
    public function report()
    {
        $spendings = AdmissionSpending::with('committee')->get();

        $pdf = \PDF::loadView('admission::admin.spendings.export.report', compact('spendings'))
                    ->setPaper('a4', 'landscape');

        return $pdf->stream('LAPORAN-PENGELUARAN.pdf');
    }
}
