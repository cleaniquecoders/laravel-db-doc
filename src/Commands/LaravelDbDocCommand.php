<?php

namespace CleaniqueCoders\LaravelDbDoc\Commands;

use CleaniqueCoders\LaravelDbDoc\Processor;
use Illuminate\Console\Command;

class LaravelDbDocCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:schema {--database=} {--format=markdown}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate database schema to markdown (by default)';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Processor::make()
            ->connect(
                $this->option('database') ?? config('database.default'),
                $this->option('format')
            )
            ->process()
            ->render();
    }
}
