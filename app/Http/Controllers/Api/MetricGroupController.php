<?php

namespace CachetHQ\Cachet\Http\Controllers\Api;

use CachetHQ\Cachet\Bus\Commands\MetricGroup\CreateMetricGroupCommand;
use CachetHQ\Cachet\Bus\Commands\MetricGroup\RemoveMetricGroupCommand;
use CachetHQ\Cachet\Bus\Commands\MetricGroup\UpdateMetricGroupCommand;
use CachetHQ\Cachet\Models\ComponentGroup;
use CachetHQ\Cachet\Models\MetricGroup;
use GrahamCampbell\Binput\Facades\Binput;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * This is the metric group controller.
 */
class MetricGroupController extends AbstractApiController
{
    /**
     * The user session object.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $guard;

    /**
     * Creates a new metric group controller instance.
     *
     * @param \Illuminate\Contracts\Auth\Guard $guard
     */
    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * Get all groups.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $groups = MetricGroup::query();
        if (!$this->guard->check()) {
            $groups = MetricGroup::visible();
        }

        $groups->search(Binput::except(['sort', 'order', 'per_page']));

        if ($sortBy = Binput::get('sort')) {
            $direction = Binput::get('order', 'asc');

            $groups->sort($sortBy, $direction);
        }

        $groups = $groups->paginate(Binput::get('per_page', 20));

        return $this->paginator($groups, Request::instance());
    }

    /**
     * Get a single group.
     *
     * @param \CachetHQ\Cachet\Models\MetricGroup $group
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(MetricGroup $group)
    {
        $path_elements = explode('/', Request::fullUrl());
        $id = end($path_elements);
        $metric_groups = DB::table('metric_groups')->where('id', $id)->get();
        if (count($metric_groups) == 0) {
            $this->statusCode = 404;
            return $this->item(null);
        } else {
            return $this->item($metric_groups[0]);
        }
    }

    /**
     * Create a new metric group.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        try {
            $group = execute(new CreateMetricGroupCommand(
                Binput::get('name'),
                Binput::get('order', 0),
                Binput::get('visible', MetricGroup::VISIBLE_GUEST)
            ));
        } catch (QueryException $e) {
            error_log($e);
            throw new BadRequestHttpException($e);
        }

        return $this->item($group);
    }

    /**
     * Update an existing group.
     *
     * @param \CachetHQ\Cachet\Models\MetricGroup $group
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(MetricGroup $group)
    {
        try {
            $group = execute(new UpdateMetricGroupCommand(
                $group,
                Binput::get('name'),
                Binput::get('order'),
                Binput::get('visible')
            ));
        } catch (QueryException $e) {
            throw new BadRequestHttpException();
        }

        return $this->item($group);
    }

    /**
     * Delete an existing group.
     *
     * @param \CachetHQ\Cachet\Models\MetricGroup $group
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(MetricGroup $group)
    {
        execute(new RemoveMetricGroupCommand($group));

        return $this->noContent();
    }
}
