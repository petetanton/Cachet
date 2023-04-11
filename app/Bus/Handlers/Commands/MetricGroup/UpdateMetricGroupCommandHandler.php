<?php

namespace CachetHQ\Cachet\Bus\Handlers\Commands\MetricGroup;

use CachetHQ\Cachet\Bus\Commands\MetricGroup\UpdateMetricGroupCommand;
use CachetHQ\Cachet\Bus\Events\MetricGroup\MetricGroupWasUpdatedEvent;
use Illuminate\Contracts\Auth\Guard;

class UpdateMetricGroupCommandHandler
{
    /**
     * The authentication guard instance.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * Create a new update metric command handler instance.
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
     * Handle the update metric group command.
     *
     * @param \CachetHQ\Cachet\Bus\Commands\MetricGroup\UpdateMetricGroupCommand $command
     *
     * @return \CachetHQ\Cachet\Models\MetricGroup
     */
    public function handle(UpdateMetricGroupCommand $command)
    {
        $group = $command->group;
        $group->update($this->filter($command));

        event(new MetricGroupWasUpdatedEvent($this->auth->user(), $group));

        return $group;
    }

    /**
     * Filter the command data.
     *
     * @param \CachetHQ\Cachet\Bus\Commands\MetricGroup\UpdateMetricGroupCommand $command
     *
     * @return array
     */
    protected function filter(UpdateMetricGroupCommand $command)
    {
        $params = [
            'name'      => $command->name,
            'order'     => $command->order,
            'visible'   => $command->visible,
        ];

        return array_filter($params, function ($val) {
            return $val !== null;
        });
    }
}
