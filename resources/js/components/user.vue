<template>
    <div>
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-users icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>User management
                        <div class="page-title-subheading">
                            Manage your team and check status of users.
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
                                    User Management
                                </div>
                                <div class="col-md-6 text-right">
                                    <router-link to="/new/user" class="btn btn-success">Add User
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <v-data-table :headers="headers" :items="members" :item-per-page="5" class="elevation-1">
                            <template v-slot:item.status="{ item }">
                                <span>{{ (item.status == 0 ? 'Inactive' : 'Active') }}</span>
                            </template>
                            <template v-slot:item.actions="{item}">
                                <router-link :to="`/update/user/${item.id}`"
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
    import Swal from 'sweetalert2';

    export default {
        title() {
            return 'User management';
        },
        data() {
            return {
                members: [],
                headers: [{
                    text: 'Name',
                    value: 'name'
                }, {
                    text: 'Email',
                    value: 'email'
                }, {
                    text: 'Role',
                    value: 'role'
                }, {
                    text: 'Status',
                    value: 'status'
                }, {
                    text: 'Actions',
                    value: 'actions',
                    sortable: false
                }],
            };
        },
        mounted() {
            this.loadUser();
        },
        methods: {
            loadUser() {
                axios.get("api/users")
                    .then(response => {
                        this.members = response.data;
                    })
            },
            async deleteData(id) {
                const result = await Swal.fire({
                    title: 'Delete user?',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonText: `Delete`,
                });
                if (result.isConfirmed) {
                    await axios.delete('api/users/' + id);
                    await Swal.fire({
                        icon: 'success',
                        title: 'Successfully Deleted',
                        text: 'Success deleted current user'
                    });
                    this.loadUser();
                }
            }
        }
    }

</script>
<style>
    .card-header-title {
        width: 100%;
    }

</style>
