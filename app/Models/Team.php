<?php

namespace App\Models;

use App\Models\Sale;
use App\Models\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;

class Team extends JetstreamTeam
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'personal_team' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'personal_team',
        'target_commission'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => TeamCreated::class,
        'updated' => TeamUpdated::class,
        'deleted' => TeamDeleted::class,
    ];

    public function invoiceServiceToken() {
        return $this->hasMany(InvoiceServiceToken::class,'team_id','id')->first();
    }

    public function invoiceServiceTokens() {
        return $this->hasMany(InvoiceServiceToken::class, 'team_id', 'id');
    }

    public function teamUsers() {
        return $this->hasMany(TeamUser::class);
    }

    public function histories() {
        return $this->hasManyThrough(History::class,TeamUser::class,'team_id','team_user_id','id','id');
    }

    public function sales() {
        return $this->hasManyThrough(Sale::class, TeamUser::class, 'team_id','team_user_id','id','id');
    }

    public function historiesForUser(User $user) {
        return $this->belongsToMany(History::class, 'team_user', 'team_id', 'id', 'id', 'team_user_id')
            ->withPivot('user_id')    
            ->wherePivot('user_id',$user->id);
    }

    public function salesForUser(User $user) {
        return $this->belongsToMany(Sale::class, 'team_user', 'team_id', 'id', 'id', 'team_user_id')
            ->withPivot('user_id')
            ->wherePivot('user_id',$user->id);
    }

    public function usersOfRole($role) {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id')
            ->wherePivot('role',$role);
    }

    public function rules() {
        return $this->hasMany(Rule::class, 'team_id', 'id');
    }

    public function managers() {
        return $this->usersOfRole('manager');
    }

    public function employees() {
        return $this->usersOfRole('employee');
    }

}
