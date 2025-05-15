<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tugas extends Model
{
    use HasFactory;

    protected $table = 'TUGAS';
    protected $primaryKey = 'ID_TUGAS';
    protected $keyType = 'string';
    public $timestamps = false;
    protected $casts = [
        'ID_MATA_PELAJARAN' => 'string',
    ];
    protected $fillable = ['ID_TUGAS', 'ID_MATA_PELAJARAN', 'NAMA_TUGAS', 'DESKRIPSI_TUGAS', 'DEADLINE_TUGAS'];

    /**
     * Get the mataPelajaran that owns the Tugas.
     */
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'ID_MATA_PELAJARAN', 'ID_MATA_PELAJARAN');
    }
}