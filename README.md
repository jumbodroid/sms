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

4. Append the contents of [.env.example](.env.example) to your `.env` and set valid values as needed

## Usage with Laravel Framework

### example response
    use Illuminate\Support\Facades\App;
    use Jumbodroid\Sms\Contracts\SmsGateway;

    $sms = App::make(SmsGateway::class); // uses the default gateway which can be configured in `config/sms.php`
    $rs = $sms->send(['+2547XXXXXXXX', '+2547XXXXXXXX'], 'It works!');
    header('Content-Type: application/json');
    echo $rs;
    exit;

### example response
    {
        "error":false,
        "message":{
            "SMSMessageData":{
                "Message":"Sent to 2\/2 Total Cost: KES 1.6000",
                "Recipients":[
                    {
                        "statusCode":101,
                        "number":"++2547XXXXXXXX",
                        "cost":"KES 0.8000",
                        "status":"Success","messageId":"ATXid_08d1018ef5d9d6ae514f1ad5893296e1"
                    },
                    {
                        "statusCode":101,
                        "number":"++2547XXXXXXXX",
                        "cost":"KES 0.8000",
                        "status":"Success","messageId":"ATXid_3585063525cd17db7e4db611ff35c8a6"
                    }
                ]
            }
        }
    }

