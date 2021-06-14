<?php

namespace Cuongnd88\DeliveryChannel\Channels;

use Illuminate\Notifications\Notification;
use Twilio\Rest\Client as TwilioClient;
use Cuongnd88\DeliveryChannel\Messages\TwilioMessage;

class TwilioChannel
{
    protected $to;

    protected $body;

    protected $from;

    public function __constructor()
    {

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
        $client = new TwilioClient(config('channels.twilio.account_sid'), config('channels.twilio.auth_token'));
        $message = $notification->toTwilio($notifiable);

        $this->parseMessage($message);

        $client->messages->create(
            $this->to,
            [
                'from' => $this->from,
                'body' => $this->body
            ]
        );
    }

    /**
     * Parge message
     *
     * @param  mixed $message
     *
     * @return void
     */
    public function parseMessage($message)
    {
        if (is_object($message) && false === $message instanceof TwilioMessage) {
            logger(__METHOD__ . ": BAD REQUEST");
            throw new \Exception("Bad Request", 400);
        }

        if (is_array($message)
            && (false === isset($message['to']) || false === isset($message['body']))
        ) {
            logger(__METHOD__ . ": BAD REQUEST");
            throw new \Exception("Bad Request", 400);
        }

        if (is_array($message)) {
            $this->to = $message['to'];
            $this->body = $message['body'];
            $this->from = isset($message['from']) && $message['from'] ? $message['from'] : env('TWILIO_SMS_FROM');
        } else {
            $this->to = $message->to;
            $this->body = $message->body;
            $this->from = $message->from ?? env('TWILIO_SMS_FROM');
        }
    }
}
