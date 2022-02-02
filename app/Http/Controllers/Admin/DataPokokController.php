<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\m_konfigurasi;
use Illuminate\Http\Request;
use Session, DB;

class DataPokokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($master)
    {
        $title  = ucwords(str_replace('_', ' ', $master));
        $master = "Get". str_replace(' ', '', ucwords(str_replace('_', ' ', $master)));

        try {
            $data  = GetDataFeeder($master);

            if (! $data) {
                $data = [];
            }
        } catch (\Exception $e) {
            $data = [];
        }

        return view('admin.data_pokok.index', compact('master', 'title', 'data'));
    }
}
