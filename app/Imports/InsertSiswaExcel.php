<?php

namespace App\Imports;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure; // Optional: To skip rows that fail validation
use Maatwebsite\Excel\Validators\Failure;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class InsertSiswaExcel implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        return new Siswa([
            'NAMA_SISWA' => $row['nama_siswa'],
            'EMAIL_SISWA' => $row['email'],
            // nyalain
            // 'PASSWORD_SISWA' => Hash::make($password),
            'PASSWORD_SISWA' => $row['password'],
            'ALAMAT_SISWA' => $row['alamat'],
            'NO_TELPON_SISWA' => $row['no_telpon'],
            'STATUS_SISWA' => 'Active',
        ]);

    }
    public function headingRow(): int
    {
        return 1;
    }
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', Rule::unique('siswa', 'EMAIL_SISWA')],
            'nama_siswa' => 'required',
            'password' => 'required',
            'alamat' => 'required',
            'no_telpon' => 'required',
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
