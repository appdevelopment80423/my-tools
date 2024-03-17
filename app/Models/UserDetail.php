<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    public $table = 'users_details';

    public $timestamps = false;

    public function matchingReferrals()
    {
        return $this->hasMany(UserDetail::class, 'referral_code', 'pin');
    }
    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(UserDetail::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(UserDetail::class, 'parent_id');
    }


}
