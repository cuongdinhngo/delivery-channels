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
        // $this->mergeConfigFrom(__DIR__ . '/../config/channels.php', 'delivery-channels');

        Notification::resolved(function (ChannelManager $service) {
            $service->extend('twilio', function ($app) {
                return new TwilioChannel();
            });
        });
    }

    protected function publishConfig()
    {
        logger(__METHOD__);
        $this->publishes([
            __DIR__ . '/../config/channels.php' => config_path('channels.php'),
        ], 'channel-config');
    }
}
