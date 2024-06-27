<?php

namespace Blomstra\FlarumSendGrid;

use Flarum\Foundation\AbstractServiceProvider;
use Flarum\Notification\Blueprint\BlueprintInterface;
use Flarum\Notification\NotificationSyncer;
use Flarum\User\User;

class Provider extends AbstractServiceProvider
{
    public function register()
    {
        NotificationSyncer::beforeSending(function (BlueprintInterface $blueprint, array $recipients)
        {
            // we can blindly prevent sending to users that have not verified their email
            // because email verification and pass resets do not use blueprints, but the mailer in raw mode
            return array_filter($recipients, fn (User $recipient) => $recipient->is_email_confirmed);
        });
    }
}
