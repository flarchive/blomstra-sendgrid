<?php

namespace Blomstra\FlarumSendGrid\Controllers;

use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\User;
use Illuminate\Support\Arr;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EventsStoreController implements RequestHandlerInterface
{
    private SettingsRepositoryInterface $settings;

    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $events = $request->getParsedBody();

        if ($this->settings->get('blomstra-sendgrid.sendgrid_suspend_when_email_bounced')) {
            $this->suspendAccountsWithInvalidEmails($events);
        }

        if ($this->settings->get('blomstra-sendgrid.sendgrid_disable_notifications_on_spam_report')) {
            $this->disableNotificationsForAccountsThatReportedSpam($events);
        }

        return new JsonResponse([
            'message' => 'SendGrid events procsesed',
        ], $status = 201);
    }

    private function suspendAccountsWithInvalidEmails(array $events): void
    {
        $emails = collect($events)
            ->where('event', 'bounce')
            ->unique('email')
            ->pluck('email');

        User::whereIn('email', $emails->toArray())->update([
            'suspended_until' => '2038-01-01 00:00:00',
        ]);
    }

    private function disableNotificationsForAccountsThatReportedSpam(array $events): void
    {
        $emails = collect($events)
            ->where('event', 'spamreport')
            ->unique('email')
            ->pluck('email');

        User::whereIn('email', $emails->toArray())->get()->each(function (User $user) {
            $user->preferences = collect($user->preferences)
                ->map(fn ($value, $key) => str_starts_with($key, 'notify_') ? false : $value)
                ->toArray();

            $user->save();
        });
    }
}
