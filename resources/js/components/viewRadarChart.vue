<template>
  <div>
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div class="page-title-icon">
            <i class="pe-7s-graph3 icon-gradient bg-mean-fruit">
            </i>
          </div>
          <div>Radar chart
            <div class="page-title-subheading">
              Compare site impacts with all risk data to identify human and environmental vulnerabilities.
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
              Radar chart
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="mean-value" role="tabpanel">
                <div class="form-group">
                  <select @change="selectCase" class="form-control">
                    <option selected>Select data case:</option>
                    <option v-for="score in scores" :key="score.id" v-bind:value="score.id">
                      {{score.user.name}} - {{score.score.filename}}
                    </option>
                  </select>
                </div>
                <canvas id="radarChart"></canvas>
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
  import Calculation from '../includes/Calculation';

  export default {
    title() {
      return 'Radar chart';
    },
    data() {
      return {
        scores: [],
        allScores: [],
        G: {
          max: 0,
          mean: 0,
        },
        ecologicalImpact: {
          max: 0,
          mean: 0,
        },
        humanImpactAdult: {
          max: 0,
          mean: 0,
        },
        humanImpactChildren: {
          max: 0,
          mean: 0,
        },
        chart: null,
      }
    },
    mounted() {
      this.getData();
    },
    methods: {
      selectCase(event) {
        const dataSet = {};
        const score = _.find(this.scores, { id: +event.target.value });

        dataSet.labels = ['Groundwater impact', 'Ecological impact', 'Human impact adult', 'Human impact child'];
        dataSet.datasets = [{
          label: score.score.filename,
          data: [
            score.G.toFixed(1),
            score.ecologicalImpactScore.toFixed(1),
            score.humanImpactAdult.toFixed(1),
            score.humanImpactChild.toFixed(1),
          ],
          borderColor: '#f29a29',
          borderWidth: 2
        }, {
          label: 'Max',
          data: [
            this.G.max.toFixed(1),
            this.ecologicalImpact.max.toFixed(1),
            this.humanImpactAdult.max.toFixed(1),
            this.humanImpactChildren.max.toFixed(1),
          ],
          borderColor: '#204ae7',
          borderWidth: 2
        }, {
          label: 'Mean',
          data: [
            this.G.mean.toFixed(1),
            this.ecologicalImpact.mean.toFixed(1),
            this.humanImpactAdult.mean.toFixed(1),
            this.humanImpactChildren.mean.toFixed(1),
          ],
          borderColor: '#2f8d28',
          borderWidth: 2,
        }];
        dataSet.title = ['Groundwater impact', 'Ecological impact', 'Human impact adult', 'Human impact child'];
        this.createChart(dataSet);
      },

      async getData() {
        const [userScoreResp, allScoreResp] = await Promise.all([
          axios.get('/api/scores'),
          axios.get('/api/scores?statsData=1'),
        ]);
        this.scores = _.orderBy(userScoreResp.data, ['user.name', 'score.filename'], ['asc', 'asc']);
        this.allScores = allScoreResp.data;
        Calculation.setData(this.allScores);

        this.G = {
          max: Calculation.getMaxG(),
          mean: Calculation.getMeanG(),
        };
        this.ecologicalImpact = {
          max: Calculation.getMaxEcological(),
          mean: Calculation.getMeanEcological(),
        };
        this.humanImpactAdult = {
          max: Calculation.getMaxHumanImpactAdult(),
          mean: Calculation.getMeanHumanImpactAdult(),
        };
        this.humanImpactChildren = {
          max: Calculation.getMaxHumanImpactChild(),
          mean: Calculation.getMeanHumanImpactChild(),
        };
      },

      createChart(data) {
        const radarChartEl = document.getElementById('radarChart');

        // destroy the previous instance of the chart before creating a new one
        if (!_.isNil(this.chart)) this.chart.destroy();

        this.chart = new Chart(radarChartEl, {
          type: 'radar',
          data,
          options: {
            responsive: true,
            lineTension: 1,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: true,
                  padding: 25,
                },
              }],
            },
            tooltips: {
              callbacks: {
                title: (item) => data.title[item[0].index],
              },
            },
          },
        });
      },
    },
  };
</script>
