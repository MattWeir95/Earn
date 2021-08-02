<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'team_user_id',
        'service_name',
        'service_cost'
    ];
}
