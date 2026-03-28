<?php

namespace NettSite\Messenger;

use NettSite\Messenger\Commands\MessengerCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MessengerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('messenger')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_messenger_table')
            ->hasCommand(MessengerCommand::class);
    }
}
