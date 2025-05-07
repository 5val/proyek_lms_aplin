<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SubmissionTugas extends Model
{
    use HasFactory;

    protected $table = 'SUBMISSION_TUGAS';
    protected $primaryKey = 'ID_SUBMISSION';
    public $timestamps = false;
    protected $fillable = ['ID_SUBMISSION', 'ID_SISWA', 'ID_TUGAS', 'TANGGAL_SUBMISSION', 'NILAI_TUGAS'];

    /**
     * Get the siswa that owns the SubmissionTugas.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'ID_SISWA', 'ID_SISWA');
    }

    /**
     * Get the tugas that owns the SubmissionTugas.
     */
    public function tugas(): BelongsTo
    {
        return $this->belongsTo(Tugas::class, 'ID_TUGAS', 'ID_TUGAS');
    }
}