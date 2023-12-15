<?php

namespace Modules\Admission\Http\Controllers;

use Modules\Admission\Models\Admission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as AppController;
use Modules\Admission\Models\Brochure;

class Controller extends AppController
{
    /**
     * Display homepage.
     */
    public function home()
    {
    	$admissions = Admission::opened();
        $frontBrochure = Brochure::where(['status' => true,'type'   => 'Brosur Depan'])->first();
        $downloadBrochure = Brochure::where(['status' => true, 'type'   => 'Download Brosur'])->first();

        return view('admission::index', compact('admissions', 'frontBrochure', 'downloadBrochure'));
    }
}
