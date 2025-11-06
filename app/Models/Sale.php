<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sales';

    protected $fillable = [
        'hub',
        'user_id',
        'file_path',
        'date',
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

    public const YEARS = [
        '2022' => '2022',
        '2023' => '2023',
        '2024' => '2024',
        '2025' => '2025',
        '2026' => '2026',
        '2027' => '2027',
    ];
    
    public const MONTHS = [
        'january' => 'January',
        'february' => 'February',
        'march' => 'March',
        'april' => 'April',
        'may' => 'May',
        'june' => 'June',
        'july' => 'July',
        'august' => 'August',
        'september' => 'September',
        'october' => 'October',
        'november' => 'November',
        'december' => 'December',
    ];

    public static function getMonths()
    {
        return self::MONTHS;
    }
    
    public static function getYears()
    {
        return self::YEARS;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
