<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaundryList extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'laundry_list';

    protected $fillable = [
        'customer_name',
        'status',
        'remarks',
        'pay_status',
        'amount_tendered',
        'total_amount',
        'amount_change',
        'queue',
    ];

    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $keyType = 'int';
    
    public function items()
    {
        return $this->hasMany(LaundryItem::class, 'laundry_id');
    }
}
