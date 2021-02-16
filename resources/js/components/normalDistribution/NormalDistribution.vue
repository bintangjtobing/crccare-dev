<template>
  <div>
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div class="page-title-icon">
            <i class="pe-7s-graph3 icon-gradient bg-mean-fruit">
            </i>
          </div>
          <div>Normal distribution
            <div class="page-title-subheading">
              View the overall distribution of risk to identify if new cases are normal or extreme.
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-lg-6">
        <div class="mb-3 card">
          <div class="card-header-tab card-header">
            <div class="card-header-title">
              <i class="header-icon lnr-chart-bars icon-gradient bg-love-kiss"> </i>
              Normal distribution
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" role="tabpanel">
                <canvas id="areaChart"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-lg-6">
        <box-chart :results="apiData" v-if="!isLoading" />
      </div>
    </div>
  </div>
</template>
<script>
  import _ from 'lodash';
  import Chart from 'chart.js';
  import * as moment from 'moment';
  import 'chartjs-plugin-annotation';
  import BoxChart from './BoxChart';
  import { calculateMean, calculateStdDeviation, calculateNormalDistribution } from './calculations';

  export default {
    components: {
      BoxChart,
    },

    title() {
      return 'Normal distribution';
    },
    data() {
      return {
        isLoading: true,
        apiData: [],
        boxDataArea: [],
        boxDataPlot: [],
        retrieveDataBox: [],
        boxDataEl: [],
      }
    },
    async mounted() {
      await this.getData();
      this.isLoading = false;
      this.createNormalDistributionChart('areaChart');
    },
    methods: {
      async getData() {
        const { data } = await axios.get('/api/scores?statsData=1');
        this.apiData = data;
      },

      createNormalDistributionChart(canvasId) {
        const sortedData = _.orderBy(this.apiData, 'scoreAdult', 'asc');
        const scoreAdults = _.map(sortedData, ({ scoreAdult }) => parseFloat(scoreAdult.toFixed(1)));
        const mean = calculateMean(scoreAdults);
        const stdDeviation = calculateStdDeviation(scoreAdults);
        const minValue = mean - 4 * stdDeviation;
        const maxValue = mean + 4 * stdDeviation;
        const unit = (Math.abs(minValue) + Math.abs(maxValue)) / 100;
        const dataToCalculate = _.range(minValue, maxValue, unit);

        const chartData = _.map(calculateNormalDistribution(dataToCalculate, { mean, stdDeviation }), (num, index) => ({
          x: dataToCalculate[index],
          y: num,
        }));

        const areaChartEl = document.getElementById(canvasId);
        const myChart = new Chart(areaChartEl, {
          type: 'line',
          data: {
            datasets: [{
              data: chartData,
              fill: 'origin',
              label: 'Normal Distribution',
            }],
          },
          options: {
            // not displaying the dots in the chart
            elements: {
              point: {
                radius: 0,
              }
            },
            scales: {
              xAxes: [{
                type: 'linear',
                scaleLabel: {
                  display: true,
                  fontSize: 16,
                  labelString: 'Score (adult)',
                  fontColor: '#20aa4f',
                },
                gridLines: {
                  drawTicks: true,
                },
                ticks: {
                  stepSize: unit * 20,
                },
              }],
            },
            legend: {
              display: false,
            },
            annotation: {
              annotations: [
                {
                  type: 'line',
                  mode: 'vertical',
                  scaleID: 'x-axis-0',
                  value: mean,
                  borderColor: 'red',
                  label: {
                    content: `μ = ${mean.toFixed(1)}`,
                    enabled: true,
                    position: 'bottom',
                  }
                },
                {
                  type: 'line',
                  mode: 'vertical',
                  scaleID: 'x-axis-0',
                  value: mean - stdDeviation,
                  borderColor: 'blue',
                  label: {
                    content: `μ - σ = ${(mean - stdDeviation).toFixed(1)}`,
                    enabled: true,
                    position: 'top',
                  }
                },
                {
                  type: 'line',
                  mode: 'vertical',
                  scaleID: 'x-axis-0',
                  value: mean + stdDeviation,
                  borderColor: 'blue',
                  label: {
                    content: `μ + σ = ${(mean + stdDeviation).toFixed(1)}`,
                    enabled: true,
                    position: 'top',
                  }
                },
              ],
            },
          },
          lineAtIndex: [50],
        });
      },

      currentDateTime() {
        return moment().format('YYYY-MM-DD HH:mm:ss');
      },
    }
  }

</script>
