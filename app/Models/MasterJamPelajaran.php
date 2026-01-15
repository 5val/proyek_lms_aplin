<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterJamPelajaran extends Model
{
    use HasFactory;

    protected $table = 'MASTER_JAM_PELAJARAN';
    protected $primaryKey = 'ID_JAM_PELAJARAN';
    public $timestamps = false;
    protected $fillable = [
        'HARI_PELAJARAN',
        'SLOT_KE',
        'JENIS_SLOT',
        'JAM_MULAI',
        'JAM_SELESAI',
        'LABEL',
    ];
}
