<?php

namespace App\Sms;

use Illuminate\Database\Eloquent\Model;

class SmsOutbox extends Model
{
    protected $table = 'sms_outbox';
    public $timestamps = true;
}
