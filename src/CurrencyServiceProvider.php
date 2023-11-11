<?php

namespace Onuraycicek\Currency;

use Illuminate\Support\Facades\Blade;
use Onuraycicek\Currency\Commands\CurrencyCommand;
use Onuraycicek\Currency\Components\CurrenyTableComponent;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CurrencyServiceProvider extends PackageServiceProvider
{
    public function boot()
    {
        parent::boot();
        $seederFileName = 'CurrencySeeder';

        $this->publishes([
            $this->package->basePath("/../database/seeders/{$seederFileName}.php") => database_path("seeders/{$seederFileName}.php"),
        ], "{$this->package->shortName()}-seeder");

        Blade::component('currency-table', CurrenyTableComponent::class);
    }

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('currency')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations(['create_currency_tables', 'create_currency_rates_table'])
            ->hasRoute('web')
            ->hasCommand(CurrencyCommand::class)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publish("{$this->package->shortName()}-seeder")
                    ->publishConfigFile()
                    ->publishAssets()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('onuraycicek/currency');
            });
    }
}
