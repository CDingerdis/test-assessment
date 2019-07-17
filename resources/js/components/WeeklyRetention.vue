<template>
    <div>
        <highcharts :options="chartOptions"></highcharts>
        <div id="explanation">
            <ul>
                <li>Click on the week number on the top of the chart to show/hide that week.</li>
            </ul>
        </div>
    </div>
</template>
<script>
    import { Chart } from 'highcharts-vue';

    export default {
        props: ['values', 'steps'],
        components: {
            highcharts: Chart
        },
        mounted() {
            let series = [];
            let xAxis = { categories: Object.values(this.steps) };
            for (let key in this.values) {
                let values = this.values[key];
                series.push({
                    name: 'Week ' + key,
                    data: values,
                });
            }
            this.chartOptions = { xAxis: xAxis, series: series };
        },
        data() {
            return {
                chartOptions: {
                    chart: {
                        type: 'spline',
                    },
                    title: {
                        text: 'Retention curve onboarding flow'
                    },
                    legend: {
                        align: 'center',
                        verticalAlign: 'top'
                    },
                    plotOptions: {
                        spline: {
                            lineWidth: 2,
                            states: {
                                hover: {
                                    lineWidth: 3
                                }
                            },
                            dataLabels: { enabled: false },
                            // enableMouseTracking: false,
                            marker: { enabled: false },
                        }
                    },
                    xAxis: {
                        title: {
                            text: 'Onboarding flow step'
                        },
                    },
                    yAxis: {
                        title: {
                            text: '% users who have been or are still in this step '
                        },
                        tickInterval: 10,
                        maxValue: 100,
                        max: 100,
                        min: 0,
                        labels: {
                            format: '{value} %',
                        },
                        dataLabels: true,
                    }
                }
            };
        },
    };
</script>
<style scoped>
    #explanation {
        padding: 50px 0px 50px 0px;
    }
</style>
