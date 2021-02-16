<template>
  <div>
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div class="page-title-icon">
            <i class="pe-7s-drop icon-gradient bg-mean-fruit">
            </i>
          </div>
          <div>Edit Chemical Data
            <div class="page-title-subheading">
              Update chemical list data.
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 my-3">
        <form @submit.prevent="handleSubmit">
          <div class="form-row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="chemical-name">Chemical name</label>
                <input id="chemical-name" type="text" required v-model="chemical.name" class="form-control" />
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="chemical-formula">Chemical formula</label>
                <input id="chemical-formula" type="text" required v-model="chemical.formula" class="form-control" />
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="chemical-oral-slope-factor">Oral slope factor (r)</label>
                <input id="chemical-oral-slope-factor" type="number" required step="0.00001" v-model="chemical.oralR" class="form-control" />
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="chemical-rfd">Oral reference dose (RfD)</label>
                <input id="chemical-rfd" type="number" required step="0.00001" v-model="chemical.oralS" class="form-control" />
              </div>
            </div>
          </div>

          <button type="submit" class="btn btn-success">Update Data</button>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
  import Swal from 'sweetalert2';

  export default {
    title() {
      return this.$route.params.id ? 'Edit chemical data' : 'Add new chemical data';
    },
    data() {
      return {
        chemical: {
          name: '',
          formula: '',
          oralR: '',
          oralS: '',
        },
      };
    },
    created() {
      this.loadDataChemical();
    },
    methods: {
      async handleSubmit() {
        if (this.$route.params.id) {
          await axios.patch(`/api/chemicals/${this.$route.params.id}`, this.chemical);
          await Swal.fire({
            icon: 'success',
            title: 'Congratulations',
            text: 'Success update chemical data'
          });
        } else {
          await axios.post('/api/chemicals', this.chemical);
          await Swal.fire({
            icon: 'success',
            title: 'Congratulations',
            text: 'Success add new chemical data'
          });
        }
        this.$router.push('/chemicals');
      },

      async loadDataChemical() {
        if (this.$route.params.id) {
          const { data } = await axios.get(`/api/chemicals/${this.$route.params.id}`);
          this.chemical = data;
        }
      },
    },
  }
</script>
