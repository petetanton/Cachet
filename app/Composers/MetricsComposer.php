<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Composers;

use CachetHQ\Cachet\Models\Metric;
use CachetHQ\Cachet\Models\MetricGroup;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\View\View;

/**
 * This is the metrics composer.
 *
 * @author James Brooks <james@alt-three.com>
 * @author Connor S. Parks <connor@connorvg.tv>
 */
class MetricsComposer
{
    /**
     * The illuminate config instance.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * The user session object.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $guard;

    /**
     * Create a new metrics composer instance.
     *
     * @param \Illuminate\Contracts\Config\Repository $config
     * @param \Illuminate\Contracts\Auth\Guard        $guard
     *
     * @return void
     */
    public function __construct(Repository $config, Guard $guard)
    {
        $this->config = $config;
        $this->guard = $guard;
    }

    /**
     * Bind data to the view.
     *
     * @param \Illuminate\Contracts\View\View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $displayMetrics = $this->config->get('setting.display_graphs');
        $dashboardUrl = $this->config->get('setting.dashboard_url');
        $metricGroups = $this->getVisibleGroupedMetrics();
        $ungroupedMetrics = Metric::ungrouped()->orderBy('order')->orderBy('id')->get();

        $metrics = $this->getVisibleMetrics($displayMetrics);

        $view->withDisplayMetrics($displayMetrics)
            ->withMetrics($metrics)
            ->withUngroupedMetrics($ungroupedMetrics)
            ->withMetricGroups($metricGroups)
            ->withDashboardUrl($dashboardUrl)
            ->withMetricTitle($this->config->get('setting.metric_title'));
    }

    /**
     * Get visible grouped components.
     *
     * @param bool $displayMetrics
     *
     * @return \Illuminate\Support\Collection|void
     */
    protected function getVisibleMetrics($displayMetrics)
    {
        if (!$displayMetrics) {
            return;
        }

        $metrics = Metric::displayable();

        if (!$this->guard->check()) {
            $metrics->visible();
        }

        return $metrics->orderBy('order')->orderBy('id')->get();
    }

    protected function getVisibleGroupedMetrics()
    {
        $metricGroupsBuilder = MetricGroup::query();
        if (!$this->guard->check()) {
            $metricGroupsBuilder->visible();
        }

        $usedMetricGroups = Metric::grouped()->pluck('group_id');

        return $metricGroupsBuilder->used($usedMetricGroups)->get();
    }
}
