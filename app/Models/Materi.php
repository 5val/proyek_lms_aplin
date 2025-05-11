<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'MATERI';
    protected $primaryKey = 'ID_MATERI';
    public $timestamps = false;
    protected $fillable = ['ID_MATA_PELAJARAN', 'NAMA_MATERI', 'DESKRIPSI_MATERI', 'FILE_MATERI'];

    /**
     * Get the mataPelajaran that owns the Materi.
     */
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'ID_MATA_PELAJARAN', 'ID_MATA_PELAJARAN');
    }
}