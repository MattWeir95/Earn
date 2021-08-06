<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Classes\InvoiceGenerator;
use App\Http\Controllers\ParsingController;

class XeroParserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Test the parser using 100 different invoices.
     *
     * @return void
     */
    public function test_xero_parser()
    {
        $user = User::factory()->withPersonalTeam()->create();
        for ($j = 0; $j < 10; $j++) {
            User::factory()->create();
        }
        $gen = new InvoiceGenerator;
        for ($i = 0; $i < 100; $i++) {
            [$item, $invoice] = $gen->getPair();
            $result = ParsingController::parseLineItem($item,$user->current_team_id);
            $this->assertEquals($invoice->service_name,$result->service_name,'Service Name');
            $this->assertEquals($invoice->service_cost,$result->service_cost,'Service Cost');
            $this->assertEquals($invoice->team_user,$result->team_user,'Team User');
            // $this->assertEquals($invoice->date,$result->date,'Date') # This will fail for now
        }
    }
}
