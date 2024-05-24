<?php

use Flarum\Testing\integration\TestCase;

class EventsStoreControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->prepareDatabase([
            'send_grid_notifications' => [],
        ]);
    }

    /** @test */
    public function it_saves_the_delivery_status_of_a_send_grid_notification()
    {
        $this->receiveWebhook()->getBody();
    }

    public function receiveWebhook()
    {
        return $this->send(
            $this->request('POST', '/api/flarum-sendgrid/hooks/messages', [
                'json' => [
                    'data' => [
                        $this->makeMessage(['event' => 'delivered']),
                        $this->makeMessage(['event' => 'processed']),
                    ],
                ],
            ]),
        );
    }

    public function makeMessage(array $attributes = []): array
    {
        return [
            'email' => 'jaggy@flarum.org',
            'event' => 'delivered',
            'ip' => '192.168.1.1',
            'response' => '250 2.0.0 Ok: queued as C18F884A00',
            'sg_event_id' => 'some-random-string',
            'sg_message_id' => 'some-random-string.filterdrecv-7b48875b86-t7jpc-1-664A17A5-4.0',
            'smtp-id' => '<some-random-string@geopod-ismtpd-5>',
            'timestamp' => 1716131750,
            'tls' => 1,
            ...$attributes,
        ];
    }
}
