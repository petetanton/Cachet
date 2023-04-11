<?php

namespace CachetHQ\Cachet\Bus\Events\MetricGroup;

use CachetHQ\Cachet\Bus\Events\ActionInterface;
use CachetHQ\Cachet\Models\MetricGroup;
use CachetHQ\Cachet\Models\User;

final class MetricGroupWasRemovedEvent implements ActionInterface, MetricGroupEventInterface
{
    /**
     * The user who removed the metric group.
     *
     * @var \CachetHQ\Cachet\Models\User
     */
    public $user;

    /**
     * The metric group that was removed.
     *
     * @var \CachetHQ\Cachet\Models\MetricGroup
     */
    public $group;

    /**
     * Create a new metric group was removed event instance.
     *
     * @param \CachetHQ\Cachet\Models\User           $user
     * @param \CachetHQ\Cachet\Models\MetricGroup $group
     *
     * @return void
     */
    public function __construct(User $user, MetricGroup $group)
    {
        $this->user = $user;
        $this->group = $group;
    }

    /**
     * Get the event description.
     *
     * @return string
     */
    public function __toString()
    {
        return 'metric Group was removed.';
    }

    /**
     * Get the event action.
     *
     * @return array
     */
    public function getAction()
    {
        return [
            'user'        => $this->user,
            'description' => (string) $this,
        ];
    }
}
