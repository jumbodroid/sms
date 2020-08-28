<?php

namespace Jumbodroid\Sms;

final class Network
{
    const METHOD_GET = 'POST';
    const METHOD_POST = 'POST';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';
    const METHOD_HEAD = 'HEAD';

    const USER_AGENT = 'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:79.0) Gecko/20100101 Firefox/79.0';

    const HEADER_CONTENT_TYPE_FORM_DATA = 'Content-Type: application/x-www-form-urlencoded';
    const HEADER_CONTENT_TYPE_JSON      = 'Content-Type: application/json';
    const HEADER_ACCEPT_JSON            = 'Accept: application/json';
    const HEADER_CONTENT_LENGTH         = 'Content-Length: ';

    private function __construct()
    {
        // prevents external instantiation
    }

    private static function nonGetCall(string $method, $url, $data, array $headers=null)
    {
        if(empty($headers))
        {
            $data = json_encode($data);
            $headers = [ self::HEADER_CONTENT_TYPE_JSON, self::HEADER_ACCEPT_JSON , self::HEADER_CONTENT_LENGTH.strlen($data) ];
        }

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, self::USER_AGENT);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        $errno = curl_errno($ch);
        curl_close($ch);
        if($errno == CURLE_OK)
        {
            return json_encode([
                'error' => false,
                'message' => json_decode($result, true),
            ]);
        }

        return json_encode([
            'error' => true,
            'message' => $info,
            'errno' => $errno,
            'result' => (string) $result
        ]);
    }

    public static function post(string $url, $data, array $headers=null)
    {
        return self::nonGetCall(self::METHOD_POST, $url, $data, $headers);
    }

    public static function put(string $url, $data, array $headers=null)
    {
        return self::nonGetCall(self::METHOD_PUT, $url, $data, $headers);
    }

    public static function delete(string $url, $data, array $headers=null)
    {
        return self::nonGetCall(self::METHOD_DELETE, $url, $data, $headers);
    }
}
