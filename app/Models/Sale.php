<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Year;
use App\Models\Month;
use App\Models\User;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sales';

    protected $fillable = [
        'year_id',
        'month_id',
        'hub',
        'user_id',
        'file_path',
        'order_sold',
        'order_returned',
        'total_revenue',
        'total_cost',
        'total_profit',
        'details',
        'photos', // ✅ ADD THIS
    ];

    protected $casts = [
        'order_sold' => 'integer',
        'order_returned' => 'integer',
        'total_revenue' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'total_profit' => 'decimal:2',
        'photos' => 'array', // ✅ ADD THIS - Automatically converts JSON to array
    ];

    // Define enum values as a constant
    public const HUBS = [
        'amazon.ae' => 'Amazon.ae',
        'amazon.sa' => 'Amazon.sa',
        'noon' => 'Noon',
        'local' => 'Local',
        'other' => 'Other',
    ];

    // Helper method to get all types
    public static function getHubs()
    {
        return self::HUBS;
    }

    // relationships
    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }

    public function month()
    {
        return $this->belongsTo(Month::class, 'month_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
