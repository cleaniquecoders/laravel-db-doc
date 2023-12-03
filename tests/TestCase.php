<?php

namespace CleaniqueCoders\LaravelDbDoc\Tests;

use CleaniqueCoders\LaravelDbDoc\Facades\LaravelDbDoc;
use CleaniqueCoders\LaravelDbDoc\LaravelDbDocServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'CleaniqueCoders\\LaravelDbDoc\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelDbDocServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        LaravelDbDoc::routes();

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-db-doc_table.php.stub';
        $migration->up();
        */
    }
}
