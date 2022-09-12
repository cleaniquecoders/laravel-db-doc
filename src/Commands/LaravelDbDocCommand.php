<?php

namespace Bekwoh\LaravelDbDoc\Commands;

use Illuminate\Console\Command;

class LaravelDbDocCommand extends Command
{
    public $signature = 'laravel-db-doc';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
