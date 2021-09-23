<?php

namespace App\Console\Commands;

use App\Models\InvoiceService;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PopulateDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate:db {employees} {num_of_sales}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate the database with one manager and x employees. Creates one rule spanning the timeframe of previous sales and populates sales with mock data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user = User::factory()->withPersonalTeam()->create();
        for ($i = 0; $i < $this->argument('employees'); $i++) {
            $newUser = User::factory()->withPersonalTeam()->create();
            $user->currentTeam->users()->attach(
                $newUser,
                ['role' => 'employee']
            );
        }
        InvoiceService::factory()->create();
        
        DB::table('rules')
            ->insert([
                'team_id' => $user->currentTeam->id,
                'rule_name' => "Example Rule",
                'start_date' => now('AEST')->subDays($this->argument('num_of_sales')),
                'end_date' => now('AEST'),
                'active' => 1,
                'percentage' => rand(10, 20)
            ]);

        Sale::factory()
            ->count($this->argument('num_of_sales'))
            ->sequence(fn ($sequence) => ['date' => now('AEST')->subDays($sequence->index)])
            ->create();
        return 0;
        
    }
}
