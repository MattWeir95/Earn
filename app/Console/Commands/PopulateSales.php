<?php

namespace App\Console\Commands;

use App\Models\Sale;
use App\Models\Sales;
use App\Models\User;

use Illuminate\Console\Command;

class PopulateSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate:sales {num_entries}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate the history and sales tables with mock data';

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
        if (is_null(User::first())) {
            $user = User::factory()->withPersonalTeam()->create();
            $user->currentTeam->users()->attach(
                User::factory()->withPersonalTeam()->create(),
                ['role' => 'employee']
            );
        }
        Sale::factory()
            ->count($this->argument('num_entries'))
            ->sequence(fn ($sequence) => ['date' => now('AEST')->subDays($sequence->index)])
            ->create();
        return 0;
    }
}
