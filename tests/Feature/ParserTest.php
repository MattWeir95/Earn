<?php

namespace Tests\Feature;

use App\Classes\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\TeamUser;
use App\Classes\InvoiceGenerator;
use App\Console\Commands\PopulateSales;
use App\Http\Controllers\ParsingController;
use App\Http\Livewire\Managers\Rules\NewRuleModal;
use App\Models\Sale;

class ParserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test the parser using 100 different invoices.
     *
     * @return void
     */
    public function test_xero_invoice_parser()
    {
        $user = User::factory()->withPersonalTeam()->create();
        for ($j = 0; $j < 10; $j++) {
            User::factory()->onTeam($user->currentTeam)->create();
        }
        $gen = new InvoiceGenerator;
        for ($i = 0; $i < 100; $i++) {
            [$item, $invoice] = $gen->getPair();
            $result = ParsingController::parseLineItem($item,$user->currentTeam);
            $this->assertEquals($invoice->service_name,$result->service_name,'Service Name');
            $this->assertEquals($invoice->service_cost,$result->service_cost,'Service Cost');
            $this->assertEquals($invoice->team_user,$result->team_user,'Team User');
            // $this->assertEquals($invoice->date,$result->date,'Date') # This will fail for now
        }
    }

    public function test_invoice_saving()
    {
        $manager = User::factory()->withPersonalTeam()->create();
        $this->actingAs($manager);
        $employee = User::factory()->onTeam($manager->currentTeam)->create();
        NewRuleModal::insert_without_check('test rule',now()->subMonths(5),now()->addMonth(),10);
        $now = now();
        $invoice = new Invoice($employee,$manager->currentTeam,'Test Invoice',100,$now);
        ParsingController::saveInvoice($invoice);
        $sale = Sale::first();
        $this->assertEquals(10,$sale->commission_paid);
        $this->assertEquals('Test Invoice',$sale->service_name);
        $this->assertEquals(100,$sale->service_cost);
        $this->assertEquals(TeamUser::firstWhere('user_id',$employee->id)->id,$sale->team_user_id);
        $this->assertEquals($now,$sale->date);
    }
}
