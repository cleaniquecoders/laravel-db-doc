<?php

namespace Bekwoh\LaravelDbDoc;

use Bekwoh\LaravelDbDoc\Commands\LaravelDbDocCommand;
use Bekwoh\LaravelDbDoc\Facades\LaravelDbDoc;
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
            ->hasViews()
            ->hasCommand(LaravelDbDocCommand::class);
    }

    public function bootingPackage()
    {
        LaravelDbDoc::routes();
    }
}
