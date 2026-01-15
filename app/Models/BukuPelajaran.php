<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BukuPelajaran extends Model
{
    use HasFactory;

    protected $table = 'BUKU_PELAJARAN';
    protected $primaryKey = 'ID_BUKU';
    public $timestamps = true;

    protected $fillable = [
        'JUDUL',
        'DESKRIPSI',
        'FILE_PATH',
        'FILE_SIZE',
        'FILE_EXT',
        'MIME_TYPE',
        'KATEGORI',
        'WATERMARK_TEXT',
        'STATUS',
        'UPLOADED_BY',
    ];

    public function kelas(): BelongsToMany
    {
        return $this->belongsToMany(Kelas::class, 'BUKU_PELAJARAN_KELAS', 'ID_BUKU', 'ID_KELAS');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'UPLOADED_BY', 'id');
    }
}
