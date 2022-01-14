<?php

namespace App\Http\Controllers;
use App\Models\m_mata_kuliah;
use App\Models\m_semester;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function mata_kuliah_list(Request $request)
    {
        if ($request->id_prodi == "" OR $request->id_prodi == null) {
            return;
        }

        $result = m_mata_kuliah::where('id_prodi', $request->id_prodi)->select('id_matkul', 'nama_mata_kuliah')->get();

        return $this->responseJson(true, 'List Mata Kuliah', $result);
    }

    public function semester_list(Request $request)
    {
        if ($request->id_tahun_ajaran == "" OR $request->id_tahun_ajaran == null) {
            return;
        }

        $result = m_semester::where('id_tahun_ajaran', $request->id_tahun_ajaran)->select('id_semester', 'nama_semester')->get();

        return $this->responseJson(true, 'List Semester', $result);
    }

    public function responseJson($status = true, $msg = null, $data = [], $code = null)
    {
        if(is_null($code)){
            $http_code = $status ? 200 : 400;
        }else{
            $http_code = $code;
        }
        
        return response()->json([
            'status' => $status,
            'code' => $http_code,
            'message' => $msg,
            'data' => $data,
        ], $http_code);
    }
}
