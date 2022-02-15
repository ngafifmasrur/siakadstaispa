<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

use App\Models\{
    m_kelas_kuliah,
    t_detail_nilai_perkuliahan_kelas
};

class TemplateNilaiExport implements FromQuery, WithHeadings, WithColumnWidths, WithStyles
{
    use Exportable;

    public function __construct($id_kelas_kuliah)
    {
        $this->id_kelas_kuliah = $id_kelas_kuliah;
    }

    public function query()
    {
        $id_kelas_kuliah = $this->id_kelas_kuliah;

        $kelas_kuliah = m_kelas_kuliah::setFilter([
            'filter' => "id_kelas_kuliah='$id_kelas_kuliah'",
        ])->first();

        $peserta = t_detail_nilai_perkuliahan_kelas::setFilter([
            'filter' => "id_kelas_kuliah='$id_kelas_kuliah'",
        ])->select('id_registrasi_mahasiswa', 'nim', 'nama_mahasiswa', 'nilai_angka')->orderBy('nama_mahasiswa', 'DESC');

        return $peserta;
    }

    public function headings(): array
    {
        return ["ID Registrasi", "Nim", "Nama Mahasiswa", "Nilai"];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 20, 
            'C' => 25,          
            'D' => 10,          
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
