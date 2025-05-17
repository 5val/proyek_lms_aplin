<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'SISWA';
    protected $primaryKey = 'ID_SISWA';
    public $timestamps = false;
    protected $casts = [
        'ID_SISWA' => 'string',
    ];
    protected $fillable = ['ID_SISWA', 'NAMA_SISWA', 'EMAIL_SISWA', 'PASSWORD_SISWA', 'ALAMAT_SISWA', 'NO_TELPON_SISWA', 'STATUS_SISWA'];
    protected $hidden = ['PASSWORD_SISWA'];

    /**
     * Get all of the attendances for the Siswa.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'ID_SISWA', 'ID_SISWA');
    }

    /**
     * Get all of the nilai_kelas for the Siswa.
     */
    public function nilaiKelas(): HasMany
    {
        return $this->hasMany(NilaiKelas::class, 'ID_SISWA', 'ID_SISWA');
    }

    /**
     * Get all of the submission_tugas for the Siswa.
     */
    public function submissionTugas(): HasMany
    {
        return $this->hasMany(SubmissionTugas::class, 'ID_SISWA', 'ID_SISWA');
    }

    /**
     * The kelass that belong to the Siswa.
     */
    public function kelass(): BelongsToMany
    {
        return $this->belongsToMany(Kelas::class, 'ENROLLMENT_KELAS', 'ID_SISWA', 'ID_KELAS');
    }
}