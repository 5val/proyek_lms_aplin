<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class EnrollmentKelas extends Model
{
    use HasFactory;

    protected $table = 'ENROLLMENT_KELAS';
    protected $primaryKey = ['ID_SISWA', 'ID_KELAS'];
    public $incrementing = false;
    public $timestamps = false;
    protected $casts = [
        'ID_KELAS' => 'string',
        'ID_SISWA' => 'string',
    ];
    protected $fillable = ['ID_SISWA', 'ID_KELAS'];

    /**
     * Get the siswa that owns the EnrollmentKelas.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'ID_SISWA', 'ID_SISWA');
    }

    /**
     * Get the kelas that owns the EnrollmentKelas.
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'ID_KELAS', 'ID_KELAS');
    }

    /**
     * Get the mata pelajaran through kelas.
     */
    public function mataPelajaran(): HasManyThrough
    {
        return $this->hasManyThrough(
            MataPelajaran::class, // Target model
            Kelas::class,          // Intermediate model
            'ID_KELAS',            // Foreign key on Kelas table
            'ID_KELAS',            // Foreign key on MataPelajaran table
            'ID_KELAS',            // Local key on EnrollmentKelas table
            'ID_KELAS'             // Local key on Kelas table
        );
    }
}