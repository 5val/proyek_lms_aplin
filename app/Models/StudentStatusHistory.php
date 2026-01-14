<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'STUDENT_STATUS_HISTORY';
    protected $primaryKey = 'ID';
    public $timestamps = true;
    protected $fillable = [
        'ID_SISWA',
        'STATUS',
        'REASON',
        'EFFECTIVE_DATE',
        'CHANGED_BY',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'ID_SISWA', 'ID_SISWA');
    }
}
