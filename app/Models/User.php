<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\Jetstream;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'timezone', 'password', 'current_team_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    
    /**
     * Get all of the team_user entries pertaining to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function team_user_entries() {
        return $this->hasMany(Jetstream::membershipModel());
    }

    public function teams() {
        return $this->hasManyThrough(Team::class, TeamUser::class, 'user_id', 'id', 'id', 'team_id');
    }

    public function histories() {
        return $this->hasManyThrough(History::class, TeamUser::class, 'user_id', 'team_user_id');
    }
    
    public function sales() {
        return $this->hasManyThrough(Sale::class, TeamUser::class, 'user_id', 'team_user_id');
    }

    public function historiesForTeam(Team $team) {
        return $this->belongsToMany(History::class, 'team_user', 'user_id', 'id', 'id', 'team_user_id')
            ->withPivot('team_id')
            ->wherePivot('team_id',$team->id);
    }

    public function salesForTeam(Team $team) {
        return $this->belongsToMany(Sale::class, 'team_user', 'user_id', 'id', 'id', 'team_user_id')
            ->withPivot('team_id')
            ->wherePivot('team_id',$team->id);
    }

    public function currentHistory(Team $team) {
        return $this->historiesForTeam($team)->firstWhere('end_time','>',now($this->timezone));
    }

    public function fullName() {
        return $this->first_name . ' ' . $this->last_name;
    }


}
