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
            ->hasMigrations([
                'create_messenger_users_table',
                'create_messenger_device_tokens_table',
                'create_messenger_groups_table',
                'create_messenger_group_users_table',
                'create_messenger_messages_table',
                'create_messenger_message_recipients_table',
                'create_messenger_message_receipts_table',
                'create_messenger_replies_table',
            ])
            ->hasCommand(MessengerCommand::class);
    }
}
