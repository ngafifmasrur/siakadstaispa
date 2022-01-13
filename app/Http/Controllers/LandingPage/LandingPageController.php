<?php

namespace App\Http\Controllers\LandingPage;

use App\Http\Controllers\Controller;

class LandingPageController extends Controller {

    /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
    public function index()
    {
        $nav = "home";
        return view('landing_page.index', compact('nav'));
    }

    public function berita()
    {
        $nav = "berita";
        return view('landing_page.berita' , compact('nav'));
    }


}

?>