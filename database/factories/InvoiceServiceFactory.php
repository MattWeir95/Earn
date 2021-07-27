<?php

namespace Database\Factories;
use App\Models\InvoiceService;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceServiceFactory extends Factory
{
   /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceService::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'app_name' => 'Xero',
        ];
    }
}
