<?php

namespace Jumbodroid\Sms\Contracts;

interface SmsGateway extends Gateway
{
    public function __construct();
    public function send($to, string $message, string $from = null, bool $enqueue = false);
}
