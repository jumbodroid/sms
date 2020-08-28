<?php

namespace Jumbodroid\Sms\Gateways;

use Jumbodroid\Sms\Config;
use Jumbodroid\Sms\Contracts\SmsGateway;
use Jumbodroid\Sms\Network;

class AfricasTalking implements SmsGateway
{
    const VERSION = 'version1';
    const SCHEME = 'https';

    /*/ production /*/
	const AUTHORITY = 'api.africastalking.com';
    const CONTENT_AUTHORITY = 'content.africastalking.com';

    /*/ sandbox /*/
    const AUTHORITY_SANDBOX = 'api.sandbox.africastalking.com';
    const CONTENT_AUTHORITY_SANDBOX = self::AUTHORITY_SANDBOX;

    /*/ custom headers /*/
    const HEADER_API_KEY = 'apikey: ';

	protected $username;
    protected $apiKey;
    protected $alphanumeric;

	public $baseUrl;
    protected $contentUrl;

    private $apiKeyHeader = null;
    private $defaultHeaders = [];

	public function __construct()
	{
        $config = new Config();
		$this->username = $config->get('gateways.africastalking.username');
        $this->apiKey = $config->get('gateways.africastalking.apikey');
        $this->alphanumeric = $config->get('gateways.africastalking.alphanumeric');
        $this->apiKeyHeader = self::HEADER_API_KEY.$this->apiKey;
        $this->defaultHeaders[] = $this->apiKeyHeader;
        $this->defaultHeaders[] = Network::HEADER_CONTENT_TYPE_FORM_DATA;
        $this->defaultHeaders[] = Network::HEADER_ACCEPT_JSON;

        if($this->username === 'sandbox')
        {
            $this->baseUrl = self::SCHEME.'://'.self::AUTHORITY_SANDBOX.'/'.self::VERSION.'/';
            $this->contentUrl = self::SCHEME.'://'.self::CONTENT_AUTHORITY_SANDBOX.'/'.self::VERSION.'/';
        }
		else {
            $this->baseUrl = self::SCHEME.'://'.self::AUTHORITY.'/'.self::VERSION.'/';
            $this->contentUrl = self::SCHEME.'://'.self::AUTHORITY.'/'.self::VERSION.'/';
            // $this->contentUrl = self::SCHEME.'://'.self::CONTENT_AUTHORITY.'/'.self::VERSION.'/';
        }
	}

    /**
     * Sends SMS to the specified recipient
     *
     * @link https://build.at-labs.io/docs/sms%2Fsending%2Fbulk
     * @link https://build.at-labs.io/docs/getting_started/request_headers
     *
     *
     /

     ENDPOINT
     =========
     Live:    POST https://api.africastalking.com/version1/messaging
     Sandbox: POST https://api.sandbox.africastalking.com/version1/messaging

     REQUEST HEADER
     ===============
     WHEN USING USERNAME + API KEY

                Parameter 	Description
                ---------   ------------
                apiKey
                String
                Required 	Africa’s Talking application apiKey.

                Content-Type
                String
                Required 	The requests content type. Can be application/x-www-form-urlencoded or application/json

                Accept
                String
                Optional 	The requests response type. Can be application/json or application/xml. Defaults to application/xml

    WHEN USING OAUTH TOKEN

                Parameter 	Description
                ---------   ------------
                authToken
                String
                Required 	Generated Auth Token.

                Content-Type
                String
                Required 	The requests content type. Can be application/x-www-form-urlencoded or application/xml

                Accept
                String
                Optional 	The requests response type. Can be application/json or application/xml. Defaults to application/xml

     REQUEST BODY
     ============

     username
                    String
                    Required
                    Your Africa’s Talking application username.

     to
                    String
                    Required
                    A comma separated string of recipients’ phone numbers.

     message
                    String
                    Required
                    The message to be sent.

     from
                    String
                    Optional
                    Your registered short code or alphanumeric, defaults to AFRICASTKNG.

     bulkSMSMode
                    Integer
                    Optional
                    This is used by the Mobile Service Provider to determine who gets
                    billed for a message sent using a Mobile-Terminated ShortCode.
                    The default value is 1(which means that the sender - Africa’s Talking
                    account being used - gets charged).
                    This parameter will be ignored for messages sent using alphanumerics
                    or Mobile-Originated shortcodes.
                    The value must be set to 1 for bulk messages.

     enqueue
                    Integer
                    Optional
                    This is used for Bulk SMS clients that would like to deliver as
                    many messages to the API before waiting for an acknowledgement
                    from the Telcos.
                    Possible values are 1 to enable and 0 to disable.
                    If enabled, the API will store the messages in a queue and
                    send them out asynchronously after responding to the request.
                    The default value is 1

     keyword
                    String
                    Optional
                    The keyword to be used for a premium service.

     linkId
                    String
                    Optional
                    This is used for premium services to send OnDemand messages.
                    We forward the linkId to your application when the user sends
                    a message to your service.

     retryDurationInHours
                    Integer
                    Optional
                    This specifies the number of hours your subscription message
                    should be retried in case it’s not delivered to the subscriber.

     RESPONSE BODY
     =============

     SMSMessageData
                    Map
                    A Map detailing the eventual result of the sms request. It contains the following fields:
                        Message String: A summary of the total number of recipients the sms was sent to and the total cost incurred.
                        Recipients List: A list of recipients included in the original request. Each recipient is a Map with the following fields:
                            statusCode Integer: This corresponds to the status of the request. Possible values are:
                                100: Processed
                                101: Sent
                                102: Queued
                                401: RiskHold
                                402: InvalidSenderId
                                403: InvalidPhoneNumber
                                404: UnsupportedNumberType
                                405: InsufficientBalance
                                406: UserInBlacklist
                                407: CouldNotRoute
                                500: InternalServerError
                                501: GatewayError
                                502: RejectedByGateway
                            number String: The recipient’s phone number
                            cost String: Amount incurred to send this sms. The format of this string is: (3-digit Currency Code)(space)(Decimal Value) e.g KES 1.00
                            status String: A string indicating whether the sms was sent to this recipient or not. This does not indicate the delivery status of the sms to this recipient.
                            messageId String: The messageId received when the sms was sent.

                    Example response body
                    {
                        "SMSMessageData": {
                            "Message": "Sent to 1/1 Total Cost: KES 0.8000",
                            "Recipients": [{
                                "statusCode": 101,
                                "number": "+254711XXXYYY",
                                "status": "Success",
                                "cost": "KES 0.8000",
                                "messageId": "ATPid_SampleTxnId123"
                            }]
                        }
                    }

        Another example
                {
                    "SMSMessageData":
                        {
                            "Message":"Sent to 1/1 Total Cost: KES 0.8000",
                            "Recipients":[
                                {
                                    "statusCode":101,
                                    "number":"+2547XXXXXXXX",
                                    "cost":"KES 0.8000",
                                    "status":"Success",
                                    "messageId":"ATXid_a17e9593364ab4fc8d9726e41c5b21a7"
                                }
                            ]
                        }
                }
     /
     */
	public function send($to, string $message, string $from = null, bool $enqueue=false)
	{
        $to = (array) $to;
		$data = ['username' => $this->username, 'to' => implode(",", $to), 'message' => $message,];
        if ($enqueue) $data['enqueue'] = 1;

        if (!empty($from)) $data['from'] = $from;
        else $data['from'] = $this->alphanumeric;

        $data = http_build_query($data);
		return Network::post($this->contentUrl.'messaging', $data, $this->defaultHeaders);
	}
}
