<?php

/*
 * This file is part of blomstra/flarum-sendgrid.
 *
 * Copyright (c) 2024 Jaggy Gauran.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Blomstra\FlarumSendGrid;

use Blomstra\FlarumSendGrid\Controllers\EventsStoreController;
use Flarum\Extend;

return [
    new Extend\Locales(__DIR__.'/locale'),

    (new Extend\Mail())->driver('sendgrid', SendGridDriver::class),

    (new Extend\Csrf())->exemptRoute('flarum-sendgrid.hooks.events.store'),

    (new Extend\Routes('api'))->post(
        '/flarum-sendgrid/hooks/events',
        'flarum-sendgrid.hooks.events.store',
        EventsStoreController::class,
    ),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js'),
];
