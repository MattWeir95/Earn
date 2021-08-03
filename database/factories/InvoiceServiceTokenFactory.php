<?php

namespace Database\Factories;

use App\Models\InvoiceService;
use App\Models\Team;
use App\Models\InvoiceServiceToken;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceServiceTokenFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceServiceToken::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $x = InvoiceService::factory()->create();
        return [
            'team_id' => Team::factory(),
            'app_id' => $x->id,
            'api_id' => '1234',
            'app_name' => $x->app_name,
            'access_token' => '5678'
        ];
    }
}
