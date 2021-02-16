<template>
  <div class="main-card mb-3 card">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-6 text-left">
          <h5 class="card-title">Human impact</h5>
        </div>
        <div class="col-lg-6 text-right">
          <span style="font-size:1.5rem; cursor:pointer;">
              <i @click="helpHumanImpact" class="pe-7s-help1 icon-gradient bg-mean-fruit">
              </i>
          </span>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-8">
          <div class="position-relative form-group">
            <label for="weightOnHumanRisk">H1: Weight on human risk (w)</label>
            <input
                id="weightOnHumanRisk"
                type="number"
                step="0.5"
                v-model="wohr"
                placeholder="1"
                class="form-control"
                :disabled="isPreview"
                @blur="handleOnChange('wohr')"
            />
          </div>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-8">
          <div class="position-relative form-group">
            <label>H2: Area of soil (shallow [0-0.2
              m] contamination cover)</label>
            <fieldset class="position-relative form-group">
              <div class="position-relative form-check">
                <label class="form-check-label">
                  <input v-model="aos" type="radio" value="1" class="form-check-input" :disabled="isPreview" @change="handleOnChange('aos')" />
                Small
                area
                (&lt;
                50 m<sup>
                  2</sup>) with dense groundcover</label>
              </div>
              <div class="position-relative form-check">
                <label class="form-check-label">
                  <input v-model="aos" type="radio" value="2" class="form-check-input" :disabled="isPreview" @change="handleOnChange('aos')" />
                Small
                area
                (&lt;
                50 m<sup>
                  2</sup>) with no groundcover</label>
              </div>
              <div class="position-relative form-check">
                <label class="form-check-label">
                  <input v-model="aos" type="radio" value="3" class="form-check-input" :disabled="isPreview" @change="handleOnChange('aos')" />
                Large
                area
                (&ge;
                50 m<sup>
                  2</sup>) with dense groundcover</label>
              </div>
              <div class="position-relative form-check">
                <label class="form-check-label">
                  <input v-model="aos" type="radio" value="4" class="form-check-input" :disabled="isPreview" @change="handleOnChange('aos')" />
                Large
                area
                (&ge;
                50 m<sup>
                  2</sup>) with no groundcover</label>
              </div>
            </fieldset>
          </div>
        </div>
      </div>
      <hr>
      <div class="form-row">
        <div class="col-md-6">
          <div class="position-relative form-group">
            <label for="">H3: Groundwater exposure
              pathway</label>
            <fieldset class="position-relative form-group">
              <div class="position-relative form-check"><label
                  class="form-check-label"><input v-model="gep"
                                                  :value="1" type="radio" class="form-check-input" :disabled="isPreview" @change="handleOnChange('gep')" />
                Yes</label>
              </div>
              <div class="position-relative form-check"><label
                  class="form-check-label"><input v-model="gep"
                                                  :value="0" type="radio" class="form-check-input" :disabled="isPreview" @change="handleOnChange('gep')" />
                No</label>
              </div>
            </fieldset>
          </div>
        </div>
        <div class="col-md-6" v-if="gep === 1">
          <div class="position-relative form-group" id="GEPChoose">
            <label for="">Human groundwater
              consumption?</label>
            <div class="row">
              <div class="col-md-4">
                <label for="">Under 6 years old</label>
              </div>
              <div class="col-md-5">
                  <div class="input-group mb-2">
                <input type="number" step="0.5" placeholder="2.0 L/day"
                       v-model="hgc"
                       class="form-control" :disabled="isPreview" @change="handleOnChange('hgc')" />
                       <div class="input-group-prepend">
                           <div class="input-group-text">L/day</div>
                       </div>
                  </div>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-4">
                <label for="">Over 6 years old</label>
              </div>
              <div class="col-md-5">
                  <div class="input-group mb-2">
                    <input type="number" step="0.5" placeholder="3.0 L/day" v-model="hgco" class="form-control" :disabled="isPreview" @change="handleOnChange('hgco')" />
                    <div class="input-group-prepend">
                        <div class="input-group-text">L/day</div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr>
      <div class="form-row">
        <div class="col-md-6">
          <div class="position-relative form-group">
            <label for="">H4: Surface water exposure
              pathway</label>
            <fieldset class="position-relative form-group">
              <div class="position-relative form-check">
                  <label class="form-check-label">
                      <input v-model="swep" :value="1" type="radio" class="form-check-input" :disabled="isPreview" @change="handleOnChange('swep')" />
                        Yes
                  </label>
              </div>
              <div class="position-relative form-check">
                  <label class="form-check-label">
                      <input v-model="swep" :value="0" type="radio" class="form-check-input" :disabled="isPreview" @change="handleOnChange('swep')" />
                    No
                  </label>
              </div>
            </fieldset>
          </div>
        </div>
        <div class="col-md-6" v-if="swep === 1">
          <div class="position-relative form-group">
            <label for="">Human surface water consumption?</label>
            <div class="row">
              <div class="col-md-4">
                <label for="">Under 6 years old</label>
              </div>
              <div class="col-md-5">
                  <div class="input-group mb-2">
                    <input type="number" step="0.5" placeholder="2.0 L/day" v-model="hswc" class="form-control" :disabled="isPreview" @change="handleOnChange('hswc')" />
                       <div class="input-group-prepend">
                           <div class="input-group-text">L/day</div>
                       </div>
                  </div>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-md-4">
                <label for="">Over 6 years old</label>
              </div>
              <div class="col-md-5">
                  <div class="input-group mb-2">
                <input type="number" step="0.5"
                       placeholder="3.0 L/day" v-model="hswco"
                       class="form-control" :disabled="isPreview" @change="handleOnChange('hswco')" />
                       <div class="input-group-prepend">
                           <div class="input-group-text">L/day</div>
                       </div>
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
  import _ from'lodash';
  import Swal from 'sweetalert2';
  import { DEFAULT_HUMAN_IMPACT } from '../../includes/constants';

  export default {
    props: {
      humanImpacts: Object,
      isPreview: Boolean,
      onChange: Function,
    },

    data() {
      return {
        wohr: this.humanImpacts.wohr,
        aos: this.humanImpacts.aos,
        gep: this.humanImpacts.gep,
        hgc: this.humanImpacts.hgc,
        hgco: this.humanImpacts.hgco,
        swep: this.humanImpacts.swep,
        hswc: this.humanImpacts.hswc,
        hswco: this.humanImpacts.hswco,
      };
    },

    watch: {
      humanImpacts: function(newHumanImpacts) {
        if (_.isEmpty(newHumanImpacts)) {
          _.keys(DEFAULT_HUMAN_IMPACT).forEach((prop) => {
            this[prop] = DEFAULT_HUMAN_IMPACT[prop];
          });
        } else {
          this.wohr = this.humanImpacts.wohr;
          this.aos = this.humanImpacts.aos;
          this.gep = this.humanImpacts.gep;
          this.hgc = this.humanImpacts.hgc;
          this.hgco = this.humanImpacts.hgco;
          this.swep = this.humanImpacts.swep;
          this.hswc = this.humanImpacts.hswc;
          this.hswco = this.humanImpacts.hswco;
        }
      },
    },

    methods: {
      helpHumanImpact() {
        Swal.fire({
          icon: 'question',
          title: 'Human impact section',
          text: 'The weighting on human impact should be between 0 and 2 (enter 1 unless you need to increase or decrease the emphasis on human impact).\n\nSelect the area / value of soil based on the description most similar to your site. Select whether or not there is a pathway for exposure of groundwater and / or surface water to chemicals.If yes, estimate the amount of water consumed by children less than or equal to 6 years old,and people older than 6 years old.',
          showCloseButton: true,
          showConfirmButton: false,
        });
      },

      handleOnChange(field) {
        // since all inputs are numbers, we can do this
        this.onChange(field, +this[field]);
      },
    },
  };
</script>
