<?php

namespace App\Imports;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure; // Optional: To skip rows that fail validation
use Maatwebsite\Excel\Validators\Failure;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class InsertGuruExcel implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        return new Guru([
            'NAMA_GURU' => $row['nama_guru'],
            'EMAIL_GURU' => $row['email'],
            // nyalain
            // 'PASSWORD_GURU' => Hash::make($password),
            'PASSWORD_GURU' => $row['password'],
            'ALAMAT_GURU' => $row['alamat'],
            'NO_TELPON_GURU' => $row['no_telpon'],
            'STATUS_GURU' => 'Active',
        ]);

    }
    public function headingRow(): int
    {
        return 1;
    }
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', Rule::unique('guru', 'EMAIL_GURU')],
            'nama_guru' => 'required',
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
