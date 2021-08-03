<?php

namespace Database\Factories;

use App\Models\Rule;
use Illuminate\Database\Eloquent\Factories\Factory;

class RuleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'team_id' =>1,
            'rule_name' => $this->faker->unique()->firstName(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'active' => $this->faker->boolean(),
            'percentage' =>$this->faker->numberBetween($min=1, $max=100)    
        ];
    }
}
