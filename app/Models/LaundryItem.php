<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaundryItem extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'laundry_items';

    protected $fillable = [
        'laundry_id',
        'laundry_category_id',
        'weight',
        'unit_price',
        'amount',
    ];

    public function category()
    {
        return $this->belongsTo(LaundryCategory::class, 'laundry_category_id');
    }
}
