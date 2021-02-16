<template>
  <div>
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div class="page-title-icon">
            <i class="pe-7s-note icon-gradient bg-mean-fruit">
            </i>
          </div>
          <div>Create new file
            <div class="page-title-subheading">
              Create your new chemical data.
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
      <div class="row sticky-top" style="top: 55px;">
        <div class="col-lg-12 col-md-12">
          <progress-bar
              :progressValues="progressBarValues"
              :onChange="progressBarClickHandler"
          />
        </div>
      </div>
      <div class="row file-form" ref="file-form-container">
        <div class="col-lg-12 col-md-12">
          <div class="alert alert-danger alert-dismissible fade show" role="alert" v-if="error.length">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span class="text-danger" aria-hidden="true">&times;</span>
            </button>
            <span class="text-danger">
                            <b>Please correct the errors:</b>
                            <ul>
                                <li v-for="e in error" v-bind:key="e.id">
                                    {{e}}
                                </li>
                            </ul>
                        </span>
          </div>
          <div id="fileNameSection">
            <file-name
                :data="filename"
                :errors="fileErrors"
                :isPreview="isPreview"
                :onChange="handleFileNameChange"
            />

            <div id="chemicalProfileSection">
              <chemical-profile
                  v-if="!isLoading"
                  :chemicals="chemicals"
                  :fileChemicals="fileChemicals"
                  :isPreview="isPreview"
                  :onCreate="patchFileChemical"
                  :onDelete="removeFileChemical"
              />
            </div>

            <div id="humanSection">
              <human-impact
                  :humanImpacts="humanimpacts"
                  :isPreview="isPreview"
                  :onChange="handleHumanImpactChange"
              />
            </div>

            <div id="ecologicalImpactSection">
              <ecological-impact
                  :ecologicalImpacts="ecologicalimpacts"
                  :isPreview="isPreview"
                  :onChange="handleEcologicalImpactChange"
              />
            </div>

            <div id="groundwaterImpactSection">
              <ground-water-impact
                  :groundWaterImpacts="groundwaterimpacts"
                  :isPreview="isPreview"
                  :onChange="handleGroundWaterImpactChange"
              />
            </div>

            <div class="main-card mb-3 card" id="uploadDocument">
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-12 col-md-12">
                    <div class="main-card mb-3 card">
                      <div class="card-body">
                        <div class="position-relative form-group">
                          <label for="dropzone">Upload your documents here:
                          </label>
                        </div>
                        <vue-dropzone
                            useCustomSlot
                            ref="document-upload"
                            id="dropzone"
                            :options="dropzoneOptions"
                            class="dropzone"
                            v-on:vdropzone-success="handleFileUploadCompleted"
                            v-on:vdropzone-queue-complete="handleFileUploaded"
                            v-on:vdropzone-removed-file="handleFileRemoved"
                        >
                          <div class="dropzone-custom-content">
                            <h3 class="dropzone-custom-title">Drag and drop to upload
                              content!</h3>
                            <div class="subtitle">...or click to select a file from your
                              computer</div>
                          </div>
                        </vue-dropzone>
                      </div>
                    </div>
                    <div class="clearfix">
                      <button
                          v-if="!isPreview"
                          @click="resetForms"
                          type="button"
                          class="btn-shadow float-left btn btn-link"
                      >
                        Reset
                      </button>

                      <button
                          v-if="isPreview"
                          @click="setIsPreview(false)"
                          type="button"
                          class="btn-shadow float-left btn btn-link"
                      >
                        Edit
                      </button>

                      <button
                          id="nextButton"
                          class="btn-shadow btn-wide float-right btn-pill btn-hover-shine btn btn-success"
                          v-if="!isPreview"
                          @click="goToPreview"
                      >
                        Next Step
                      </button>
                      <button
                          @click="processNewData"
                          id="submitButton"
                          type="submit"
                          class="btn-shadow btn-wide float-right btn-pill btn-hover-shine btn btn-success"
                          v-if="isPreview"
                          :disabled="isUploading"
                      >
                        {{ isUploading ? 'Uploading Files...' : 'Submit data' }}
                      </button>
                    </div>
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
  import _ from 'lodash';
  import axios from 'axios';
  import Swal from 'sweetalert2';
  import vue2Dropzone from 'vue2-dropzone';
  import progressBar from './progressBar.vue';
  import { calculateData } from '../includes/Calculation';
  import FileName from './newFile/FileName.vue';
  import ChemicalProfile from './newFile/ChemicalProfile';
  import HumanImpact from './newFile/HumanImpact';
  import EcologicalImpact from './newFile/EcologicalImpact';
  import GroundWaterImpact from './newFile/GroundWaterImpact';
  import { DEFAULT_ECOLOGICAL_IMPACT, DEFAULT_GROUND_WATER_IMPACT, DEFAULT_HUMAN_IMPACT } from '../includes/constants';

  export default {
    title() {
      return 'Add new file data';
    },
    components: {
      vueDropzone: vue2Dropzone,
      progressBar: progressBar,
      FileName,
      ChemicalProfile,
      HumanImpact,
      EcologicalImpact,
      GroundWaterImpact,
    },
    data() {
      return {
        hide: false,
        isPreview: false,
        score: {},
        chemicals: {},
        fileChemicals: {},
        error: [],
        isLoading: true,
        isSubmitClicked: false,

        // TODO: callback to save the ids of the uploaded file
        dropzoneOptions: {
          url: '/api/documents',
          thumbnailWidth: 400,
          addRemoveLinks: true,
          headers: {
            'x-csrf-token': document.querySelectorAll('meta[name=csrf-token]')[0].getAttributeNode(
              'content').value,
          },
          autoDiscover: false,
          parallelUploads: 10,
          autoProcessQueue: false,
          dictRemoveFile: 'REMOVE'
        },
        currentProgressId: 'filename',
        csrf: document.head.querySelector('meta[name="csrf-token"]').content,
        fileErrors: {},
        filename: {},
        humanimpacts: _.cloneDeep(DEFAULT_HUMAN_IMPACT),
        ecologicalimpacts: _.cloneDeep(DEFAULT_ECOLOGICAL_IMPACT),
        groundwaterimpacts: _.cloneDeep(DEFAULT_GROUND_WATER_IMPACT),

        // file upload properties
        isUploading: false,
        documents: {},
      }
    },

    computed: {
      /**
       * return the data needed for progress bar to style each item
       */
      progressBarValues() {
        const completedIds = [];
        if (this.filename.name && this.filename.desc) {
          completedIds.push('filename');
        }
        if (!_.isEmpty(_.keys(this.fileChemicals))) {
          completedIds.push('chemical');
        }

        const humanImpactConditions = [
          this.humanimpacts.wohr === 0,
          _.isNil(this.humanimpacts.gep),
          _.isNil(this.humanimpacts.swep),
        ];
        if (_.compact(humanImpactConditions).length === 0) {
          completedIds.push('human');
        }

        const ecologicalImpactConditions = [
          this.ecologicalimpacts.woar === 0,
          _.isEmpty(this.ecologicalimpacts.erosion),
          this.ecologicalimpacts.erosion === 'observation'
            ? _.isNil(this.ecologicalimpacts.erosionval)
            : _.isNil(this.ecologicalimpacts.erosionvals),
          this.ecologicalimpacts.rgrae === 0,
          this.ecologicalimpacts.rgrte === 0,
        ];
        if (_.compact(ecologicalImpactConditions).length === 0) {
          completedIds.push('ecology');
        }

        const groundWaterConditions = [
          _.isNil(this.groundwaterimpacts.loc),
          _.isNil(this.groundwaterimpacts.splp),
          _.isNil(this.groundwaterimpacts.dttg),
          _.isNil(this.groundwaterimpacts.oial),
          _.isNil(this.groundwaterimpacts.ndgb),
          _.isNil(this.groundwaterimpacts.aoic),
        ];
        if (_.compact(groundWaterConditions).length === 0) {
          completedIds.push('groundwater');
        }

        const errorIds = [];
        if (this.isSubmitClicked) {
          if (!_.isEmpty(this.validateFilename())) {
            errorIds.push('filename');
          }

          if (!_.isEmpty(this.validateChemical())) {
            errorIds.push('chemical');
          }

          if (!_.isEmpty(this.validateHumanImpact())) {
            errorIds.push('human');
          }

          if (!_.isEmpty(this.validateEcologicalImpact())) {
            errorIds.push('ecology');
          }

          if (!_.isEmpty(this.validateGroundWaterImpact())) {
            errorIds.push('groundwater');
          }
        }

        return {
          completedIds,
          currentId: this.currentProgressId,
          errorIds,
        };
      },
    },

    async beforeMount() {
      await this.getChemicals();

      // check if we're editing a file
      if (this.$route.params.id) {
        await this.getFile(this.$route.params.id);
      }

      this.isLoading = false;
    },
    methods: {
      handleScroll(e) {
        const chemicalProfileSection = document.getElementById('chemicalProfileSection');
        const humanSection = document.getElementById('humanSection');
        const ecologicalImpactSection = document.getElementById('ecologicalImpactSection');
        const groundwaterImpactSection = document.getElementById('groundwaterImpactSection');
        const formContainer = this.$refs['file-form-container'];

        // start from the bottom and check, save time checking position unnecessary
        switch (true) {
          case formContainer.scrollTop === (formContainer.scrollHeight - formContainer.offsetHeight):
            this.currentProgressId = 'finish';
            break;
          case formContainer.scrollTop >= groundwaterImpactSection.offsetTop:
            this.currentProgressId = 'groundwater';
            break;
          case formContainer.scrollTop >= ecologicalImpactSection.offsetTop:
            this.currentProgressId = 'ecology';
            break;
          case formContainer.scrollTop >= humanSection.offsetTop:
            this.currentProgressId = 'human';
            break;
          case formContainer.scrollTop >= chemicalProfileSection.offsetTop:
            this.currentProgressId = 'chemical';
            break;
          default:
            this.currentProgressId = 'filename';
        }
      },

      async handleFileNameChange(field, value) {
        // check if file name is unique
        if (field === 'name') {
          const { data } = await axios.post('/api/files/check-file-data', { name: value, id: _.get(this.score, 'score.id') });
          if (data.existingName) {
            this.fileErrors = {
              name: 'Duplicate file name.',
            };
            return;
          } else {
            this.fileErrors = {};
          }
        }
        this.filename[field] = value;
      },

      handleHumanImpactChange(field, value) {
        this.humanimpacts[field] = value;
      },

      handleEcologicalImpactChange(field, value) {
        this.ecologicalimpacts[field] = value;
      },

      handleGroundWaterImpactChange(field, value) {
        this.groundwaterimpacts[field] = value;
      },

      /**
       * update the local data
       *
       * @param {Object} newFileChemical
       */
      patchFileChemical(newFileChemical) {
        this.fileChemicals = { ...this.fileChemicals, [newFileChemical.id]: newFileChemical };
      },

      /**
       * update the local data
       *
       * @param {number} id
       */
      removeFileChemical(id) {
        this.fileChemicals = _.omit(this.fileChemicals, [id]);
      },

      async getChemicals() {
        const { data } = await axios.get('/api/chemicals');
        this.chemicals = _.keyBy(data, 'id');
      },

      async getFile(id) {
        const { data } = await axios.get(`/api/score-results/${id}`);
        this.score = data;
        this.fileChemicals = _.keyBy(data.score.chemicals, 'id');
        this.filename = {
          name: data.score.filename,
          desc: data.score.description,
        };

        this.humanimpacts = {
          wohr: data.score.weightOnHumanRisk,
          aos: data.score.areaOfSoil,
          gep: data.score.groundWaterExposure,
          hgc: data.score.groundWaterConsumptionChild,
          hgco: data.score.groundWaterConsumptionAdult,
          swep: data.score.surfaceWaterExposure,
          hswc: data.score.surfaceWaterConsumptionChild,
          hswco: data.score.surfaceWaterConsumptionAdult,
        };

        this.ecologicalimpacts = {
          woar: data.score.aquaticRisk,
          erosion: data.score.erosionType,
          erosionval: data.score.erosionValueObservation,
          erosionvals: data.score.erosionValueRUSLE,
          rgrae: data.score.growthRateAquatic,
          rgrte: data.score.growthRateTerrestrial,
        };

        this.groundwaterimpacts = {
          loc: data.score.levelOfContaminant,
          splp: data.score.splp,
          dttg: data.score.groundWaterDepth,
          oial: data.score.offsiteImpact,
          ndgb: data.score.nearestBorehole,
          aoic: data.score.institutionControl,
        };

        // files
        this.documents = _.keyBy(data.score.documents, 'id');
        _.forEach(this.documents, (doc) => {
          this.$refs['document-upload'].manuallyAddFile({ id: doc.id, name: doc.file }, `/api/documents/${doc.id}`);
        });
      },

      validateFilename() {
        const errors = [];

        if (!this.filename.name) {
          errors.push('Name is required.');
        }

        if (this.fileErrors.name) {
          errors.push(this.fileErrors.name);
        }
        if (!this.filename.desc) {
          errors.push('Description is required.');
        }

        return errors;
      },

      validateChemical() {
        if (_.isEmpty(_.keys(this.fileChemicals))) {
          return ['Empty chemicals.'];
        }
        return [];
      },

      validateHumanImpact() {
        const errors = [];
        if (!this.humanimpacts.wohr) {
          errors.push('Human Impact: Weight on Human risk is required');
        }
        if (this.humanimpacts.aos === 0) {
          errors.push('Human Impact: Area of soil is required');
        }
        if (_.isNil(this.humanimpacts.gep)) {
          errors.push('Human Impact: Groundwater exposure pathway is required');
        }
        if (_.isNil(this.humanimpacts.swep)) {
          errors.push('Human Impact: Surface water exposure pathway is required');
        }
        return errors;
      },

      validateEcologicalImpact() {
        const errors = [];
        if (!this.ecologicalimpacts.woar) {
          errors.push("Ecological impacts: weight on aquatic risk data is required.");
        }
        if (!this.ecologicalimpacts.erosion) {
          errors.push(
            "Ecological impacts: observation or RUSLE model is not selected. Please choose between one of them."
          );
        }
        if (!this.ecologicalimpacts.rgrae) {
          errors.push(
            "Ecological impacts: relative growth rate (aquatic environment) is required.");
        }
        if (!this.ecologicalimpacts.rgrte) {
          errors.push(
            "Ecological impacts: relative growth rate (terrestrial environment) is required."
          );
        }
        return errors;
      },

      validateGroundWaterImpact() {
        const errors = [];
        if (_.isNil(this.groundwaterimpacts.loc)) {
          errors.push(
            "Groundwater impacts: levels of contaminants is not selected. Please choose one of them."
          );
        }
        if (_.isNil(this.groundwaterimpacts.splp)) {
          errors.push(
            "Groundwater impacts: precipitation leaching procedure SPLP values is not selected "
          );
        }
        if (!this.groundwaterimpacts.dttg) {
          errors.push("Groundwater impacts: depth to the groundwater is not selected.");
        }
        if (!this.groundwaterimpacts.oial) {
          errors.push(
            "Groundwater impacts: off-site impact and liability issues is not selected.");
        }
        if (!this.groundwaterimpacts.ndgb) {
          errors.push(
            "Groundwater impacts: nearest drinking groundwater borehole is not selected.");
        }
        if (!this.groundwaterimpacts.aoic) {
          errors.push(
            "Groundwater impacts: applicability of institution control is not selected.");
        }
        return errors;
      },

      validationFields() {
        return [
          ...this.validateFilename(),
          ...this.validateChemical(),
          ...this.validateHumanImpact(),
          ...this.validateEcologicalImpact(),
          ...this.validateGroundWaterImpact(),
        ];
      },

      goToPreview(event) {
        event.preventDefault();

        this.isSubmitClicked = true;

        // validate data
        this.error = this.validationFields();
        if (this.error.length === 0) {
          this.setIsPreview(true);
        }
        window.scrollTo(0, 0);
      },

      setIsPreview(value) {
        this.isPreview = Boolean(value);
      },

      calculateScore() {
        return calculateData({
          fileChemicals: this.fileChemicals,
          chemicals: this.chemicals,
          humanImpacts: this.humanimpacts,
          ecologicalImpacts: this.ecologicalimpacts,
          groundWaterImpacts: this.groundwaterimpacts,
        });
      },

      async processNewData() {
        const score = this.calculateScore();

        const result = await Swal.fire({
          title: 'Check your result data',
          showCancelButton: true,
          cancelButtonColor: '#d33',
          confirmButtonText: `Submit`,
          text: `Score Children: ${score.child.toFixed(1)}, Score Adult: ${score.adult.toFixed(1)}`,
        });
        if (result.isConfirmed) {
          // upload files
          if (!_.isEmpty(this.$refs['document-upload'].getAcceptedFiles())) {
            this.isUploading = true;
            this.$refs['document-upload'].processQueue();

            // wait for all files uploaded
            await new Promise(function(resolve) {
              const interval = setInterval(function () {
                if (!this.isUploading) {
                  clearTimeout(interval);
                  resolve();
                }
              }.bind(this), 100);
            }.bind(this));
          }

          // save all user input data and the score
          const data = {
            score,
            filename: this.filename,
            fileChemicals: _.map(this.fileChemicals, (chemical) => chemical.isNew ? _.omit(chemical, ['id']) : chemical),
            documentIds: _.keys(this.documents),
            weightOnHumanRisk: this.humanimpacts.wohr,
            areaOfSoil: this.humanimpacts.aos,
            groundWaterExposure: this.humanimpacts.gep,
            groundWaterConsumption: {
              child: this.humanimpacts.hgc,
              adult: this.humanimpacts.hgco,
            },
            surfaceWaterExposure: this.humanimpacts.swep,
            surfaceWaterConsumption: {
              child: this.humanimpacts.hswc,
              adult: this.humanimpacts.hswco,
            },
            aquaticRisk: this.ecologicalimpacts.woar,
            erosionType: this.ecologicalimpacts.erosion,
            erosionValue: {
              observation: this.ecologicalimpacts.erosionval,
              rusle: this.ecologicalimpacts.erosionvals,
            },
            growthRateAquatic: this.ecologicalimpacts.rgrae,
            growthRateTerrestrial: this.ecologicalimpacts.rgrte,
            groundWaterImpact: {
              levelOfContaminant: this.groundwaterimpacts.loc,
              splp: this.groundwaterimpacts.splp,
              groundWaterDepth: this.groundwaterimpacts.dttg,
              offsiteImpact: this.groundwaterimpacts.oial,
              nearestBorehole: this.groundwaterimpacts.ndgb,
              institutionControl: this.groundwaterimpacts.aoic,
            },
          };

          let response;
          if (this.$route.params.id) {
            response = await axios.patch(`/api/score-results/${this.$route.params.id}`, data);
          } else {
            response = await axios.post('/api/files', data);
          }
          this.$router.push(`/view-data-results/${response.data.id}`);
        }
      },

      async resetForms() {
        this.filename = {};
        this.fileChemicals = {};
        this.humanimpacts = {};
        this.ecologicalimpacts = {};
        this.groundwaterimpacts = {};
        this.documents = {};
        this.$refs['document-upload'].removeAllFiles();
        window.scrollTo(0, 0);
        Swal.fire({
          icon: 'success',
          title: 'Congratulations',
          text: 'Success reset all data form.',
        });
      },

      handleFileUploaded() {
        this.isUploading = false;
      },

      handleFileUploadCompleted(file, response) {
        this.documents[response.id] = response;
      },

      handleFileRemoved(file) {
        // delete if previously uploaded file
        if (file.id) {
          delete this.documents[file.id];
        }
      },
      progressBarClickHandler(sectionId) {
        let elementId;
        switch (sectionId) {
          case 'filename':
            elementId = 'fileNameSection';
            break;
          case 'chemical':
            elementId = 'chemicalProfileSection';
            break;
          case 'human':
            elementId = 'humanSection';
            break;
          case 'ecology':
            elementId = 'ecologicalImpactSection';
            break;
          case 'groundwater':
            elementId = 'groundwaterImpactSection';
            break;
          case 'finish':
          default:
            elementId = 'uploadDocument';
            break;
        }
        const element = document.getElementById(elementId);
        element.scrollIntoView();
      },
    },
    mounted() {
      this.$refs['file-form-container'].addEventListener('scroll', this.handleScroll);
    },
    beforeUnmount() {
      this.$refs['file-form-container'].removeEventListener('scroll', this.handleScroll);
    },
  }

</script>
<style scoped lang="scss">
  .file-form {
    height: 70vh;
    overflow-y: scroll;
  }

  .btn-success {
    color: #fff;
  }

  .dropzone .dz-preview .dz-image {
    width: 120px;
    height: 120px;
  }

  .vue-dropzone>.dz-preview .dz-remove {
    color: rgba(33, 150, 243, .8);
    margin-left: 25px;
    bottom: 42px;
    border: none;
    z-index: inherit;
    font-size: 10px;
  }


  .dropzone .dz-preview .dz-details .dz-size span {
    padding: 0 1.5em;
    font-size: 14px;
  }

  .dropzone .dz-preview .dz-details .dz-filename span {
    font-size: 13px;
    margin-left: .50rem
  }

  .dropzone .dz-preview .dz-details .dz-filename {
    margin-top: 45px;
  }

  .dropzone .dz-preview {
    border-radius: 1rem;
  }

  .vue-dropzone>.dz-preview .dz-image,
  .vue-dropzone>.dz-preview .dz-details {
    border-radius: 1rem;
  }

  .hide {
    display: none;
  }

</style>
