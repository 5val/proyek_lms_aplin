<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentFee extends Model
{
    use HasFactory;

    protected $table = 'STUDENT_FEES';
    protected $primaryKey = 'ID_STUDENT_FEE';
    public $timestamps = true;
    protected $fillable = [
        'ID_SISWA',
        'ID_PERIODE',
        'ID_COMPONENT',
        'AMOUNT',
        'DUE_DATE',
        'STATUS',
        'INVOICE_CODE',
        'MIDTRANS_ORDER_ID',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'ID_SISWA', 'ID_SISWA');
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class, 'ID_PERIODE', 'ID_PERIODE');
    }

    public function component(): BelongsTo
    {
        return $this->belongsTo(FeeComponent::class, 'ID_COMPONENT', 'ID_COMPONENT');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'ID_STUDENT_FEE', 'ID_STUDENT_FEE');
    }
}
