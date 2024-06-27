<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyList extends Model
{
    use HasFactory;

    protected $table = 'supply_list';

    protected $fillable = [
        'name'
    ];

    public $timestamps = false;
}
