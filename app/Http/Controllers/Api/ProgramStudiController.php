<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\m_program_studi;
use Session, DB, Str;

class ProgramStudiController extends BaseController
{
    public function index()
    {
        $data = m_program_studi::all();

        return $this->ok($data);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->merge([
                'id_prodi' => Str::uuid(),
                'nama_jenjang_pendidikan' => $this->jenjang_pendidikan[$request->id_jenjang_pendidikan]
            ]);
            $data = m_program_studi::create($request->all());
            DB::commit();

            return $this->ok($data, 'Berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollback();

            return $this->oops($e->getMessage());
        }
    }

    public function show($id)
    {
        $data = m_program_studi::find($id);

        if (! $data) {
            return $this->oops('Tidak ditemukan');
        }

        return $this->ok($data);
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $request->merge([
                'nama_jenjang_pendidikan' => $this->jenjang_pendidikan[$request->id_jenjang_pendidikan]
            ]);
            $data = m_program_studi::find($id);
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

    public function destroy($id)
    {
        $data = m_program_studi::find($id);
        if (! $data) {
            return $this->oops('Tidak ditemukan');
        }

        $data->delete();

        return $this->ok($data, 'Berhasil dihapus');
    }
}
