<?php

namespace Database\Factories;

use App\Models\Sales;
use App\Models\History;
use App\Models\TeamUser;
use App\Classes\InvoiceGenerator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sales::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gen = new InvoiceGenerator;
        return $gen->getInvoice()->asSale();
    }

    public function configure()
    {
        return $this->afterCreating(function (Sales $sale) {
            $p_his = History::where('team_user_id','=',$sale->team_user_id)
                ->firstWhere('start_time','=',$sale->date->copy()->startOfMonth());
            if (is_null($p_his)) {
                History::factory()->create([
                    'team_user_id' => $sale->team_user_id,
                    'start_time' => $sale->date->copy()->startOfMonth(),
                    'end_time' => $sale->date->copy()->endOfMonth(),
                    'total_commission' => $sale->commission_paid
                ]);
            } else {
                $p_his->total_commission += $sale->commission_paid;
                $p_his->save();
            }
            return $this->state([]);
        });
    }
}
