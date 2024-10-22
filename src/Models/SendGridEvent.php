<?php

namespace Blomstra\FlarumSendGrid\Models;

use Flarum\Database\AbstractModel;
use Illuminate\Database\Eloquent\Builder;

class SendGridEvent extends AbstractModel
{
    const STATUSES = [
        'processed',
        'dropped',
        'deferred',
        'bounce',
        'delivered',
    ];

    const ENGAGEMENTS = [
        'open',
        'click',
        'unsubscribe',
        'spamreport',
        'group_unsubscribe',
        'group_resubscribe',
    ];

    protected $table = 'send_grid_events';

    protected $guarded = [];

    public function scopeStatus(Builder $query): void
    {
        $query->whereIn('event', self::STATUSES);
    }

    public function scopeEngagement(Builder $query): void
    {
        $query->whereIn('event', self::ENGAGEMENTS);
    }
}
