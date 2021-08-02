<?php

namespace Database\Factories;

use App\Models\History;
use Illuminate\Database\Eloquent\Factories\Factory;

class HistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = History::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'team_user_id' => null,
            'start_time' => now(),
            'end_time' => now(),
            'total_commission' => null,
            'flagged' => FALSE,
            'approved' => FALSE
        ];
    }
}
