<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NilaiKelas extends Model
{
    use HasFactory;

    protected $table = 'NILAI_KELAS';
    protected $primaryKey = 'ID_NILAI';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['ID_NILAI', 'ID_SISWA', 'ID_MATA_PELAJARAN', 'NILAI_UTS', 'NILAI_UAS', 'NILAI_TUGAS', 'NILAI_AKHIR'];

    /**
     * Get the siswa that owns the NilaiKelas.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'ID_SISWA', 'ID_SISWA');
    }

    /**
     * Get the mataPelajaran that owns the NilaiKelas.
     */
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'ID_MATA_PELAJARAN', 'ID_MATA_PELAJARAN');
    }
}