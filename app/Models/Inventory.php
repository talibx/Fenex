<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventories'; // Specify your table name here

    protected $fillable = [
        'product_id',
        'quantity',
        'condition',
        'inventory_actions',
        'details',
        'photos', // ✅ ADD THIS
    ];

    protected $casts = [
        'quantity' => 'integer',
        'photos' => 'array', // ✅ ADD THIS
    ];


     public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
