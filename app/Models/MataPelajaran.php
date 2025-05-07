<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'MATA_PELAJARAN';
    protected $primaryKey = 'ID_MATA_PELAJARAN';
    public $timestamps = false;
    protected $fillable = ['ID_MATA_PELAJARAN', 'ID_GURU', 'ID_PELAJARAN', 'ID_KELAS', 'JAM_PELAJARAN', 'HARI_PELAJARAN'];

    /**
     * Get the guru that teaches this mata pelajaran.
     */
    public function guru(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'ID_GURU', 'ID_GURU');
    }

    /**
     * Get the pelajaran that this mata pelajaran belongs to.
     */
    public function pelajaran(): BelongsTo
    {
        return $this->belongsTo(Pelajaran::class, 'ID_PELAJARAN', 'ID_PELAJARAN');
    }

    /**
     * Get the kelas that this mata pelajaran belongs to.
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'ID_KELAS', 'ID_KELAS');
    }

    /**
     * Get all of the materis for the MataPelajaran.
     */
    public function materis(): HasMany
    {
        return $this->hasMany(Materi::class, 'ID_MATA_PELAJARAN', 'ID_MATA_PELAJARAN');
    }

    /**
     * Get all of the nilai_kelas for the MataPelajaran.
     */
    public function nilaiKelas(): HasMany
    {
        return $this->hasMany(NilaiKelas::class, 'ID_MATA_PELAJARAN', 'ID_MATA_PELAJARAN');
    }

    /**
     * Get all of the pertemuans for the MataPelajaran.
     */
    public function pertemuans(): HasMany
    {
        return $this->hasMany(Pertemuan::class, 'ID_MATA_PELAJARAN', 'ID_MATA_PELAJARAN');
    }

    /**
     * Get all of the tugas for the MataPelajaran.
     */
    public function tugass(): HasMany
    {
        return $this->hasMany(Tugas::class, 'ID_MATA_PELAJARAN', 'ID_MATA_PELAJARAN');
    }
}