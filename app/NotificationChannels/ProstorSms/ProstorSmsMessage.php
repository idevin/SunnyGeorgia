<?php
/**
 * Created by PhpStorm.

 * Date: 12.12.2017
 * Time: 14:16
 */

namespace App\NotificationChannels\ProstorSms;


class ProstorSmsMessage
{
    /**
     * The message content.
     *
     * @var string
     */
    public $content;

    /**
     * Create a new message instance.
     *
     * @param  string $content
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    /**
     * Create a new message instance.
     *
     * @param  string $content
     *
     * @return static
     */
    public static function create($content = '')
    {
        return new static($content);
    }

    /**
     * Set the message content.
     *
     * @param  string $content
     *
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;
        return $this;
    }


}