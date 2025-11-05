<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deduction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'type',
        'amount',
        'hub',
        'details',
        'date',
        'photos', // ✅ ADD THIS
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date',
        'photos' => 'array', // ✅ ADD THIS
    ];


        // Define enum values as a constant
    public const TYPES = [
        'shipping' => 'shipping',
        'vat' => 'vat',
        'printing' => 'printing',
        'packaging' => 'packaging',
        'domain_hosting' => 'domain_hosting',
        'license_fees' => 'license_fees',
        'bank_fees' => 'bank_fees',
        'purchases' => 'purchases',
        'returns' => 'returns',
        'refund' => 'refund',
        'tools_materials' => 'tools_materials',
        'operation' => 'operation',
        'misc' => 'misc',
    ];

    // Helper method to get all types
    public static function getTypes()
    {
        return self::TYPES;
    }

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

    // Helper method to get formatted label
    public function getTypeLabel()
    {
        return self::TYPES[$this->type] ?? ucfirst(str_replace('_', ' ', $this->type));
    }



}
