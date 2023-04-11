<?php

namespace CachetHQ\Cachet\Bus\Commands\MetricGroup;

use CachetHQ\Cachet\Models\MetricGroup;

final class RemoveMetricGroupCommand
{
    /**
     * The component group to remove.
     *
     * @var \CachetHQ\Cachet\Models\MetricGroup
     */
    public $group;

    /**
     * Create a new remove metric group command instance.
     *
     * @param \CachetHQ\Cachet\Models\MetricGroup $group
     *
     * @return void
     */
    public function __construct(MetricGroup $group)
    {
        $this->group = $group;
    }
}
