<template>
  <div>
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div class="page-title-icon">
            <i class="pe-7s-note icon-gradient bg-mean-fruit">
            </i>
          </div>
          <div>Previous Data
            <div class="page-title-subheading">
              Preview results of previously input data
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="!isLoading">
      <div class="main-card mb-3 card">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6">
              Score Adult: {{ result.scoreAdult.toFixed(1) }}
            </div>
            <div class="col-lg-6">
              Score Children: {{ result.scoreChildren.toFixed(1) }}
            </div>
          </div>
        </div>
      </div>

      <file-name
          :isPreview="true"
          :data="fileName"
          :errors="{}"
      />

      <chemical-profile
          :isPreview="true"
          :shouldHideForm="true"
          :chemicals="chemicals"
          :fileChemicals="fileChemicals"
      />

      <human-impact
          :isPreview="true"
          :humanImpacts="humanImpacts"
      />

      <ecological-impact
          :isPreview="true"
          :ecologicalImpacts="ecologicalImpacts"
      />

      <ground-water-impact
          :isPreview="true"
          :groundWaterImpacts="groundWaterImpacts"
      />

      <div class="main-card mb-3 card">
        <div class="card-body">
          <div class="row">
            <div class="col-lg-6 text-left">
              <h5 class="card-title">Uploaded documents</h5>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="document-item" v-for="doc in result.score.documents" :key="doc.id">
                <a :href="`/api/documents/${doc.id}`" target="_blank">{{ doc.file }}</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <router-link :to="`/files/${result.id}`" tag="button" class="btn-shadow btn-wide btn-pill btn-hover-shine btn btn-success">Edit</router-link>
    </div>
  </div>
</template>

<script>
  import _ from 'lodash';
  import axios from 'axios';
  import FileName from './FileName';
  import ChemicalProfile from './ChemicalProfile';
  import HumanImpact from './HumanImpact';
  import EcologicalImpact from './EcologicalImpact';
  import GroundWaterImpact from './GroundWaterImpact';

  export default {
    title() {
      return 'View data details';
    },

    components: {
      FileName,
      ChemicalProfile,
      HumanImpact,
      EcologicalImpact,
      GroundWaterImpact,
    },

    data() {
      return {
        isLoading: true,
        chemicals: {},
        result: {},
      };
    },

    computed: {
      fileName: function () {
        return {
          name: _.get(this.result, 'score.filename', ''),
          desc: _.get(this.result, 'score.description', ''),
        };
      },
      fileChemicals: function () {
        return _.keyBy(_.get(this.result, 'score.chemicals', []), 'id');
      },
      humanImpacts: function () {
        return {
          wohr: _.get(this.result, 'score.weightOnHumanRisk'),
          aos: _.get(this.result, 'score.areaOfSoil'),
          gep: _.get(this.result, 'score.groundWaterExposure'),
          hgc: _.get(this.result, 'score.groundWaterConsumptionChild'),
          hgco: _.get(this.result, 'score.groundWaterConsumptionAdult'),
          swep: _.get(this.result, 'score.surfaceWaterExposure'),
          hswc: _.get(this.result, 'score.surfaceWaterConsumptionChild'),
          hswco: _.get(this.result, 'score.surfaceWaterConsumptionAdult'),
        };
      },
      ecologicalImpacts: function () {
        return {
          woar: _.get(this.result, 'score.aquaticRisk'),
          erosion: _.get(this.result, 'score.erosionType'),
          erosionval: _.get(this.result, 'score.erosionValueObservation'),
          erosionvals: _.get(this.result, 'score.erosionValueRUSLE'),
          rgrae: _.get(this.result, 'score.growthRateAquatic'),
          rgrte: _.get(this.result, 'score.growthRateTerrestrial'),
        };
      },
      groundWaterImpacts: function () {
        return {
          loc: _.get(this.result, 'score.levelOfContaminant'),
          splp: _.get(this.result, 'score.splp'),
          dttg: _.get(this.result, 'score.groundWaterDepth'),
          oial: _.get(this.result, 'score.offsiteImpact'),
          ndgb: _.get(this.result, 'score.nearestBorehole'),
          aoic: _.get(this.result, 'score.institutionControl'),
        };
      },
    },

    async beforeMount() {
      await Promise.all([
        this.getScoreResult(this.$route.params.id),
        this.getChemicals(),
      ]);
      this.isLoading = false;
    },

    methods: {
      async getScoreResult(id) {
        const { data } = await axios.get(`/api/score-results/${id}`);
        this.result = data;
      },

      async getChemicals() {
        const { data } = await axios.get('/api/chemicals');
        this.chemicals = _.keyBy(data, 'id');
      }
    },
  }
</script>
