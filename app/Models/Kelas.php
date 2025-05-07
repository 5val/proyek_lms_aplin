<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'KELAS';
    protected $primaryKey = 'ID_KELAS';
    public $timestamps = false;
    protected $fillable = ['ID_KELAS', 'ID_DETAIL_KELAS', 'ID_GURU', 'ID_PERIODE'];

    /**
     * Get the detailKelas that owns the Kelas.
     */
    public function detailKelas(): BelongsTo
    {
        return $this->belongsTo(DetailKelas::class, 'ID_DETAIL_KELAS', 'ID_DETAIL_KELAS');
    }

    /**
     * Get the guru that is the wali kelas of the Kelas.
     */
    public function wali(): BelongsTo
    {
        return $this->belongsTo(Guru::class, 'ID_GURU', 'ID_GURU');
    }

    /**
     * Get the periode that owns the Kelas.
     */
    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class, 'ID_PERIODE', 'ID_PERIODE');
    }

    /**
     * Get all of the mata_pelajarans in this kelas.
     */
    public function mataPelajarans(): HasMany
    {
        return $this->hasMany(MataPelajaran::class, 'ID_KELAS', 'ID_KELAS');
    }

    /**
     * The siswa that belong to the Kelas.
     */
    public function siswas(): BelongsToMany
    {
        return $this->belongsToMany(Siswa::class, 'ENROLLMENT_KELAS', 'ID_KELAS', 'ID_SISWA');
    }
}