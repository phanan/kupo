<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Init extends Command
{
    protected $signature = 'kupo:init';
    protected $description = 'Install or upgrade kupo';
    private $artisan;

    public function __construct(Artisan $artisan)
    {
        parent::__construct();
        
        $this->artisan = $artisan;
    }

    public function handle(): void
    {
        $this->comment('Attempting to install or upgrade kupo.');
        $this->comment('Remember, you can always install/upgrade manually following the guide here:');
        $this->info('📙  https://github.com/phanan/kupo'.PHP_EOL);

        if (!config('app.key')) {
            $this->info('Generating app key');
            $this->artisan->call('key:generate');
        } else {
            $this->comment('App key exists -- skipping');
        }

        $this->info('Executing yarn install, gulp and whatnot');
        system('yarn install');

        $this->comment(PHP_EOL.'🎆  Success! You can now run kupo from localhost with `php artisan serve`.');
        $this->comment('Again, for more info, refer to');
        $this->info('📙  https://github.com/phanan/kupo.');
        $this->info('Thanks for using kupo!');
    }
}
