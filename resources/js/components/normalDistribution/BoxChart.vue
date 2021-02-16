<template>
  <div class="mb-3 card">
    <div class="card-header-tab card-header">
      <div class="card-header-title">
        <i class="header-icon lnr-chart-bars icon-gradient bg-love-kiss"> </i>
        Box Chart
      </div>
    </div>
    <div class="card-body">
      <div class="tab-content">
        <div class="tab-pane active" role="tabpanel">
          <canvas id="areaBoxPlot"></canvas>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Chart from 'chart.js';
  import 'chartjs-chart-box-and-violin-plot';
  import { calculateQ1, calculateQ3, calculateMedian } from './calculations';

  export default {
    props: {
      results: Array,
    },

    mounted() {
      this.renderBoxPlot('areaBoxPlot');
    },

    methods: {
      renderBoxPlot(canvasId) {
        const scores = this.results.map(({ scoreAdult }) => scoreAdult).sort();
        const min = Math.min(...scores);
        const max = Math.max(...scores);
        const q1 = calculateQ1(scores);
        const q3 = calculateQ3(scores);
        const median = calculateMedian(scores);

        const data = {
          labels: ['Plot area'],
          datasets: [{
            label: 'Score',
            backgroundColor: 'rgba(22,170,79,0.5)',
            borderColor: 'green',
            borderWidth: 1.5,
            outlierColor: '#999999',
            padding: 10,
            data: [{
              min,
              median,
              max,
              q1,
              q3,
              whiskerMin: min,
              whiskerMax: max,
            }],
          }],
        };

        const boxChartEl = document.getElementById(canvasId);
        const myChart = new Chart(boxChartEl, {
          type: 'boxplot',
          data,
          options: {
            responsive: true,
            tooltips: {
              callbacks: {
                title: () => 'Boxplot chart',
                label: () => ([
                  `Max: ${max.toFixed(1)}`,
                  `Min: ${min.toFixed(1)}`,
                  `Q1: ${q1.toFixed(1)}`,
                  `Q3: ${q3.toFixed(1)}`,
                  `Median: ${median.toFixed(1)}`,
                ]),
              },
            },
            scales: {
              xAxes: [{
                scaleLabel: {
                  display: true,
                  fontSize: 14,
                  fontColor: '#20aa4f',
                },
              }],
              yAxes: [{
                ticks: {
                  // leave 10% space on top and bottom
                  suggestedMin: min - Math.abs(min) * 0.1,
                  suggestedMax: max + Math.abs(max) * 0.1,
                },
              }],
            },
            legend: {
              position: 'right',
            },
            title: {
              display: true,
              text: 'Box chart data'
            }
          },
        });
      }
    },
  };
</script>
