<template>
  <div>
    <div class="app-page-title">
      <div class="page-title-wrapper">
        <div class="page-title-heading">
          <div class="page-title-icon">
            <i class="pe-7s-user icon-gradient bg-mean-fruit">
            </i>
          </div>
          <div>{{ isNewUser ? 'New User' : 'Update User' }}
            <div class="page-title-subheading">
              {{ isNewUser ? 'Add new user data.' : 'Update user data.' }}
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 my-3">
        <form @submit.prevent="handleSubmit">
          <div class="form-row">
            <div class="col-md-9">
              <div class="form-group">
                <label for="user-name">Full name</label>
                <input id="user-name" type="text" required v-model="user.name" class="form-control" />
                <p class="text-danger error-password"> {{ errors.name }}</p>
              </div>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="user-status">Status</label>
                <select id="user-status" class="form-control" v-model="user.status">
                  <option v-bind:value="1">Active</option>
                  <option v-bind:value="0">Inactive</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="user-org">Organisation</label>
                <input id="user-org" type="text" required v-model="user.organisation" class="form-control" />
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="user-email">Email</label>
                <input id="user-email" type="email" required v-model="user.email" class="form-control" />
                <p class="text-danger error-password"> {{ errors.email }}</p>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="user-phone">Phone</label>
                <input id="user-phone" type="number" required v-model="user.phone" class="form-control" />
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="user-password">Password</label>
                  <input
                      id="user-password"
                      :required="isNewUser"
                      type="password"
                      v-model="user.password"
                      class="form-control"
                      @blur="validatePassword"
                  />
                  <p class="text-danger error-password"> {{ errors.password }}</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="user-confirm-password">Verify Password</label>
                  <input
                      id="user-confirm-password"
                      :required="isNewUser"
                      type="password"
                      v-model="user.confirmPassword"
                      @blur="validatePassword"
                      class="form-control"
                  />
                  <p class="text-danger error-confirm-password">{{ errors.confirmPassword }}</p>
                </div>
              </div>
            </div>

            <div class="col-md-12">
              <button type="submit" class="btn btn-success">
                {{ isNewUser ? 'Save' : 'Update data' }}
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
  import _ from 'lodash';
  import axios from 'axios';
  import Swal from 'sweetalert2';

  export default {
    title() {
      return this.isNewUser ? 'New user data' : 'Edit user data';
    },
    data() {
      return {
        isNewUser: _.isNil(this.$route.params.id),
        originalUser: {},
        user: {},
        errors: {
          name: '',
          email: '',
          password: '',
          confirmPassword: '',
        },
      }
    },

    created() {
      if (!this.isNewUser) this.loadDataUser();
    },
    methods: {
      async loadDataUser() {
        const { data } = await axios.get(`/api/users/${this.$route.params.id}`);
        this.originalUser = data;
        this.user = _.cloneDeep(data);
      },

      validatePassword() {
        const { password, confirmPassword } = this.user;

        if (!_.isEmpty(password)) {
          if (password.length < 8) {
            this.errors = {
              ...this.errors,
              password: 'Min have 8 characters or more.',
            };
            return false;
          }
          if (_.isNil(confirmPassword) || confirmPassword.length < 8) {
            this.errors = {
              ...this.errors,
              confirmPassword: 'Min have 8 characters or more.',
            };
            return false;
          }

          if (password !== confirmPassword) {
            this.errors = {
              ...this.errors,
              confirmPassword: 'Password does not match!',
            };
            return false;
          }

          this.errors = {
            ...this.errors,
            password: '',
            confirmPassword: '',
          };
        }

        return true;
      },

      async validateData() {
        const isPasswordValid = this.validatePassword();
        if (!isPasswordValid) return false;

        const { data } = await axios.post('/api/users/check-user-data', this.user);
        if (data.existingEmail) {
          this.errors = {
            ...this.errors,
            email: 'Email already exists!',
          };
        } else {
          this.errors = { ...this.errors, email: '' };
        }
        if (data.existingName) {
          this.errors = {
            ...this.errors,
            name: 'Name already exists!',
          };
        } else {
          this.errors = { ...this.errors, name: '' };
        }

        return !data.existingEmail && !data.existingName;
      },

      async handleSubmit(event) {
        event.preventDefault();

        const isValid = await this.validateData();
        if (!isValid) return false;

        const payload = {};
        _.forEach(['name', 'status', 'organisation', 'email', 'phone'], (field) => {
          if (this.user[field] !== this.originalUser[field]) {
            payload[field] = this.user[field];
          }
        });
        if (!_.isEmpty(this.user.password)) {
          payload.password = this.user.password;
        }

        if (this.isNewUser) {
          await axios.post('/api/users', payload);
          Swal.fire({
            icon: 'success',
            title: 'Congratulations',
            text: 'Success add new user',
          });
        } else {
          await axios.patch(`/api/users/${this.$route.params.id}`, payload);
          await Swal.fire({
            icon: 'success',
            title: 'Congratulations',
            text: 'Success update user data',
          });
        }
      },
    }
  }

</script>
