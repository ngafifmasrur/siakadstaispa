<?php

namespace Modules\Admission\Http\Controllers\Admin\Report;

use Modules\Admission\Models\Admission;
use Modules\Admission\Models\AdmissionRegistrant;
use Modules\Admission\Models\AdmissionRegistrantTransaction;

use Illuminate\Http\Request;
use Modules\Admission\Http\Controllers\Admin\DashboardController;

class QuotaController extends DashboardController
{
    /**
     * Display administration homepage.
     */
    public function quotas(Request $request)
    {
        $detailQuota = $this->getDetailQuota();

        $pdf = \PDF::loadView('admission::admin.report.quotas.export.quotas', compact('detailQuota'))
                    ->setPaper('a4', 'portrait');

        return $pdf->stream('LAPORAN-KUOTA.pdf');
    }
}
