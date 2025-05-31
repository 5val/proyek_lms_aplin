<?php

namespace App\Imports;
use App\Models\MataPelajaran;
use App\Models\NilaiKelas;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure; // Optional: To skip rows that fail validation
use Maatwebsite\Excel\Validators\Failure;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class InsertNilaiExcel implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    private $id_mata_pelajaran;
    public function __construct($id_mata_pelajaran){
        $this->id_mata_pelajaran = $id_mata_pelajaran;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        
        $siswa = Siswa::where( 'ID_SISWA', $row['id_siswa'])->first();

        // Make sure $this->id_mata_pelajaran is available in the current scope
        $targetMataPelajaranId = $this->id_mata_pelajaran; // Get it once outside

        $isEnrolledInTargetSubject = Siswa::where('ID_SISWA', $siswa->ID_SISWA)
            ->whereHas('kelass', function ($queryKelas) use ($targetMataPelajaranId) { // Pass $targetMataPelajaranId
                $queryKelas->whereHas('mataPelajarans', function ($queryMataPelajaran) use ($targetMataPelajaranId) { // Pass $targetMataPelajaranId again
                    $queryMataPelajaran->where((new MataPelajaran)->getKeyName(), $targetMataPelajaranId);
                });
            })->exists();
        if(!$isEnrolledInTargetSubject){
           return; 
        }
        return new NilaiKelas([
            'ID_SISWA' => $row['id_siswa'],
            'ID_MATA_PELAJARAN' => $this->id_mata_pelajaran,
            'NILAI_UTS' => $row['nilai_uts'],
            'NILAI_UAS' => $row['nilai_uas'],
            'NILAI_TUGAS' => $row['nilai_tugas'],
            'NILAI_AKHIR' => $row['nilai_akhir'],
        ]);

    }
    public function headingRow(): int
    {
        return 1;
    }
    public function rules(): array
    {
        return [
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
