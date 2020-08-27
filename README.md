# SMS

SMS is a modern Short Messaging Service package for PHP

>Leverage SMS to quickly integrate with SMS gateways

## Installation

1. Require the sms package
    >> composer require jumbodroid/sms

2. Add the sms service provider to `config/app`
    >> Jumbodroid\Sms\ServiceProviders\SmsServiceProvider::class

2. Ensure there's a directory named `app/Sms` direcotry exists before you publish the package files
    >> php artisan vendor:publish --provider='Jumbodroid\Sms\ServiceProviders\SmsServiceProvider'

3. Run migrations
    >> php artisan migrate

4. Append the contents of [.env.example](env) to your `.env` and set valid them to valid values

## Usage

>> $sms = App::make(SmsGateway);
>> $response = $sms->send($to, $message, $from, $headers=null);
>> exit(var_dump($response));

