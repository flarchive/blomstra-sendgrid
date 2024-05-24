<?php

namespace Blomstra\FlarumSendGrid;

use Flarum\Mail\DriverInterface;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\MessageBag;
use SendGrid;
use Swift_Transport;

class SendGridDriver implements DriverInterface
{
    public function __construct()
    {
    }

    public function availableSettings(): array
    {
        return [
            'mail_sendgrid_secret' => '',
            'mail_sendgrid_from_email' => '',
            'mail_sendgrid_from_name' => '',
        ];
    }

    public function validate(SettingsRepositoryInterface $settings, Factory $validator): MessageBag
    {
        return $validator->make($settings->all(), [
            'mail_sendgrid_secret' => 'required',
            'mail_sendgrid_from_email' => 'required',
            'mail_sendgrid_from_name' => 'required',
        ])->errors();
    }

    public function canSend(): bool
    {
        return true;
    }

    public function buildTransport(SettingsRepositoryInterface $settings): Swift_Transport
    {
        return new SendGridTransport(
            new SendGrid($settings->get('mail_sendgrid_secret')),
            [$settings->get('mail_sendgrid_from_email'), $settings->get('mail_sendgrid_from_email')],
        );
    }
}
