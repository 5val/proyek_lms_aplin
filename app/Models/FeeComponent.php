<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeeComponent extends Model
{
    use HasFactory;

    protected $table = 'FEE_COMPONENTS';
    protected $primaryKey = 'ID_COMPONENT';
    public $timestamps = true;
    protected $fillable = ['NAME', 'AMOUNT_DEFAULT', 'TYPE', 'ID_CATEGORY', 'DESCRIPTION', 'STATUS', 'AUTO_BILL'];

    public function studentFees(): HasMany
    {
        return $this->hasMany(StudentFee::class, 'ID_COMPONENT', 'ID_COMPONENT');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(FeeCategory::class, 'ID_CATEGORY', 'ID_CATEGORY');
    }
}
