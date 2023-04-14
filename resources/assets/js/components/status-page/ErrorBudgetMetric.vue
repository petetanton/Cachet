<template>
    <a :href="`${dashboardurl}`" target="_blank">
        <div class="col-xs-3 list-group-item-error-budget" :id="`div_${metricId}`" style="margin: 15px">
            <span :id="`metric_name_${metricId}`" style="font-weight: bold">
                {{metric.name}}
            </span>
            <div class="metric-large" :id="`metric_large_${metricId}`"></div>
        </div>
    </a>
</template>

<script>
const _ = require('lodash')


module.exports = {
    props: [
        'metric',
        'theme',
        'theme-light',
        'theme-dark',
        'dashboardurl'
    ],
    data () {
        return {
            data: null,
            view: {
                param: null,
                title: null,
            },
            loading: false,
        }
    },
    mounted () {
        this.getData()

        $('.dropdown-toggle').dropdown()
    },
    computed: {
        metricId () {
            return `metric-${this.metric.id}`
        }
    },
    watch: {
        loading (val) {

        }
    },
    methods: {
        getData () {
            this.loading = true

            return axios.get('/metrics/'+this.metric.id, {
                params: {
                    filter: this.view.param
                }
            }).then(response => {
                this.data = response.data.data.items

                this.loading = false

                this.updateChart()
            })
        },
        changeView (param, title) {
            // Don't reload the same view.
            if (this.view.param === param) return

            this.view = {
                param: param,
                title: title
            }

            this.getData().then(this.updateChart)
        },
        updateChart () {
            var metric = this.metric;
            /*
             * Datetimes are used as keys instead of just time in order to
             * improve ordering of labels in "Last 12 hours", so we cut the
             * labels.
             * This cutting is done only if there is an hour in the string, so
             * if the view by day is set it doesn't fail.
             */
            var data_keys = _.keys(this.data);
            if (0 < data_keys.length && data_keys[0].length > 10) {
                for (var i = 0; i < data_keys.length; i++) {
                    data_keys[i] = data_keys[i].substr(11);
                }
            }

            var bigMetric = document.getElementById("metric_large_" + this.metricId)
            var div = document.getElementById("div_" + this.metricId)
            var metricName = document.getElementById("metric_name_" + this.metricId)

            var values = _.values(this.data)
            var latest = values[values.length - 1]

            if (latest <= 0.0) {
                metricName.style.color = 'white';
                bigMetric.style.color = 'white';
                div.style.backgroundColor = '#FF6F61';
            } else if (latest <= 15.0) {
                div.style.backgroundColor = '#EFC050';
            } else {
                metricName.style.color = 'white';
                bigMetric.style.color = 'white';
                div.style.backgroundColor = '#7ed321';
            }
            bigMetric.innerText = latest + " " + metric.suffix
        }
    }
}
</script>
