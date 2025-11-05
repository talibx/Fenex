<?php

// app/Models/Transaction.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'type',
        'details',
        'amount',
        'date',
    ];


    // Define enum values as a constant
    public const SOURCES = [
        'amazon.ae' => 'Amazon.ae',
        'amazon.sa' => 'Amazon.sa',
        'noon' => 'Noon',
        'local_sales' => 'Local Sales',
        'local_purchase' => 'Local Purchase',
        'china_purchase' => 'China Purchase',
        'profit_withdrawal' => 'Profit Withdrawal',
        'other' => 'Other',
    ];

    // Helper method to get all hubs
    public static function getSources()
    {
        return self::SOURCES;
    }
}
