<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AcceptCommissionUpdate extends Notification implements ShouldQueue
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

        return (new MailMessage)
            ->line('Ваш запросс на обновление комисии рассмотрен')
            ->line($this->product->title)
            ->line('Действующая коммиссия: ' . $this->product->commission . '%, ')
            ->line('Вы можете отправить следующий запрос на обновление коммиссии нажав кнопку')
            ->action('Перейти к продукту', route($route, $this->product->id));
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
