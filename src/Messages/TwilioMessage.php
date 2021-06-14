<?php

namespace Cuongnd88\DeliveryChannel\Channels;

class TwilioMessage
{
    public $to;

    public $from;

    public $body;

    public function to($to)
    {
        $this->to = $to;
    }

    public function from($from)
    {
        $this->from = $from;
    }

    public function body($body)
    {
        $this->body = $body;
    }
}
