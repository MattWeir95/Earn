<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\TeamUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;


class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'timezone' => $this->faker->timezone,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'current_team_id' => null
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function onTeam(Team $team) {
        return $this->state([
            'current_team_id' => $team->id
        ])->has(TeamUser::factory()->asRole('employee')
            ->state(function (array $att, User $user) {
                return ['team_id' =>$user->current_team_id, 'user_id' => $user->id];
        }),'team_user_entries');
    }

    /**
     * Indicate that the user should have a personal team.
     *
     * @return $this
     */
    public function withPersonalTeam()
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }
        $new_team_f = Team::factory()
            ->state(function (array $attributes, User $user) {
                return ['name' => $user->first_name . '\'s Team', 'user_id' => $user->id, 'personal_team' => true,
                'target_commission' => 100];
        });
        $team_user_f = TeamUser::factory()->asManager()
            ->state(function (array $attributes, User $user) {
                return ['team_id' => $user->currentTeam->id, 'user_id' => $user->id];
            });

        return $this->has(
            $new_team_f,
            'ownedTeams'
        )->has(
            $team_user_f,
            'team_user_entries'
        );
    }
}
