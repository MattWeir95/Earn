<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\TeamUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use NunoMaduro\Collision\Adapters\Phpunit\State;

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

    //This function fails the team control tests--------------
    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            if ($user->current_team_id == null) {
                $team = Team::orderBy('id','desc')->first();
                if (is_null($team)) {
                    $team_id = 0;
                } else {
                    $team_id = $team->id;
                }
            } else {
                $team_id = $user->current_team_id;
            }
            TeamUser::factory()->create([
                'team_id' => $team_id,
                'user_id' => $user->id
            ]);
            $user->current_team_id = $team_id;
            $user->save();
        });
    }
  //-----------------------------------------------------------  
    

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
                return ['name' => $user->first_name . '\'s Team', 'user_id' => $user->id, 'personal_team' => true];
        });

        return $this->has(
            $new_team_f,
            'ownedTeams'
        );
    }
}
