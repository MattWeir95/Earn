<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Jetstream\Membership;

class TeamUser extends Membership
{
    use HasFactory;

    protected $table = "team_user";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id',
        'user_id',
        'role'
    ];

    protected $attributes = [
        'role' => null
    ];
}
