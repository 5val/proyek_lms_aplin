<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeeCategory extends Model
{
    use HasFactory;

    protected $table = 'FEE_CATEGORIES';
    protected $primaryKey = 'ID_CATEGORY';
    public $timestamps = true;
    protected $fillable = ['NAME', 'STATUS'];

    public function components(): HasMany
    {
        return $this->hasMany(FeeComponent::class, 'ID_CATEGORY', 'ID_CATEGORY');
    }
}
