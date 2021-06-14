<?php

namespace Cuongnd88\DeliveryChannel\Channels;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client as TwilioClient;

class TwilioChannel
{
    public $client;

    public function __constructor()
    {
        logger(__METHOD__);
        $this->client = new TwilioClient(
                            config('channels.twilio.account_sid'), 
                            config('channels.twilio.auth_token')
                        );
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        logger(__METHOD__);
        $message = $notification->toTwilio($notifiable);

        if (is_array($message)) {
            return;
        }
        $this->client->messages->create(
            $message->to,
            [
                'from' => $message->from,
                'body' => $message->body
            ]
        );
    }
}
