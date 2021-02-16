<template>
  <div>
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div class="page-title-icon">
            <i class="pe-7s-rocket icon-gradient bg-mean-fruit">
            </i>
          </div>
          <div>Dashboard
            <div class="page-title-subheading">
              Welcome! What do you want to do?
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 col-xl-6">
        <div class="card mb-3 widget-content bg-midnight-bloom">
          <div class="widget-content-wrapper text-white">
            <div class="widget-content-left">
              <div class="widget-heading">Total files input</div>
              <div class="widget-subheading">Report based on you input</div>
            </div>
            <div class="widget-content-right">
              <div class="widget-numbers text-white">
                <span>{{stats.filesCount}}</span></div>
            </div>
          </div>
        </div>
      </div>
      <div class=" col-md-6 col-xl-6" v-if="show">
        <div class="card mb-3 widget-content bg-arielle-smile">
          <div class="widget-content-wrapper text-white">
            <div class="widget-content-left">
              <div class="widget-heading">Total files</div>
              <div class="widget-subheading">Stored files on database</div>
            </div>
            <div class="widget-content-right">
              <div class="widget-numbers text-white"><span>{{stats.totalFiles}}</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-lg-12">
        <div class="mb-3 card">
          <div class="card-header-tab card-header-tab-animation card-header">
            <div class="card-header-title">
              <i class="header-icon lnr-apartment icon-gradient bg-love-kiss"> </i>
              Report based on your input
            </div>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <area-chart :data="getValue">
              </area-chart>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  import Vue from 'vue';
  import Chartkick from 'vue-chartkick';
  import Chart from 'chart.js';

  Vue.use(Chartkick.use(Chart))
  export default {
    title() {
      return 'Dashboard';
    },
    data() {
      return {
        stats: {}, // { filesCount, totalFiles }
        title: 'Home | Dashboard CRC CARE',
        getValue: null,
        show: false,
      }
    },
    created() {
      this.fetchStatistics();
    },
    mounted() {
      this.pushData();
      this.getUserRole();
    },
    methods: {
      async getUserRole() {
        const { data: user } = await axios.get('/api/current-user');
        this.show = user.role === 'admin';
      },
      async pushData() {
        const getValue = [];
        const res = await fetch('/getChartValue');
        const data = await res.json();
        data.forEach(element => {
          getValue.push([element.day, element.countValue])
        });
        this.getValue = getValue;
      },
      async fetchStatistics() {
        const { data } = await axios.get('/get-filename-count');
        this.stats = data;
      },
    },
  }

</script>
