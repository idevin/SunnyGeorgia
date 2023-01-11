<?php

namespace App\Notifications\Admin;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequestCommissionUpdate extends Notification implements ShouldQueue
{
    use Queueable;

    protected $product;
    protected $instance;

    public function __construct($product)
    {
        $this->product = $product;
        $this->instance = class_basename($product);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if ($this->instance === 'Excursion') $route = 'control:excursions.edit';
        elseif ($this->instance === 'Tour') $route = 'control:tours.edit';
        else $route = '';

        $title = $this->product->commission_proposal ?
            'Запросс на обновление комисии.' : 'Отмена обновления комисии';
        $text = $this->product->commission_proposal ?
            'Действующая коммиссия: ' . $this->product->commission . '%, ' .
            'предложение: ' . $this->product->commission_proposal . '%'
            :
            'Действующая коммиссия: ' . $this->product->commission . '%';

        return (new MailMessage)
            ->line($title)
            ->line($this->product->title)
            ->line($text)
            ->action('Перейти к продукту', route($route, $this->product->id))
            ->line('Время запроса: ' . Carbon::now() . ' ' . Carbon::now()->tzName);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
