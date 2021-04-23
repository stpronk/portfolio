<?php

namespace Stpronk\Core\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stpronk:core-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the default scaffolding of core stpronk packages';

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function handle()
    {
        $this->info('Work in progress... this command does nothing as of this moment');
    }
}
