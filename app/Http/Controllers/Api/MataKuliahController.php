<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\m_program_studi;
use App\Models\m_mata_kuliah;
use App\Http\Requests\MataKuliahRequest;
use Session, DB, Str;

class MataKuliahController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = m_mata_kuliah::all();

        return $this->ok($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            $request->merge([
                'id_matkul' => Str::uuid(),
            ]);
            
            $data = m_mata_kuliah::create($request->all());
            DB::commit();

            return $this->ok($data, 'Berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollback();

            return $this->oops($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = m_mata_kuliah::find($id);

        if (! $data) {
            return $this->oops('Tidak ditemukan');
        }

        return $this->ok($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {

            $data = m_mata_kuliah::find($id);

            if (! $data) {
                return $this->oops('Tidak ditemukan');
            }

            $data->update($request->all());
            DB::commit();

            return $this->ok($data, 'Berhasil disimpan');
        } catch (\Exception $e) {

            DB::rollback();

            return $this->oops($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = m_mata_kuliah::find($id);

        if (! $data) {
            return $this->oops('Tidak ditemukan');
        }

        $data->delete();

        return $this->ok($data, 'Berhasil dihapus');
    }
}
