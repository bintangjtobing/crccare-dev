<template>
  <div class="main-card mb-3 card">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-6 text-left">
          <h5 class="card-title">Create Filename</h5>
        </div>
        <div class="col-lg-6 text-right">
          <span style="font-size:1.5rem; cursor:pointer;">
              <i @click="helpCreateFileName"
                 class="pe-7s-help1 icon-gradient bg-mean-fruit">
              </i>
          </span>
        </div>
      </div>
      <div class="form-row">
        <div class="col-md-6">
          <div class="position-relative form-group">
            <label for="filename">Filename</label>
            <input
                id="filename"
                placeholder="Filename here"
                v-model="name"
                type="text"
                class="form-control"
                :class="errors.name ? 'border-danger':''"
                :disabled="isPreview"
                @blur="handleOnChange('name')"
            >
            <span class="text-danger" v-if="errors.name">{{ errors.name }}</span>
          </div>
        </div>
        <div class="col-md-6">
          <div class="position-relative form-group">
            <label for="file-description">Description</label>
            <textarea
                id="file-description"
                class="form-control"
                v-model="desc"
                cols="30"
                rows="10"
                placeholder="Description here..."
                :disabled="isPreview"
                @blur="handleOnChange('desc')"></textarea>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Swal from 'sweetalert2';

  export default {
    props: {
      isPreview: Boolean,
      data: Object,                 // { name, desc }
      errors: Object,
      onChange: Function,
    },

    data() {
      return {
        name: this.data.name,
        desc: this.data.desc,
      };
    },
    watch: {
      data: function(newData) {
        this.name = newData.name;
        this.desc = newData.desc;
      },
    },

    methods: {
      helpCreateFileName: () =>
        Swal.fire({
          icon: 'question',
          title: 'Create filename section',
          text: 'Enter the filename, description of the data and, if available, add relevant reports or documentation about the data to the upload area (you can upload multiple documents on section below).',
          showCloseButton: true,
          showConfirmButton: false,
        }),

      handleOnChange(field) {
        this.onChange(field, this[field]);
      },
    },

  }
</script>
