<template>
  <div class="main-card mb-3 card">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-6 text-left">
          <h5 class="card-title">Groundwater impact</h5>
        </div>
        <div class="col-lg-6 text-right">
          <span style="font-size:1.5rem; cursor:pointer;">
              <i @click="helpGroundwaterImpact" class="pe-7s-help1 icon-gradient bg-mean-fruit"></i>
          </span>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-8">
          <div class="position-relative form-group">
            <label for="">G1: Levels of contaminants</label>
            <label for="">Groundwater concentrations are higher than the human health
              and ecological investigation or assessment levels?</label>
            <fieldset class="position-relative form-group">
              <div class="row">
                <div class="col-md-3">
                  <div class="position-relative form-check">
                    <label class="form-check-label">
                      <input v-model="loc" type="radio" :value="1" class="form-check-input" :disabled="isPreview" @change="handleOnChange('loc')" />
                      Yes
                    </label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="position-relative form-check"><label
                      class="form-check-label"><input
                      v-model="loc" type="radio"
                      :value="0" class="form-check-input"
                      :disabled="isPreview" @change="handleOnChange('loc')" />
                    No</label>
                  </div>
                </div>
              </div>
            </fieldset>
          </div>
        </div>
      </div>
      <hr>
      <div class="form-row">
        <div class="col-md-8">
          <div class="position-relative form-group">
            <label for="">G2: Synthetic precipitation leaching procedure (SPLP) values
            </label>
            <label for="">SPLP concentrations are higher than the human health and
              ecological investigation or assessment levels?</label>
            <fieldset class="position-relative form-group">
              <div class="row">
                <div class="col-md-3">
                  <div class="position-relative form-check"><label
                      class="form-check-label"><input
                      v-model="splp" type="radio"
                      :value="1" class="form-check-input"
                      :disabled="isPreview" @change="handleOnChange('splp')" />
                    Yes</label>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="position-relative form-check"><label
                      class="form-check-label"><input
                      v-model="splp" type="radio"
                      :value="0" class="form-check-input"
                      :disabled="isPreview" @change="handleOnChange('splp')" />
                    No</label>
                  </div>
                </div>
              </div>
            </fieldset>
          </div>
        </div>
      </div>
      <hr>
      <div class="form-row">
        <div class="col-md-10">
          <div class="position-relative form-group">
            <label for="">G3: Depth to the groundwater
            </label>
            <fieldset class="position-relative form-group">
              <div class="position-relative form-check"><label
                  class="form-check-label"><input
                  v-model="dttg" type="radio" value="1"
                  class="form-check-input" :disabled="isPreview" @change="handleOnChange('dttg')" />
                Groundwater table in unconfined aquifer below ground
                surface &lt; 5 m bgs. </label>
              </div>
              <div class="position-relative form-check"><label
                  class="form-check-label"><input
                  v-model="dttg" type="radio" value="2"
                  class="form-check-input" :disabled="isPreview" @change="handleOnChange('dttg')" />
                Groundwater table in unconfined aquifer below ground
                surface &gt; 5 m bgs and &lt; 10 m bgs. </label>
              </div>
              <div class="position-relative form-check"><label
                  class="form-check-label"><input
                  v-model="dttg" type="radio" value="3"
                  class="form-check-input" :disabled="isPreview" @change="handleOnChange('dttg')" />
                Groundwater table in unconfined aquifer below ground
                surface &gt; 10 m bgs. </label>
              </div>
            </fieldset>
          </div>
        </div>
      </div>
      <hr>
      <div class="form-row">
        <div class="col-md-10">
          <div class="position-relative form-group">
            <label for="">G4: Off-site impact and liability issues
            </label>
            <fieldset class="position-relative form-group">
              <div class="position-relative form-check"><label
                  class="form-check-label"><input
                  v-model="oial" type="radio" value="1"
                  class="form-check-input" :disabled="isPreview" @change="handleOnChange('oial')" />
                Groundwater flow direction towards sensitive receptor
                and velocity &lt; 5 m/year. </label>
              </div>
              <div class="position-relative form-check"><label
                  class="form-check-label"><input
                  v-model="oial" type="radio" value="2"
                  class="form-check-input" :disabled="isPreview" @change="handleOnChange('oial')" />
                Groundwater flow direction towards sensitive receptor
                and velocity &gt; 5 m/year and &lt; 20 m/year. </label>
              </div>
              <div class="position-relative form-check"><label
                  class="form-check-label"><input
                  v-model="oial" type="radio" value="3"
                  class="form-check-input" :disabled="isPreview" @change="handleOnChange('oial')" />
                Groundwater flow direction towards sensitive receptor
                and velocity &gt; 20 m/year and &lt; 30 m/year. </label>
              </div>
              <div class="position-relative form-check"><label
                  class="form-check-label"><input
                  v-model="oial" type="radio" value="4"
                  class="form-check-input" :disabled="isPreview" @change="handleOnChange('oial')" />
                Groundwater flow direction towards sensitive receptor
                and velocity &gt; 30 m/year. </label>
              </div>
            </fieldset>
          </div>
        </div>
      </div>
      <hr>
      <div class="form-row">
        <div class="col-md-10">
          <div class="position-relative form-group">
            <label for="">G5: Nearest drinking groundwater borehole
            </label>
            <fieldset class="position-relative form-group">
              <div class="position-relative form-check"><label
                  class="form-check-label"><input
                  v-model="ndgb" type="radio" value="1"
                  class="form-check-input" :disabled="isPreview" @change="handleOnChange('ndgb')" />
                Nearest drinking groundwater borehole / residence &le;
                5000 m. </label>
              </div>
              <div class="position-relative form-check"><label
                  class="form-check-label"><input
                  v-model="ndgb" type="radio" value="2"
                  class="form-check-input" :disabled="isPreview" @change="handleOnChange('ndgb')" />
                Nearest drinking groundwater borehole / residence &le;
                2000 m. </label>
              </div>
              <div class="position-relative form-check"><label
                  class="form-check-label"><input
                  v-model="ndgb" type="radio" value="3"
                  class="form-check-input" :disabled="isPreview" @change="handleOnChange('ndgb')" />
                Nearest drinking groundwater borehole / residence &le;
                1000 m. </label>
              </div>
              <div class="position-relative form-check"><label
                  class="form-check-label"><input
                  v-model="ndgb" type="radio" value="4"
                  class="form-check-input" :disabled="isPreview" @change="handleOnChange('ndgb')" />
                Nearest drinking groundwater borehole / residence &le;
                500 m. </label>
              </div>
            </fieldset>
          </div>
        </div>
      </div>
      <hr>
      <div class="form-row">
        <div class="col-md-10">
          <div class="position-relative form-group">
            <label for="">G6: Applicability of institution control
            </label>
            <fieldset class="position-relative form-group">
              <div class="position-relative form-check"><label
                  class="form-check-label"><input
                  v-model="aoic" type="radio" value="1"
                  class="form-check-input" :disabled="isPreview" @change="handleOnChange('aoic')" />
                Stringent institutional control could be applied.
              </label>
              </div>
              <div class="position-relative form-check"><label
                  class="form-check-label"><input
                  v-model="aoic" type="radio" value="2"
                  class="form-check-input" :disabled="isPreview" @change="handleOnChange('aoic')" />
                Institutional control could be applied but difficult to follow
                up.
              </label>
              </div>
              <div class="position-relative form-check"><label
                  class="form-check-label"><input
                  v-model="aoic" type="radio" value="3"
                  class="form-check-input" :disabled="isPreview" @change="handleOnChange('aoic')" />
                No institutional control could be applied.
              </label>
              </div>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import _ from 'lodash';
  import { DEFAULT_GROUND_WATER_IMPACT } from '../../includes/constants';

  export default {
    props: {
      groundWaterImpacts: Object,
      isPreview: Boolean,
      onChange: Function,
    },

    data() {
      return {
        loc: this.groundWaterImpacts.loc,
        splp: this.groundWaterImpacts.splp,
        dttg: this.groundWaterImpacts.dttg,
        oial: this.groundWaterImpacts.oial,
        ndgb: this.groundWaterImpacts.ndgb,
        aoic: this.groundWaterImpacts.aoic,
      };
    },

    watch: {
      groundWaterImpacts: function(newGroundWaterImpacts) {
        if (_.isEmpty(newGroundWaterImpacts)) {
          _.keys(DEFAULT_GROUND_WATER_IMPACT).forEach((prop) => {
            this[prop] = DEFAULT_GROUND_WATER_IMPACT[prop];
          });
        } else {
          this.loc = this.groundWaterImpacts.loc;
          this.splp = this.groundWaterImpacts.splp;
          this.dttg = this.groundWaterImpacts.dttg;
          this.oial = this.groundWaterImpacts.oial;
          this.ndgb = this.groundWaterImpacts.ndgb;
          this.aoic = this.groundWaterImpacts.aoic;
        }
      },
    },

    methods: {
      helpGroundwaterImpact() {
        Swal.fire({
          icon: 'question',
          title: 'Groundwater impact section',
          text: 'Select the required answers based on your analytics or other knowledge.',
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
