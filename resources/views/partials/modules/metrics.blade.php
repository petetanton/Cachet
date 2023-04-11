@if($displayMetrics && $appGraphs)

    @if($metricGroups->isNotEmpty())
        <ul class="list-group">
            @foreach($metricGroups as $metricGroup)
                <li class="list-group-item metric group-name">
                    <strong>{{ $metricGroup->name }}</strong>
                </li>

                <div class="group-item">
                    @each('partials.metric', $metricGroup->metrics, 'metric')
                </div>
            @endforeach
        </ul>
    @endif

    @if($ungroupedMetrics->isNotEmpty())
        <h1>There are ungrouped metrics</h1>
        <ul class="list-group">
            @foreach($ungroupedMetrics as $metric)
                <li class="list-group-item metric {{ $metric->group_id ? "sub-component" : "component" }}"
                    data-metric-id="{{ $metric->id }}">
                    <metric-chart :metric="{{ $metric->toJson() }}" :theme-light="{{ json_encode($themeMetrics) }}"
                                  :theme="{{ json_encode(color_darken($themeMetrics, -0.1)) }}"
                                  :theme-dark="{{ json_encode(color_darken($themeMetrics, -0.2)) }}"></metric-chart>
                </li>
            @endforeach
        </ul>
    @endif
@endif
