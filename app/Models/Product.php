<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'main_photo',
        'photos',
        'cost_of_goods',
        'weight',
    ];

    // cast photos to array when reading from DB
    protected $casts = [
        'photos' => 'array',
    ];


     public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
