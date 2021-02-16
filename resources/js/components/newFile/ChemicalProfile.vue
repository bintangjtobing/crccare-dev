<template>
  <div>
    <div class="main-card mb-3 card" v-if="!shouldHideForm">
      <div class="card-body">
        <div class="row">
          <div class="col-lg-6 text-left">
            <h5 class="card-title">Chemical profile</h5>
          </div>
          <div class="col-lg-6 text-right">
          <span style="font-size:1.5rem; cursor:pointer;">
            <i @click="helpChemicalProfile"
               class="pe-7s-help1 icon-gradient bg-mean-fruit">
            </i>
          </span>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-12">
            <div class="position-relative form-group">
              <label for="chemical">Chemical</label>
              <select id="chemical" v-model="newFileChemical.chemicalId" class="form-control custom-select" :disabled="isPreview">
                <option></option>
                <option v-for="chemical in availableChemicals" :key="chemical.id" :value="chemical.id">
                  {{chemical.name}} ({{chemical.formula}})
                </option>
              </select>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-md-4">
            <div class="position-relative form-group">
              <label for="concentrationSoil">Concentration in soil</label>
                <div class="input-group mb-2">
                    <input id="concentrationSoil" type="number" step="1" v-model="newFileChemical.CiS" class="form-control" placeholder="mg/kg" :disabled="isPreview" />
                    <div class="input-group-prepend">
                        <div class="input-group-text">mg/kg</div>
                    </div>
                </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="position-relative form-group">
              <label for="concentrationGroundWater">Concentration in groundwater</label>
              <div class="input-group mb-2">
                  <input id="concentrationGroundWater" type="number" step="0.0001" v-model="newFileChemical.CiG" class="form-control" placeholder="mg/L" :disabled="isPreview" />
                      <div class="input-group-prepend">
                          <div class="input-group-text">mg/L</div>
                      </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="position-relative form-group">
              <label for="concentrationSurfaceWater">Concentration in surface water</label>
              <div class="input-group mb-2">
                  <input id="concentrationSurfaceWater" type="number" step="0.0001" v-model="newFileChemical.CiSW" class="form-control" placeholder="mg/L" :disabled="isPreview" />
                  <div class="input-group-prepend">
                      <div class="input-group-text">mg/L</div>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col-lg-12">
            <button @click="addNewFileChemical" class="btn btn-success" :disabled="isPreview">Add to list</button>
          </div>
        </div>
      </div>
    </div>
    <div class="main-card mb-3 card" id="tableDataChemical">
      <div class="card-body">
        <v-data-table
            :headers="headers"
            :items="fileChemicalArray"
            :item-per-page="5"
            class="elevation-1"
        >
          <template v-slot:item.chemical="{item}">
            {{`${chemicals[item.chemicalId].name} (${chemicals[item.chemicalId].formula})`}}
          </template>

          <template v-slot:item.actions="{item}">
            <button
                @click="deleteFileChemical(item.id)"
                class="mb-2 mr-2 btn-icon btn-icon-only btn btn-outline-danger"
                :disabled="isPreview"
            >
              <i class="pe-7s-trash btn-icon-wrapper"> </i>
            </button>
          </template>
        </v-data-table>
      </div>
    </div>
  </div>
</template>

<script>
  import _ from 'lodash';
  import axios from 'axios';
  import Swal from 'sweetalert2';
  import { v4 } from 'uuid';

  export default {
    props: {
      chemicals: Object,
      fileChemicals: Object,
      shouldHideForm: Boolean,
      isPreview: Boolean,
      onCreate: Function,
      onDelete: Function,
    },

    data() {
      return {
        newFileChemical: {
          chemicalId: null,
          CiS: 0, // concentration in soil
          CiG: 0, // concentration in groundwater
          CiSW: 0, // concentration in surface water
        },
        headers: [{
          text: 'Chemical',
          value: 'chemical',
        }, {
          text: 'Concentration in soil (mg/kg)',
          value: 'CiS',
          sortable: false,
        }, {
          text: 'Concentration in groundwater (mg/L)',
          value: 'CiG',
          sortable: false,
        }, {
          text: 'Concentration in surface (mg/L)',
          value: 'CiSW',
          sortable: false,
        }, {
          text: 'Actions',
          value: 'actions',
          sortable: false,
        }],
      };
    },

    computed: {
      availableChemicals: function () {
        return _.omit(this.chemicals, _.map(this.fileChemicals, 'chemicalId'));
      },
      fileChemicalArray: function () {
        return _.values(this.fileChemicals);
      },
    },

    methods: {
      helpChemicalProfile() {
        Swal.fire({
          icon: 'question',
          title: 'Chemical profile section',
          text: 'This is where you can enter results from a laboratory-based analysis. Select a chemical from the drop-down list and add chemical concentrations (for soil, groundwater and surface water) from your laboratory-based analysis. Once ready (not all boxes need to be completed), click ‘Add to list’.',
          showCloseButton: true,
          showConfirmButton: false,
        });
      },

      async addNewFileChemical() {
        const data = {
          ...this.newFileChemical,
          id: v4(), // auto generate this id to control the edit/delete flow
          isNew: true,
          CiS: +this.newFileChemical.CiS,
          CiG: +this.newFileChemical.CiG,
          CiSW: +this.newFileChemical.CiSW,
        };

        this.newFileChemical = {
          chemicalId: null,
          CiS: 0,
          CiG: 0,
          CiSW: 0,
        };

        return this.onCreate(data);
      },

      async deleteFileChemical(id) {
        const result = await Swal.fire({
          title: 'Do you want to delete this data?',
          showCancelButton: true,
          cancelButtonColor: '#d33',
          confirmButtonText: `Delete`,
          denyButtonText: `Don't delete`,
        });

        if (result.isConfirmed) {
          return this.onDelete(id);
        }
      }
    },
  };
</script>
