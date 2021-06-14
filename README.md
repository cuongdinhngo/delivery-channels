# Laravel Notification Delivery Channels

Laravel ships with a handful of notification channels, but you may want to more drivers to deliver notifications via other channels. The `delivery-channels` makes it simple.

The package currently supports these drivers:
- Twilio

1-Install cuongnd88/delivery-channels using Composer.

```php
$ composer require cuongnd88/delivery-channels
```

2-Add the following service provider in `config/app.php`

```php
<?php
// config/app.php
return [
    // ...
    'providers' => [
        // ...
        Cuongnd88\DeliveryChannel\DeliveryChannelServiceProvider::class,
    ]
    // ...
];
```

For further configurations, you can modify the configuration by copying it to your local config directory:

```php
php artisan vendor:publish --provider="Cuongnd88\DeliveryChannel\DeliveryChannelServiceProvider" --tag=config
```

3-Update credentails in `config/channels.php` or `env` file

```php
<?php

return [
    'twilio' => [
        'account_sid' => env('TWILIO_ACCOUNT_SID'),
        'auth_token' => env('TWILIO_AUTH_TOKEN'),
        'sms_from' => env('TWILIO_SMS_FROM'),
    ],
];

```

## Sample Usage


In the Laravel notification class, it contains a `via` method and a variable number of message building methods (such as toMail or toDatabase) that convert the notification to a message optimized for that particular channel.

```php
/**
 * Get the notification's delivery channels.
 *
 * @param  mixed  $notifiable
 * @return array
 */
public function via($notifiable)
{
    return ['mail', 'twilio'];
}

```

### Twilio Channel

You have to define a `toTwilio` method on the notification class. This method will receive a $notifiable entity and should return a `Cuongnd88\DeliveryChannel\Messages\TwilioMessage` instance or array. Let's take a look at an example `toTwilio` method:

```php
    /**
     * Get the Twilio / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return mixed
     */
    public function toTwilio($notifiable)
    {
        return (new TwilioMessage)
                    ->to("+xxxxxx")
                    ->from("+xxxxx")
                    ->body('OTP AUTH is '.$this->otp);
    }
```

```php
    /**
     * Get the Twilio / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return mixed
     */
    public function toTwilio($notifiable)
    {
        return [
            'to' => "+84xxxxxxxxxx",
            'body' => 'OTP AUTH is '.$this->otp
        ];           ->body('OTP AUTH is '.$this->otp);
    }
```

## Demo

This is demo soure code.
[Laravel Colab](https://github.com/cuongnd88/lara-colab/blob/master/alpha/app/Authentication/SendOtp.php)

