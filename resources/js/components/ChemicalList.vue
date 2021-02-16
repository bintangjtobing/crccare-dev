<template>
  <div>
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div class="page-title-icon">
            <i class="pe-7s-drop icon-gradient bg-mean-fruit">
            </i>
          </div>
          <div>Chemical data list
            <div class="page-title-subheading">
              See a list of relevant chemical data.
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
              <div class="row">
                <div class="col-md-6 text-left">
                  Chemical Data Profile
                </div>
                <div class="col-md-6 text-right">
                  <router-link
                      v-if="isAdmin"
                      to="/new/chemical-data-lists"
                      class="btn btn-success"
                  >
                    Add Chemical List
                  </router-link>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <v-data-table :headers="headers" :items="chemicals" :items-per-page="10" class="elevation-1">
              <template v-slot:item.actions="{ item }">
                <router-link :to="`/update/chemical/${item.id}`"
                             class="mb-2 mr-2 btn-icon btn-icon-only btn btn-outline-success"><i
                    class="pe-7s-pen btn-icon-wrapper"> </i></router-link>
                <button v-on:click="deleteData(item.id)"
                        class="mb-2 mr-2 btn-icon btn-icon-only btn btn-outline-danger"><i
                    class="pe-7s-trash btn-icon-wrapper"> </i></button>
              </template>
            </v-data-table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import _ from 'lodash';
  import Swal from 'sweetalert2';

  export default {
    title() {
      return 'Chemical data';
    },
    data() {
      return {
        chemicals: [],
        isAdmin: false,
        headers: [{
          text: 'Chemical name',
          value: 'name'
        },
          {
            text: 'Chemical formula',
            value: 'formula'
          },
          {
            text: 'Oral slope factor (r)',
            value: 'oralR'
          },
          {
            text: 'Oral reference dose (RfD)',
            value: 'oralS'
          },
          {
            text: 'Actions',
            value: 'actions',
            sortable: false,
          },
        ],
      };
    },
    mounted() {
      this.getChemicals();
    },
    created() {
      this.getUserRole();
    },
    methods: {
      async getUserRole() {
        const { data: user } = await axios.get('/api/current-user');
        if (user.role === 'admin') {
          this.isAdmin = true;
        } else {
          this.headers = _.reject(this.headers, { value: 'actions' });
        }
      },
      async getChemicals() {
        const { data } = await axios.get('/api/chemicals');
        this.chemicals = data;
      },
      async deleteData(id) {
        const result = await Swal.fire({
          title: 'Do you want to delete the data?',
          showCancelButton: true,
          cancelButtonColor: '#d33',
          confirmButtonText: `Delete`,
        });
        if (result.isConfirmed) {
          await axios.delete(`api/chemicals/${id}`);
          await Swal.fire({
            icon: 'success',
            title: 'Successfully Deleted',
            text: 'Success deleted current chemical',
          });
          this.getChemicals();
        }
      }
    },
  }

</script>
