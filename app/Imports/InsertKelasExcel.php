<?php

namespace App\Imports;
use App\Models\Kelas;
use App\Models\Periode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure; // Optional: To skip rows that fail validation
use Maatwebsite\Excel\Validators\Failure;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class InsertKelasExcel implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        $tempPeriode = "Tahun " . trim($row['tahun_ajaran']) . " " . strtoupper(trim($row['semester']));

        $id_periode = Periode::where('PERIODE', '=', $tempPeriode)->value('ID_PERIODE');
        return new Kelas([
            'ID_DETAIL_KELAS' => $row['id_ruang_kelas'],
            'ID_GURU' => $row['id_guru'],
            'ID_PERIODE' => $id_periode,
        ]);
    }
    public function headingRow(): int
    {
        return 1;
    }
    public function rules(): array
    {
        return [
            'id_ruang_kelas' => ['required', 'exists:Detail_Kelas,ID_DETAIL_KELAS'],
            'id_guru' => ['required', 'exists:Guru,ID_GURU'],
            'tahun_ajaran' => 'required',
            'semester' => 'required',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        // Optional: Handle validation failures
        foreach ($failures as $failure) {
            // Log the row and error message
            \Log::warning(sprintf('Row %s: %s', $failure->row(), implode(', ', $failure->errors())));
        }
    }
}
