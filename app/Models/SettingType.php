<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingType extends Model
{
    use HasFactory;

    public $table = 'setting_types';

    public $timestamps = false;

    protected $fillable = [
        'type',
        'status'
    ];
}
