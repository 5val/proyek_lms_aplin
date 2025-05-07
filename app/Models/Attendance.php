<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'ATTENDANCE';
    protected $primaryKey = 'ID_ATTENDANCE';
    public $timestamps = false;
    protected $fillable = ['ID_ATTENDANCE', 'ID_SISWA', 'ID_PERTEMUAN'];

    /**
     * Get the siswa that owns the Attendance.
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'ID_SISWA', 'ID_SISWA');
    }

    /**
     * Get the pertemuan that owns the Attendance.
     */
    public function pertemuan(): BelongsTo
    {
        return $this->belongsTo(Pertemuan::class, 'ID_PERTEMUAN', 'ID_PERTEMUAN');
    }
}