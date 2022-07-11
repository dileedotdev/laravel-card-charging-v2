<?php

declare(strict_types=1);

namespace Dinhdjj\CardChargingV2;

use Dinhdjj\CardChargingV2\Commands\CardChargingV2Command;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CardChargingV2ServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('card-charging-v2')
            ->hasConfigFile()
            // ->hasViews()
            ->hasMigration('create_card_charging_v2_table')
            // ->hasCommand(CardChargingV2Command::class)
        ;
    }

    public function packageBooted(): void
    {
        $this->app->bind('card-charging-v2', fn () => new CardChargingV2());
    }
}
