<?php

namespace CachetHQ\Cachet\Presenters;

use CachetHQ\Cachet\Presenters\Traits\TimestampsTrait;
use Illuminate\Contracts\Support\Arrayable;
use McCool\LaravelAutoPresenter\BasePresenter;

class MetricGroupPresenter extends BasePresenter implements Arrayable
{
    use TimestampsTrait;


    public function name()
    {
        return $this->wrappedObject->name;
    }

     /**
     * Convert the presenter instance to an array.
     *
     * @return string[]
     */
    public function toArray()
    {
        return array_merge($this->wrappedObject->toArray(), [
            'created_at'          => $this->created_at(),
            'updated_at'          => $this->updated_at(),
            'name' => $this->name(),
        ]);
    }

    public function toJson($options = 0)
    {
        $json = json_encode($this->toArray(), $options);

        return $json;
    }
}
