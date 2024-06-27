<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';

    protected $fillable = [
        'supply_id',
        'qty',
        'stock_type',
        'date_created'
    ];

    public $timestamps = false;

    protected $dates = [
        'date_created'
    ];
}
