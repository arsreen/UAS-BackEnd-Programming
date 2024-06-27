<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaundryCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'laundry_categories';
    protected $fillable = [
        'name',
        'price'
    ];

}
