<?php

namespace App\Actions\Fortify;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'timezone' => ['required', 'string', 'max: 255'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        return DB::transaction(function () use ($input) {
            return User::factory()->withPersonalTeam()->create([
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'email' => $input['email'],
                'timezone' => $input['timezone'],
                'password' => Hash::make($input['password']),
            ]);
        });
    }

    /**
     * Create a personal team for the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function createTeam(User $user)
    {
        $team = Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->first_name . " " . $user->last_name, 2)[0]."'s Team",
            'personal_team' => true,
            'target_commission' => 100
        ]);
        $user = $user->ownedTeams()->save($team);
        $user->save(['current_team_id' => $team->id]);
    }
}
