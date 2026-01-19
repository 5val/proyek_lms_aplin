<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'PENGUMUMAN';
    protected $primaryKey = 'ID_PENGUMUMAN';
    public $timestamps = false;
    // Map to actual DB columns
    protected $fillable = ['JUDUL', 'ISI', 'TANGGAL'];
}