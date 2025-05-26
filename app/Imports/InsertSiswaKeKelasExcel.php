<?php

namespace App\Imports;
use App\Models\EnrollmentKelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure; // Optional: To skip rows that fail validation
use Maatwebsite\Excel\Validators\Failure;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class InsertSiswaKeKelasExcel implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        return new EnrollmentKelas([
            'ID_SISWA' => $row['id_siswa'],
            'ID_KELAS' => $row['id_kelas']
        ]);

    }
    public function headingRow(): int
    {
        return 1;
    }
    public function rules(): array
    {
        return [
            'id_kelas' => ['required', 'exists:Kelas,ID_KELAS'],
            'id_siswa' => ['required', 'exists:Siswa,ID_SISWA'],
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
