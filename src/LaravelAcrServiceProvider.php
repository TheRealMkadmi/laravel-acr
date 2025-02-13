<?php

namespace TheRealMkadmi\LaravelAcr;

use GuzzleHttp\Client;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use TheRealMkadmi\LaravelAcr\Commands\LaravelAcrCommand;
use TheRealMkadmi\LaravelAcr\Transport\AzureMailTransport;

class LaravelAcrServiceProvider extends PackageServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/azuremail.php', 'azuremail');
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-acr')
            ->hasConfigFile();
        }

    public function boot()
    {
        // Publish configuration to the application's config directory.
        $this->publishes([
            __DIR__.'/../config/azuremail.php' => config_path('azuremail.php'),
        ], 'config');

        // Extend Laravel's Mail Manager to register the custom "azure" transport.
        $this->app->make('mail.manager')->extend('azure', function (array $config = []) {
            $guzzle = new Client;
            $azureConfig = config('azuremail');
            $client = new AzureCommunicationClient($guzzle, $azureConfig);

            return new AzureMailTransport($client);
        });
    }
}
