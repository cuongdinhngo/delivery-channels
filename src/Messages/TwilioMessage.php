<?php

namespace Cuongnd88\DeliveryChannel\Messages;

class TwilioMessage
{
    public $to;

    public $from;

    public $body;

    public function to($to)
    {
        $this->to = $to;
        return $this;
    }

    public function from($from)
    {
        $this->from = $from;
        return $this;
    }

    public function body($body)
    {
        $this->body = $body;
        return $this;
    }
}
