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

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function team() {
        return $this->hasOne(Team::class, 'id', 'team_id');
    }

    public function histories() {
        return $this->hasMany(History::class, 'team_user_id', 'id');
    }

    public function sales() {
        return $this->hasMany(Sale::class, 'team_user_id', 'id');
    }

    public function currentHistory() {
        return $this->histories()->firstWhere('end_time','>',now($this->user()->first()->timezone));
    }
}
