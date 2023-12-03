<?php

namespace CleaniqueCoders\LaravelDbDoc;

use CleaniqueCoders\LaravelDbDoc\Commands\LaravelDbDocCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelDbDocServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-db-doc')
            ->hasConfigFile()
            ->hasViews('laravel-db-doc')
            ->hasCommand(LaravelDbDocCommand::class);
    }
}
