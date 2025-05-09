<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelajaran extends Model
{
    use HasFactory;

    protected $table = 'PELAJARAN';
    protected $primaryKey = 'ID_PELAJARAN';
    protected $keyType = 'string';
   public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['ID_PELAJARAN', 'NAMA_PELAJARAN'];

    /**
     * Get all of the mata_pelajarans for the Pelajaran.
     */
    public function mataPelajarans(): HasMany
    {
        return $this->hasMany(MataPelajaran::class, 'ID_PELAJARAN', 'ID_PELAJARAN');
    }
}