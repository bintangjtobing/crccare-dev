<template>
  <div>
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div class="page-title-icon">
            <i class="pe-7s-graph3 icon-gradient bg-mean-fruit">
            </i>
          </div>
          <div>Pie chart
            <div class="page-title-subheading">
              View information about user activities.
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
              Pie chart
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="mean-value" role="tabpanel">
                <canvas id="pieChart"></canvas>
                <div>
                  <v-data-table
                      :headers="headers"
                      :items="tableData"
                      :items-per-page="5"
                      :sort-by="['score']"
                      :sort-desc="[true]"
                      class="elevation-1"
                  >
                    <template v-slot:item.score="{ item }">
                      {{ item.score.toFixed(1) }}
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
  import * as moment from 'moment';

  export default {
    title() {
      return 'Pie chart';
    },
    data() {
      return {
        apiData: [],
        tableData: [],                // also used to display filtered data if user clicks on the graph
        headers: [{
          text: 'User',
          value: 'username'
        },
          {
            text: 'Filename',
            value: 'filename'
          },
          {
            text: 'Score (adult)',
            value: 'score'
          }
        ],
      }
    },

    computed: {
      pieData: function () {
        return _.map(this.apiData, ({ userName, fileName, totalData, scoreAdult }) => ({
          countFile: totalData,
          username: userName,
          filename: fileName,
          score: +scoreAdult,
        }));
      }
    },

    async mounted() {
      await this.getDataPie();
      this.createPieChart();
    },

    methods: {
      getRandomColor() {
        const letters = '0123456789ABCDEF'.split('');
        let color = '#';
        for (let i = 0; i < 6; i++) {
          color += letters[Math.floor(Math.random() * 8)];
        }
        return color;
      },

      /**
       * get all data if no username is defined
       * otherwise get data for that username only
       *
       * @param {string|null} username
       * @returns {Object[]}
       */
      getTableData(username = null) {
        const data = username ? _.filter(this.apiData, { userName: username }) : this.apiData;

        return _(data)
          .map(({ scoreAdult, fileName, userName }) => {
            const scores = scoreAdult.split(',');
            const fileNames = fileName.split(',');

            const tableRows = [];
            for (let i = 0; i < scores.length; i++) {
              tableRows.push({
                username: userName,
                filename: fileNames[i],
                score: +scores[i],
              });
            }
            return tableRows;
          })
          .flatten()
          .value();
      },

      async getDataPie() {
        const { data } = await axios.get('/count-data-pie');
        this.apiData = data;

        this.tableData = this.getTableData();
      },

      createPieChart() {
        const dataSet = {};
        const labels = [];
        const data = [];
        const randomColors = [];
        for (const { username, countFile } of this.pieData) {
          labels.push(username);
          data.push(countFile);
          randomColors.push(this.getRandomColor());
        }
        dataSet.labels = labels;
        dataSet.datasets = [{
          data,
          backgroundColor: randomColors,
        }];

        const pieChartEl = document.getElementById('pieChart');
        const myChart = new Chart(pieChartEl, {
          type: 'pie',
          data: dataSet,
          options: {
            responsive: true,
          }
        });
        pieChartEl.onclick = (evt) => {
          const activePoints = myChart.getElementsAtEvent(evt);
          if (activePoints[0]) {
            const chartData = activePoints[0]['_chart'].config.data;
            const idx = activePoints[0]['_index'];
            const label = chartData.labels[idx];

            this.tableData = this.getTableData(label);
          }
        };
      },
      currentDateTime() {
        return moment().format('YYYY-MM-DD HH:mm:ss');
      },
    }
  }

</script>
