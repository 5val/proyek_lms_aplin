<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'GURU';
    protected $primaryKey = 'ID_GURU';
    public $timestamps = false;

    protected $casts = [
        'ID_GURU' => 'string',
    ];
    protected $fillable = ['NAMA_GURU', 'EMAIL_GURU', 'PASSWORD_GURU', 'ALAMAT_GURU', 'NO_TELPON_GURU', 'STATUS_GURU'];

    /**
     * Get all of the kelas where this guru is the wali kelas.
     */
    public function waliKelas(): HasMany
    {
        return $this->hasMany(Kelas::class, 'ID_GURU', 'ID_GURU');
    }

    /**
     * Get all of the mata_pelajarans taught by this guru.
     */
    public function mataPelajarans(): HasMany
    {
        return $this->hasMany(MataPelajaran::class, 'ID_GURU', 'ID_GURU');
    }
}