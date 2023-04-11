<?php

namespace CachetHQ\Cachet\Bus\Events\MetricGroup;

use CachetHQ\Cachet\Bus\Events\ActionInterface;
use CachetHQ\Cachet\Models\MetricGroup;
use CachetHQ\Cachet\Models\User;

/**
 * This is the metric group was created event class.
 *
 * @author James Brooks <james@alt-three.com>
 */
final class MetricGroupWasCreatedEvent implements ActionInterface, MetricGroupEventInterface
{
    /**
     * The user who added the metric group.
     *
     * @var \CachetHQ\Cachet\Models\User
     */
    public $user;

    /**
     * The metric group that was added.
     *
     * @var \CachetHQ\Cachet\Models\MetricGroup
     */
    public $group;

    /**
     * Create a new metric group was added event instance.
     *
     * @param \CachetHQ\Cachet\Models\User           $group
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
        return 'metric Group was added.';
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
