<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sale;

class Year extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'year' => 'integer',
    ];

    // relationships
    public function sales()
    {
        return $this->hasMany(Sale::class, 'year_id');
    }
}
