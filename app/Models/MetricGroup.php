<?php

namespace CachetHQ\Cachet\Models;

use AltThree\Validator\ValidatingTrait;
use CachetHQ\Cachet\Models\Traits\SearchableTrait;
use CachetHQ\Cachet\Models\Traits\SortableTrait;
use CachetHQ\Cachet\Presenters\MetricGroupPresenter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use McCool\LaravelAutoPresenter\HasPresenter;

/**
 * This is the metric group model class.
 */
class MetricGroup extends Model implements HasPresenter
{
    use SearchableTrait;
    use SortableTrait;
    use ValidatingTrait;

    protected $table = 'metric_groups';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    /**
     * Viewable only authenticated users.
     *
     * @var int
     */
    const VISIBLE_AUTHENTICATED = 0;

    /**
     * Viewable by public.
     *
     * @var int
     */
    const VISIBLE_GUEST = 1;

    /**
     * The model's attributes.
     *
     * @var string
     */
    protected $attributes = [
        'order'     => 0,
        'visible'   => 0,
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var string[]
     */
    protected $casts = [
        'name'      => 'string',
        'order'     => 'int',
        'visible'   => 'int',
    ];

    /**
     * The fillable properties.
     *
     * @var string[]
     */
    protected $fillable = ['name', 'order', 'visible'];

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
     * The searchable fields.
     *
     * @var string[]
     */
    protected $searchable = [
        'id',
        'name',
        'order',
        'visible',
    ];

    /**
     * The sortable fields.
     *
     * @var string[]
     */
    protected $sortable = [
        'id',
        'name',
        'order',
        'visible',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var string[]
     */
//    protected $with = ['name'];
//    protected $with = ['enabled_metrics', 'enabled_metrics_lowest'];

    /**
     * Get the metric relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function metrics()
    {
        return $this->hasMany(Metric::class, 'group_id', 'id');
    }


    /**
     * Return all of the metrics ordered.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function metrics_lowest()
    {
        return $this->metrics()->orderBy('order', 'desc');
    }

    /**
     * Get the presenter class.
     *
     * @return string
     */
    public function getPresenterClass()
    {
        return MetricGroupPresenter::class;
    }

    /**
     * Finds all metric groups which are visible to public.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVisible(Builder $query)
    {
        return $query->where('visible', '=', self::VISIBLE_GUEST);
    }

    /**
     * Finds all used metric groups.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Support\Collection        $usedMetricGroups
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUsed(Builder $query, Collection $usedMetricGroups)
    {
        return $query->whereIn('id', $usedMetricGroups)
            ->orderBy('order');
    }
}
