<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class RunDeploy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-deploy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deploy the application';

    public function handle()
    {
        if (Cache::pull('deploy_trigger')) {
            $this->info("Starting deploy...");
            exec('/var/www/ipoop.app.br/ipoop/deploy.sh >> /tmp/deploy.log 2>&1');
            $this->info("Deployed.");
        } else {
            $this->info("No pending deploys.");
        }
    }

}
