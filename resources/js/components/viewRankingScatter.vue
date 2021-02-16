<template>
  <div>
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div class="page-title-icon">
            <i class="pe-7s-graph3 icon-gradient bg-mean-fruit">
            </i>
          </div>
          <div>Ranking scatter plot
            <div class="page-title-subheading">
              Rank sites based on risk. Click on dots to view data.
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-lg-12">
        <div class="mb-3 card">
          <div class="card-header-tab card-header">
            <div class="card-header-title">
              <i class="header-icon lnr-chart-bars icon-gradient bg-love-kiss"> </i>
              Ranking scatter plot
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="mean-value" role="tabpanel">
                <canvas id="scatterPlot"></canvas>
                <div class="mt-3">
                  <v-data-table
                      :headers="headers"
                      :items="rankedData"
                      :items-per-page="5"
                      class=" elevation-1"
                  >
                    <template v-slot:item.scoreAdult="{ item }">
                      {{ item.scoreAdult.toFixed(1) }}
                    </template>
                  </v-data-table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import _ from 'lodash';
  import Chart from 'chart.js';
  import Swal from 'sweetalert2';
  import * as moment from 'moment';

  export default {
    title() {
      return 'Ranking scatter plot';
    },
    data() {
      return {
        key: 1,
        scores: [],
        scatterData: [],
        headers: [{
          text: 'No of rank',
          value: 'rank'
        }, {
          text: 'Username',
          value: 'user.name'
        }, {
          text: 'Filename',
          value: 'score.filename'
        }, {
          text: 'Score (adult)',
          value: 'scoreAdult',
          sortable: true,
        }],
      }
    },
    computed: {
      rankedData() {
        const scoreSorted = _.orderBy(this.scores, ['scoreAdult'], ['desc']);
        return _.map(scoreSorted, (score, index) => ({
          ...score,
          rank: index + 1,
        }));
      },
    },
    async mounted() {
      await this.getDataResults();
      this.createScatterPlotChart();
    },
    methods: {
      async getDataResults() {
        const { data } = await axios.get('/api/scores');
        this.scores = data;
      },
      createScatterPlotChart() {
        if (!this.rankedData.length) return;

        const scoreAscending = _.orderBy(this.rankedData, ['scoreAdult'], ['asc']);

        for (const { id, rank, scoreAdult, score } of scoreAscending) {
          this.scatterData.push({
            x: rank,
            y: scoreAdult.toFixed(1),
            id,
            filename: score.filename,
          });
        }

        // initiate data to chart
        const dataSet = {
          datasets: [{
            label: 'Ranking scatter',
            data: this.scatterData,
            backgroundColor: 'rgb(71, 183,132)'
          }],
        };

        const scatterChartEl = document.getElementById('scatterPlot');
        const myChart = new Chart(scatterChartEl, {
          type: 'scatter',
          data: dataSet,

          options: {
            tooltips: {
              callbacks: {
                title: (tooltipItem) => {
                  const { index } = tooltipItem[0];
                  return this.scatterData[index].filename;
                },
                label: (tooltipItem) => tooltipItem.value,
              },
            },

            responsive: true,
            scales: {
              x: {
                type: 'linear',
                position: 'bottom'
              },
              yAxes: [{
                scaleLabel: {
                  display: true,
                  fontSize: 16,
                  labelString: "Score (adult)",
                  fontColor: '#20aa4f',
                },
              }],
              xAxes: [{
                scaleLabel: {
                  display: true,
                  fontSize: 16,
                  labelString: "Number of ranking",
                  fontColor: '#20aa4f',
                },
                ticks: {
                  stepSize: 1,
                },
              }],
            },
          }
        });
        scatterChartEl.onclick = async (evt) => {
          const activePoints = myChart.getElementAtEvent(evt);
          const result = await Swal.fire({
            title: 'Are you sure wanna see the details data?',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonText: `Yes`,
          });
          if (result.isConfirmed && activePoints[0]) {
            const chartData = activePoints[0]['_chart'].config.data;
            const idx = activePoints[0]['_index'];
            const value = chartData.datasets[0].data[idx];
            location.href = `/view-data-results/${value.id}`;
          }
        };
      },
      currentDateTime() {
        return moment().format('YYYY-MM-DD HH:mm:ss');
      },
    },
  }

</script>
