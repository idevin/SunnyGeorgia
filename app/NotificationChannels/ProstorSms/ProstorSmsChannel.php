<?php
/**
 * Created by PhpStorm.

 * Date: 12.12.2017
 * Time: 14:15
 */

namespace App\NotificationChannels\ProstorSms;

use App\NotificationChannels\ProstorSms\Exceptions\CouldNotSendNotification;
use Illuminate\Notifications\Notification;

class ProstorSmsChannel
{
    protected $prostorSms;

    /**
     * The phone number notifications should be sent from.
     *
     * @var string
     */

    public function __construct(ProstorSms $prostorSms)
    {
        $this->prostorSms = $prostorSms;
    }

    /**
     * Send the given notification.
     *
     */
    public function send($notifiable, Notification $notification)
    {
        if (!$to = $notifiable->routeNotificationFor('ProstorSms')) {
            return;
        }
        $message = $notification->toProstorSms($notifiable);
        if (is_string($message)) {
            $message = new ProstorSmsMessage($message);
        }
        $response = $this->prostorSms->send_message([
            'mobile_number' => $to,
            'text' => trim($message->content),
        ]);
        if (empty($response['response']) || !empty($response['errors'])) {
            throw CouldNotSendNotification::serviceRespondedWithAnError($response);
        }
        $response = json_decode($response['response']);
        foreach ($response->messages as $message) {
            if ($message->status != 'accepted') {
                throw CouldNotSendNotification::serviceValidationError($message->status);
            }
        }
        return $response;
    }
}
