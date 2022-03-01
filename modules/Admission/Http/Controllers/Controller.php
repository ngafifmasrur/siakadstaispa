<?php

namespace Modules\Admission\Http\Controllers;

use Modules\Admission\Models\Admission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as AppController;

class Controller extends AppController
{
    /**
     * Display homepage.
     */
    public function home()
    {
    	$admissions = Admission::opened();

        return view('admission::index', compact('admissions'));
    }
}
