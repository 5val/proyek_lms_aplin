<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'PAYMENTS';
    protected $primaryKey = 'ID_PAYMENT';
    public $timestamps = true;
    protected $casts = [
        'RAW_PAYLOAD' => 'array',
        'PAID_AT' => 'datetime',
    ];
    protected $fillable = [
        'ID_STUDENT_FEE',
        'PAID_AMOUNT',
        'PAID_AT',
        'METHOD',
        'MIDTRANS_TXN_ID',
        'STATUS',
        'RAW_PAYLOAD',
    ];

    public function studentFee(): BelongsTo
    {
        return $this->belongsTo(StudentFee::class, 'ID_STUDENT_FEE', 'ID_STUDENT_FEE');
    }
}
