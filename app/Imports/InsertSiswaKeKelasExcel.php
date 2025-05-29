<?php

namespace App\Imports;
use App\Models\EnrollmentKelas;
use DB;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure; // Optional: To skip rows that fail validation
use Maatwebsite\Excel\Validators\Failure;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Throwable;


class InsertSiswaKeKelasExcel implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsOnError, WithChunkReading
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
            'id_kelas' => [
                'required', 
                'exists:Kelas,ID_KELAS', 
                ],
            'id_siswa' => ['required', 'exists:Siswa,ID_SISWA'],
        ];
    }

    public function onFailure(Failure ...$failures)
    {
        // Optional: Handle validation failures
        foreach ($failures as $failure) {
            // Log the row and error message
            \Log::warning(sprintf('Row %s: %s', $failure->row(), implode(', ', array: $failure->errors())));
        }
    }
    public function onError(Throwable $e)
    {
        // Handle database exceptions (like duplicate entry)
        // This will allow the import to continue
        \Log::error(sprintf('Database Error - Row (unknown, as it happened during save): %s - %s', $e->getMessage(), $e->getTraceAsString()));

    }
    public function chunkSize(): int
    {
        return 1000; // You can adjust this number based on your server's memory limits
                     // Common values are 500, 1000, 2000.
    }
}
