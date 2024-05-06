<?php

namespace Apydevs\Customers\Models;

use Apydevs\Orders\Models\Order;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes; // Include the SoftDeletes trait

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'date_of_birth',
        'address_line1', 'address_line2', 'city', 'state', 'country', 'postal_code',
        'user_id', 'account_reference'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get the Customer's Whole name.
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($this->first_name).' '.ucfirst($this->last_name),
        );
    }


    public static function generateAccountReference()
    {
        return 'ACCT-' . time() . Str::random(12);
    }


    /**
     * Requires Orders Module to be installed.
     * ApyDevs/orders
     * @return HasMany
     */
    public function orders(){
        return $this->hasMany(Order::class,'customer_id','id');
    }
}
