<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PaymentDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected static function boot()
    {
        // Boot other traits on the Model
        parent::boot();

        /**
         * Listen for the creating event on the user model.
         * Sets the 'id' to a UUID using Str::uuid() on the instance being created
         */
        static::creating(function ($model) {
            if ($model->getKey() === null) {
                $model->setAttribute($model->getKeyName(), Str::uuid()->toString());
            }
        });
    }

    protected $fillable = ["id", "user_id", "package_id", "transaction_id", "amount", "payment_gateway", "payment_status"];


    protected $table = "payment_details";


    public function getIncrementing()
    {
        return false;
    }


    public function getKeyType()
    {
        return 'string';
    }
}
