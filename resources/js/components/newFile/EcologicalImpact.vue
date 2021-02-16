<template>
  <div class="main-card mb-3 card">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-6 text-left">
          <h5 class="card-title">Ecological Impact</h5>
        </div>
        <div class="col-lg-6 text-right">
          <span style="font-size:1.5rem; cursor:pointer;">
            <i @click="helpEcologicalImpact" class="pe-7s-help1 icon-gradient bg-mean-fruit"></i>
          </span>
        </div>
      </div>
      <div class="form-row mb-4">
        <div class="col-md-8">
          <div class="position-relative form-group">
            <label for="">E1: Weight on aquatic risk (downstream impact)</label>
            <vue-slider
                width='auto'
                :height='10'
                :dotSize="10"
                :min='0'
                :max='12000'
                :dot-options="dotOptions"
                :interval='50'
                :show='false'
                ref="slider"
                v-model="woar"
                :marks="sliderMarks"
                :tooltip="'always'"
                :disabled="isPreview"
                style="padding: 5px 0px; width: auto; height: 10px;margin-top: 30px;"
                @change="handleOnChange('woar')"
            />
          </div>
        </div>
        <div class="col-md-2">
          <div class="position-relative form-group" style="margin-top: 30px;">
            <label for="weight-on-aquatic-risk" style="color: #fff">WoAR</label>
            <div>
              <input
                  id="weight-on-aquatic-risk"
                  type="text"
                  v-model="woar"
                  class="form-control"
                  :disabled="isPreview"
                  @change="handleOnChange('woar')"
              />
            </div>
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-2">
          <div class="position-relative form-group">
            <label for="">E2: Erosion</label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="position-relative-form-group">
            <label for="" class="form-check-label">
              <input v-model="erosion" class="form-check-input"
                     type="radio" value="observation" :disabled="isPreview" @change="handleOnChange('erosion')" />
              Observation
            </label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="position-relative-form-group">
            <label for="" class="form-check-label">
              <input v-model="erosion" class="form-check-input"
                     type="radio" value="rusle" :disabled="isPreview" @change="handleOnChange('erosion')" />
              RUSLE model (Revised universal soil loss equation model)
            </label>
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-4" v-if="erosion === 'observation'">
          <div class="position-relative form-group">
            <select v-model="erosionval" class="form-control" :disabled="isPreview" @change="handleOnChange('erosionval')">
              <option v-bind:value="1">Tailing impoundment and/or contaminated
                material appears stable
                (no seepage / erosion)</option>
              <option v-bind:value="2">Evidence of slight erosion of waste /
                contaminated material
              </option>
              <option v-bind:value="3">Evidence of moderate erosion of waste /
                contaminated material
              </option>
              <option v-bind:value="4">Tailings / waste unstable (high erosion
                evident)
              </option>
            </select>
          </div>
        </div>
        <div class="col-md-4" v-if="erosion === 'rusle'">
          <div class="position-relative form-group">
            <select v-model="erosionvals" class="form-control" :disabled="isPreview" @change="handleOnChange('erosionvals')">
              <option v-bind:value="0">Very low ( &lt; 6.7 tonnes/ha/year)
              </option>
              <option v-bind:value="0.5">Low (6.7 - 11)</option>
              <option v-bind:value="1">Moderate (11.2 - 22.4)</option>
              <option v-bind:value="1.5">High (22.4 - 33.6)</option>
              <option v-bind:value="2">Severe ( &gt; 33.6)</option>
            </select>
          </div>
        </div>
      </div>
      <hr>
      <div class="form-row">
        <div class="col-md-3">
          <div class="position-relative form-group">
            <label for="">E3: Relative growth rate (aquatic environment)</label>
          </div>
        </div>
        <div class="col-md-4">
          <div class="position-relative form-group">
            <input type="text" v-model="rgrae" class="form-control"
                   :disabled="isPreview" @change="handleOnChange('rgrae')" />
          </div>
        </div>
        <div class="col-md-3">
          <vue-slider width='auto' :height='6' :dotSize="16" :min='0' :max='100'
                      :dot-options="dotOptions" :interval='1' :show='true' ref="slider"
                      v-model="rgrae" :tooltip="'always'"
                      :disabled="isPreview" @change="handleOnChange('rgrae')" />
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-3">
          <div class="position-relative form-group">
            <label for="">E4: Relative growth rate (terrestrial environment)</label>
          </div>
        </div>
        <div class="col-md-4">
          <div class="position-relative form-group">
            <input type="text" v-model="rgrte" class="form-control"
                   :disabled="isPreview" @change="handleOnChange('rgrte')" />
          </div>
        </div>
        <div class="col-md-3">
          <vue-slider width='auto' :height='6' :dotSize="16" :min='0' :max='100'
                      :dot-options="dotOptions" :interval='1' :show='true' ref="slider"
                      v-model="rgrte" :tooltip="'always'"
                      :disabled="isPreview" @change="handleOnChange('rgrte')" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import _ from 'lodash';
  import VueSlider from 'vue-slider-component';
  import { DEFAULT_ECOLOGICAL_IMPACT } from '../../includes/constants';
  import 'vue-slider-component/theme/default.css';

  export default {
    components: { VueSlider },

    props: {
      ecologicalImpacts: Object,
      isPreview: Boolean,
      onChange: Function,
    },

    data() {
      return {
        dotOptions: [{
          tooltip: 'always'
        }, {
          tooltip: 'always'
        }],
        sliderMarks: {
          '0': '0',
          '500': '500 m',
          '1500': '1500 m',
          '5000': '5000 m',
          '10000': '10000 m',
        },

        // input data
        woar: this.ecologicalImpacts.woar,
        erosion: this.ecologicalImpacts.erosion,
        erosionval: this.ecologicalImpacts.erosionval,
        erosionvals: this.ecologicalImpacts.erosionvals,
        rgrae: this.ecologicalImpacts.rgrae,
        rgrte: this.ecologicalImpacts.rgrte,
      };
    },

    watch: {
      ecologicalImpacts: function(newEcoImpacts) {
        if (_.isEmpty(newEcoImpacts)) {
          _.keys(DEFAULT_ECOLOGICAL_IMPACT).forEach((prop) => {
            this[prop] = DEFAULT_ECOLOGICAL_IMPACT[prop];
          });
        } else {
          this.woar = this.ecologicalImpacts.woar;
          this.erosion = this.ecologicalImpacts.erosion;
          this.erosionval = this.ecologicalImpacts.erosionval;
          this.erosionvals = this.ecologicalImpacts.erosionvals;
          this.rgrae = this.ecologicalImpacts.rgrae;
          this.rgrte = this.ecologicalImpacts.rgrte;
        }
      },
    },

    methods: {
      helpEcologicalImpact() {
        Swal.fire({
          icon: 'question',
          title: 'Ecological impact section',
          text: 'Adjust the slider to estimate the approximate distance between the mine site and the location of the ecological site (e.g. river or forest). Alternatively, you can manually enter the approximate distance in the box. Select whether the data are from observation, or modelling using the Revised Universal Soil Loss Equation (RUSLE) model. Then select the extent of erosion. If available, use the slider to enter the growth rate of plants in an aquatic or terrestrial environment based on laboratory-based seed tests (this can be left as zero if values are not available.',
          showCloseButton: true,
          showConfirmButton: false,
        });
      },

      handleOnChange(field) {
        this.onChange(field, this[field]);
      }
    },
  };
</script>
