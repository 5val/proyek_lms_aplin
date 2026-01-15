<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalKelas extends Model
{
    use HasFactory;

    protected $table = 'JADWAL_KELAS';
    protected $primaryKey = 'ID_JADWAL';
    public $timestamps = true;

    protected $fillable = [
        'ID_KELAS',
        'ID_MATA_PELAJARAN',
        'ID_JAM_PELAJARAN',
        'ID_RUANGAN',
    ];
}
