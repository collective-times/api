<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage;

class Slack extends Notification
{
    use Queueable;

    private $title;
    private $url;
    private $name;
    private $icon;
    private $channel;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $url)
    {
        $this->title = $title;
        $this->url = $url;
        $this->name = config('notification.slack.name');
        $this->icon = config('notification.slack.icon');
        $this->channel = config('notification.slack.channel');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        $url = $this->url;
        return (new SlackMessage)
            ->from($this->name, $this->icon)
            ->to($this->channel)
            ->attachment(function ($attachment) use ($url) {
                $attachment->title($this->title, $url);
            });
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
