<?php

namespace Blomstra\FlarumSendGrid\Controllers;

use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\Event\Saving;
use Flarum\User\Guest;
use Flarum\User\User;
use Illuminate\Contracts\Events\Dispatcher;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EventsStoreController implements RequestHandlerInterface
{
    public function __construct(
        private SettingsRepositoryInterface $settings,
        private Dispatcher $events
    )
    {}

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
            'message' => 'SendGrid events processed',
        ], 201);
    }

    private function suspendAccountsWithInvalidEmails(array $events): void
    {
        $emails = collect($events)
            ->where('event', 'bounce')
            ->unique('email')
            ->pluck('email');

        User::query()
            ->whereIn('email', $emails->toArray())
            ->each(function (User $user) {
                $user->is_email_confirmed = false;

                $this->dispatchAndSave($user);
            });
    }

    private function disableNotificationsForAccountsThatReportedSpam(array $events): void
    {
        $emails = collect($events)
            ->where('event', 'spamreport')
            ->unique('email')
            ->pluck('email');

        User::query()
            ->whereIn('email', $emails->toArray())
            ->each(function (User $user) {
                $user->preferences = collect($user->preferences)
                    ->map(fn ($value, $key) => str_starts_with($key, 'notify_') ? false : $value)
                    ->toArray();

                $this->dispatchAndSave($user);
            });
    }

    private function dispatchAndSave(User $user): void
    {
        // Dispatch even to trigger other logic for log auditing etc.
        // Sadly this event requires an admin
        $saving = new Saving($user, new Guest(), $user->getMutatedAttributes());
        $this->events->dispatch($saving);

        $user->save();
    }
}
