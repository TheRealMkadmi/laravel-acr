<?php

namespace TheRealMkadmi\LaravelAcr;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use TheRealMkadmi\LaravelAcr\Commands\LaravelAcrCommand;

class LaravelAcrServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-acr')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_acr_table')
            ->hasCommand(LaravelAcrCommand::class);
    }
}
