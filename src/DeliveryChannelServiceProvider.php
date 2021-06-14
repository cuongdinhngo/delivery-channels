<?php

namespace Cuongnd88\DeliveryChannel;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;
use Cuongnd88\DeliveryChannel\Channels\TwilioChannel;

class DeliveryChannelServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/channels.php', 'channels');

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('twilio', function ($app) {
                return new TwilioChannel();
            });
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/channels.php' => $this->app->configPath('channels.php'),
        ], 'config');
    }
}
