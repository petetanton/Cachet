<?php

namespace CachetHQ\Cachet\Bus\Commands\MetricGroup;

/**
 * This is the create component group command.
 */
final class CreateMetricGroupCommand
{
    /**
     * The component group name.
     *
     * @var string
     */
    public $name;

    /**
     * The component group description.
     *
     * @var int
     */
    public $order;

    /**
     * Is the component visible to public?
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
        'name'      => 'required|string',
        'order'     => 'required|int',
        'visible'   => 'required|bool',
    ];

    /**
     * Create a add metric group command instance.
     *
     * @param string $name
     * @param int    $order
     * @param int    $visible
     *
     * @return void
     */
    public function __construct($name, $order, $visible)
    {
        $this->name = $name;
        $this->order = (int) $order;
        $this->visible = (int) $visible;
    }
}
