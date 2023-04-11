<li class="list-group-item {{ $metric->group_id ? "sub-component" : "component" }}" data-metric-id="{{ $metric->id }}">
    <div>
        <metric-chart :metric="{{ $metric->toJson() }}"></metric-chart>
    </div>
</li>
