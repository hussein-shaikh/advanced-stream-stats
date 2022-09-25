<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscriptions extends Model
{
    use HasFactory;

protected $guarded = ["id"];
    public function packages()
    {
        return BelongsTo(packages::class, 'package_id');
    }

    public function user(){
        return BelongsTo(User::class,"user_id");
    }
}
