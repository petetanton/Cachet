<?php

namespace CachetHQ\Cachet\Bus\Handlers\Commands\MetricGroup;

use CachetHQ\Cachet\Bus\Commands\MetricGroup\RemoveMetricGroupCommand;
use CachetHQ\Cachet\Bus\Events\MetricGroup\MetricGroupWasRemovedEvent;
use Illuminate\Contracts\Auth\Guard;

class RemoveMetricGroupCommandHandler
{
    /**
     * The authentication guard instance.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * Create a new remove metric group command handler instance.
     *
     * @param \Illuminate\Contracts\Auth\Guard $auth
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle the remove metric group command.
     *
     * @param \CachetHQ\Cachet\Bus\Commands\MetricGroup\RemoveMetricGroupCommand $command
     *
     * @return void
     */
    public function handle(RemoveMetricGroupCommand $command)
    {
        $group = $command->group;

        event(new MetricGroupWasRemovedEvent($this->auth->user(), $group));

        // Remove the group id from all metric.
        $group->metrics->map(function ($metric) {
            $metric->update(['group_id' => 0]);
        });

        $group->delete();
    }
}
