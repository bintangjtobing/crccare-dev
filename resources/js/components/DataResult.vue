<template>
  <div>
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div class="page-title-icon">
            <i class="pe-7s-folder icon-gradient bg-mean-fruit">
            </i>
          </div>
          <div>Results
            <div class="page-title-subheading">
              See all data inserted in this app.
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
              Previous Results
            </div>
          </div>
          <div class="card-body">
            <v-data-table :headers="headers" :items="scores" :items-per-page="10" class="elevation-1">
              <template v-slot:item.actions="{ item }">
                <router-link :to="`/view-data-results/${item.id}`"
                  class="mb-2 mr-2 btn-icon btn-icon-only btn btn-outline-primary"><i
                    class="pe-7s-look btn-icon-wrapper"> </i></router-link>
                <button v-on:click="deleteData(item.id)"
                  class="mb-2 mr-2 btn-icon btn-icon-only btn btn-outline-danger"><i
                    class="pe-7s-trash btn-icon-wrapper"> </i></button>
              </template>

              <template v-slot:item.scoreChildren="{ item }">
                {{ item.scoreChildren.toFixed(1) }}
              </template>

              <template v-slot:item.scoreAdult="{ item }">
                {{ item.scoreAdult.toFixed(1) }}
              </template>
            </v-data-table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Swal from 'sweetalert2';

  export default {
    title() {
      return 'Results';
    },
    data() {
      return {
        scores: [],
        headers: [{
          text: 'Username',
          value: 'user.name'
        }, {
          text: 'Filename',
          value: 'score.filename'
        }, {
          text: 'Children',
          value: 'scoreChildren'
        }, {
          text: 'Adult',
          value: 'scoreAdult'
        }, {
          text: 'Date submitted',
          value: 'created_at'
        }, {
          text: 'Actions',
          value: 'actions',
          sortable: false,
        }],
      }
    },
    created() {
      this.getScoreResults();
    },
    methods: {
      async getScoreResults() {
        const { data } = await axios.get('/api/scores');
        this.scores = data;
      },

      async viewResultDetail(id) {
        let getViewData = await axios.get('/view-data/' + id);
        this.$router.push({
          path: '/view-data-results',
          query: {
            getViewData
          },
        });
      },
      async deleteData(id) {
        const result = await Swal.fire({
          icon: 'warning',
          title: 'Delete this data?',
          text: 'All of this related data will be deleted permanently.',
          showCancelButton: true,
          cancelButtonColor: '#d33',
          confirmButtonText: `Delete`,
        });
        if (result.isConfirmed) {
          await axios.delete('/delete-data-result/' + id);
          await Swal.fire({
            icon: 'success',
            title: 'Successfully Deleted',
            text: 'Success deleted current data'
          });
          this.getScoreResults();
        }
      }
    }
  }

</script>
