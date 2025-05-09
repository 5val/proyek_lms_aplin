<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DetailKelas extends Model
{
    use HasFactory;

    protected $table = 'DETAIL_KELAS';
    protected $primaryKey = 'ID_DETAIL_KELAS';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $casts = [
        'ID_DETAIL_KELAS' => 'string',
    ];
    protected $fillable = ['ID_DETAIL_KELAS', 'RUANGAN_KELAS', 'NAMA_KELAS'];

    /**
     * Get all of the kelas for the DetailKelas.
     */
    public function kelas(): HasMany
    {
        return $this->hasMany(Kelas::class, 'ID_DETAIL_KELAS', 'ID_DETAIL_KELAS');
    }
}