<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Periode extends Model
{
    use HasFactory;

    protected $table = 'PERIODE';
    protected $primaryKey = 'ID_PERIODE';
    public $timestamps = false;
    protected $fillable = ['PERIODE', 'ID_PERIODE'];
    public $autoIncrement = true;

    /**
     * Get all of the kelas for the Periode.
     */
    public function kelass(): HasMany
    {
        return $this->hasMany(Kelas::class, 'ID_PERIODE', 'ID_PERIODE');
    }
}