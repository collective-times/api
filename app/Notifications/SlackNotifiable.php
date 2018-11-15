<?php

namespace App\Notifications;

use Illuminate\Notifications\Notifiable;

class SlackNotifiable
{
    use Notifiable;

    public function routeNotificationForSlack()
    {
        return config('notification.slack.webhook_url');
    }
}
