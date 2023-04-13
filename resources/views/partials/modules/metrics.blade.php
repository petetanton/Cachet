@if($displayMetrics && $appGraphs)

    @if($metricGroups->isNotEmpty())
        <ul class="list-group">
            @foreach($metricGroups as $metricGroup)
                <li class="list-group-item metric group-name">
                    <strong>{{ $metricGroup->name }}</strong>
                </li>

                <div class="group-item">
                    <div class="row">
                        <div class="col-xs-12 metric-description">
                            These metric tiles represent the remaining error budget as a percentage for the preceding
                            30 day rolling window</br>
                            > 0% - the service is achieving it's SLO</br>
                            < 0% - the service is missing it's SLO
                        </div>
                    </div>
                    <div class="row" style="margin: 0px;">
                        @each('partials.metric', $metricGroup->metrics, 'metric')
                    </div>
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
