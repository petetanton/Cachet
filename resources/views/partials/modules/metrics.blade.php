@if($displayMetrics && $appGraphs)

    @if($metricGroups->isNotEmpty())
        <h3>{{ $metricTitle }}</h3>
        <ul class="list-group">
        <div style="display: inline-block;">
            <p class="col-xs-12 metric-description list-group-item-error-budget">
                These metric tiles represent the remaining error budget as a percentage for the preceding
                30 day rolling window</br>
                > 0% - the service is achieving it's SLO</br>
                < 0% - the service is missing it's SLO
            </p>
        </div>
        @foreach($metricGroups as $metricGroup)
                <li class="list-group-item metric group-name">
                    <strong>{{ $metricGroup->name }}</strong>
                </li>

                <div class="group-item">
                    <div class="row" style="margin: 0px;">
                        @foreach ($metricGroup->metrics->sortBy('order') as $metric)
                            <div>
                                <errorbudgetmetric-chart :metric="{{ $metric->toJson() }}" dashboardurl="{{ $dashboardUrl  }}"></errorbudgetmetric-chart>
                            </div>
                        @endforeach
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
