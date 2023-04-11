<?php

namespace CachetHQ\Cachet\Bus\Handlers\Commands\MetricGroup;

use CachetHQ\Cachet\Bus\Commands\MetricGroup\CreateMetricGroupCommand;
use CachetHQ\Cachet\Bus\Events\MetricGroup\MetricGroupWasCreatedEvent;
use CachetHQ\Cachet\Models\MetricGroup;
use Illuminate\Contracts\Auth\Guard;

class CreateMetricGroupCommandHandler
{
    /**
     * The authentication guard instance.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * Create a new create metric group command handler instance.
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
     * Handle the create metric group command.
     *
     * @param \CachetHQ\Cachet\Bus\Commands\MetricGroup\CreateMetricGroupCommand $command
     *
     * @return \CachetHQ\Cachet\Models\MetricGroup
     */
    public function handle(CreateMetricGroupCommand $command)
    {
        $group = MetricGroup::create([
            'name'      => $command->name,
            'order'     => $command->order,
            'visible'   => $command->visible,
        ]);

        event(new MetricGroupWasCreatedEvent($this->auth->user(), $group));

        return $group;
    }
}
