<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;

class Month extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'name_en',
        'name_ar',
    ];

    protected $casts = [
        'number' => 'integer',
    ];

    // relationships
    public function sales()
    {
        return $this->hasMany(Sale::class, 'month_id');
    }
}
