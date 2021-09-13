<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\History;
use App\Models\TeamUser;
use App\Classes\InvoiceGenerator;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Http\Controllers\RuleController;

class SaleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $gen = new InvoiceGenerator;
        $invoice = $gen->getInvoice();
        return [
            'team_user_id' => $invoice->team_user->id,
            'service_name' => $invoice->service_name,
            'service_cost' => $invoice->service_cost,
            'commission_paid' => RuleController::getCommission($invoice),
            'date' => $invoice->date
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Sale $sale) {
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
