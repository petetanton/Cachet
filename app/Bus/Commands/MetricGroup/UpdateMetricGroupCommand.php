<?php

namespace CachetHQ\Cachet\Bus\Commands\MetricGroup;

use CachetHQ\Cachet\Models\MetricGroup;

/**
 * This is the update metric group command.
 */
final class UpdateMetricGroupCommand
{
    /**
     * The metric group.
     *
     * @var \CachetHQ\Cachet\Models\MetricGroup
     */
    public $group;

    /**
     * The metric group name.
     *
     * @var string
     */
    public $name;

    /**
     * The metric group description.
     *
     * @var int
     */
    public $order;

    /**
     * Is the metric visible to public?
     *
     * @var int
     */
    public $visible;

    /**
     * The validation rules.
     *
     * @var string[]
     */
    public $rules = [
        'name'      => 'nullable|string',
        'order'     => 'nullable|int',
        'visible'   => 'nullable|bool',
    ];

    /**
     * Create a add component group command instance.
     *
     * @param \CachetHQ\Cachet\Models\MetricGroup $group
     * @param string                              $name
     * @param int                                 $order
     * @param int                                 $visible
     *
     * @return void
     */
    public function __construct(MetricGroup $group, $name, $order, $visible)
    {
        $this->group = $group;
        $this->name = $name;
        $this->order = (int) $order;
        $this->visible = (int) $visible;
    }
}
