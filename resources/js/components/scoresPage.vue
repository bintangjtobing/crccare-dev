y<template>
    <div>
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-rocket icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Summary Result
                        <div class="page-title-subheading">
                            See your summary and submit it when you're ready
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="main-card mb-3 card">
                        <div class="card-body">
                            <h5 class="card-title">Check your file</h5>
                            <table class="table">
                                <thead>
                                    <tr style="background-color:#3ac47d; color:#fff;">
                                        <th>Filename</th>
                                        <th>Children</th>
                                        <th>Adults</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>{{this.$route.query.filename}}</th>
                                        <th>{{this.$route.query.scoreChild}}</th>
                                        <th>{{this.$route.query.scoreAdult}}</th>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="clearfix">
                                        <button type="button" v-on:click="backToHome"
                                            class="btn-shadow btn-wide float-right btn-pill btn-hover-shine btn btn-success btn-lg">Home</button>
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
    import axios from 'axios';

    export default {
        title() {
            return 'See the score';
        },
        data() {
            return {

            }
        },
        methods: {
            backToHome() {
                this.$router.push('/');
            }
        },
        mounted() {

        }
    }

</script>
