<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pertemuan extends Model
{
    use HasFactory;

    protected $table = 'PERTEMUAN';
    protected $primaryKey = 'ID_PERTEMUAN';
    public $timestamps = false;
    protected $fillable = ['ID_PERTEMUAN', 'ID_MATA_PELAJARAN', 'DETAIL_PERTEMUAN', 'TANGGAL_PERTEMUAN'];

    /**
     * Get the mataPelajaran that owns the Pertemuan.
     */
    public function mataPelajaran(): BelongsTo
    {
        return $this->belongsTo(MataPelajaran::class, 'ID_MATA_PELAJARAN', 'ID_MATA_PELAJARAN');
    }

    /**
     * Get all of the attendances for the Pertemuan.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'ID_PERTEMUAN', 'ID_PERTEMUAN');
    }
}