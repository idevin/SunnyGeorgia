<?php

namespace App\NotificationChannels\ProstorSms\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function serviceRespondedWithAnError($response)
    {
        return new static("Notification was not sent. Prostor SMS responded with `{$response['response']}: {$response['errors']}`");
    }

    public static function serviceValidationError($error)
    {
        return new static($error);
    }
}
