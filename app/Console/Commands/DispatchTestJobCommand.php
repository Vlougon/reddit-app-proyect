<?php

namespace App\Console\Commands;

use App\Jobs\TestJob;
use Illuminate\Console\Command;

class DispatchTestJobCommand extends Command
{
    protected $signature = 'dispatch:test-job';

    protected $description = 'Dispatch a test job';
    
    public function handle()
     {
    
     dispatch(new TestJob());
    
     $this->info('Test job dispatched.');
    
     }
}
