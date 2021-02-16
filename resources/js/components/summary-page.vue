<template>
    <div>
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-note icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Summary Result
                        <div class="page-title-subheading">
                            your summary and submit when ready
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
            <form @submit.prevent="saveSummaries" method="POST">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Filename</h5>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="exampleEmail55">Filename</label>
                                            <input :value="this.$route.query.getF.filename" type="text"
                                                class="form-control" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label for="examplePassword22">Description</label>
                                            <textarea class="form-control" cols="30" rows="10"
                                                :value="this.$route.query.getF.desc" disabled></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Chemical profile</h5>
                                <table class="table">
                                    <thead>
                                        <tr style="background-color:#3ac47d; color:#fff;">
                                            <th>#</th>
                                            <th>Chemical</th>
                                            <th>Concentration in soil (mg/kg)</th>
                                            <th>Groundwater (mg/L)</th>
                                            <th>Concentration in surface (mg/L)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(chemical, key) in tableData" :key="key">
                                            <th scope="row">{{key+1}}</th>
                                            <th>{{chemical.chemical ? chemical.chemical.chemical_name : ''}}
                                            </th>
                                            <th>{{chemical.CiS}}</th>
                                            <th>{{chemical.CiG}}</th>
                                            <th>{{chemical.CiSW}}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Human impact</h5>
                                <div class="form-row">
                                    <div class="col-md-8">
                                        <div class="position-relative form-group">
                                            <label>H1: Weight on human risk (w)</label>
                                            <input type="number" step="0.5" :value="this.$route.query.getF.wohr"
                                                disabled class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-8">
                                        <div class="position-relative form-group">
                                            <label for="">H1: Area of soil (shallow [0-0.2
                                                m] contamination cover)</label>
                                            <fieldset class="position-relative form-group">
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input
                                                            :checked="this.$route.query.getF.f1==1" type="radio"
                                                            class="form-check-input" disabled>
                                                        Small
                                                        area
                                                        (&lt;
                                                        50 m<sup>
                                                            2</sup>) with dense groundcover</label>
                                                </div>
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input
                                                            :checked="this.$route.query.getF.f1==2" type="radio"
                                                            class="form-check-input" disabled>
                                                        Small
                                                        area
                                                        (&lt;
                                                        50 m<sup>
                                                            2</sup>) with no groundcover</label>
                                                </div>
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input
                                                            :checked="this.$route.query.getF.f1==3" type="radio"
                                                            class="form-check-input" disabled>
                                                        Large
                                                        area
                                                        (&ge;
                                                        50 m<sup>
                                                            2</sup>) with dense groundcover</label>
                                                </div>
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input
                                                            :checked="this.$route.query.getF.f1==4" type="radio"
                                                            class="form-check-input" disabled>
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
                                                        class="form-check-label"><input
                                                            :checked="this.$route.query.getF.f4==1" type="radio"
                                                            class="form-check-input" disabled>
                                                        Yes</label>
                                                </div>
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input
                                                            :checked="this.$route.query.getF.f4==0" type="radio"
                                                            class="form-check-input" disabled>
                                                        No</label>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-6" v-if="this.$route.query.getF.f4==1">
                                        <div class="position-relative form-group" id="GEPChoose">
                                            <label>Human groundwater
                                                consumption?</label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Under 6 years old</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="number" disabled :value="this.$route.query.getF.hgc"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-4">
                                                    <label>Over 6 years old</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="number" disabled :value="this.$route.query.getF.hgco"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="position-relative form-group">
                                            <label>H4: Surface water exposure
                                                pathway</label>
                                            <fieldset class="position-relative form-group">
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input
                                                            :checked="this.$route.query.getF.f13==1" disabled
                                                            type="radio" class="form-check-input">
                                                        Yes</label>
                                                </div>
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input
                                                            :checked="this.$route.query.getF.f13==0" disabled
                                                            type="radio" class="form-check-input">
                                                        No</label>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-6" v-if="this.$route.query.getF.f13==1">
                                        <div class="position-relative form-group">
                                            <label>Human surface water consumption?</label>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label>Under 6 years old</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="number" disabled :value="this.$route.query.getF.hswc"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-4">
                                                    <label>Over 6 years old</label>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="number" disabled :value="this.$route.query.getF.hswco"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Ecological Impact</h5>
                                <div class="form-row mb-4">
                                    <div class="col-md-8">
                                        <div class="position-relative form-group">
                                            <label style="color: #fff">WoAR</label>
                                            <div>
                                                <input type="text" class="form-control"
                                                    :value="this.$route.query.getF.woar" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-2">
                                        <div class="position-relative form-group">
                                            <label><strong>F10:
                                                    Erosion</strong></label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="position-relative-form-group">
                                            <label class="form-check-label">
                                                <input :checked="this.$route.query.getF.erosion=='observation'"
                                                    class="form-check-input" type="radio" disabled>
                                                Observation
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="position-relative-form-group">
                                            <label class="form-check-label">
                                                <input :checked="this.$route.query.getF.erosion=='ruslemodel'"
                                                    class="form-check-input" type="radio" disabled>
                                                RUSLE model (Revised universal soil loss equation model)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-4" v-if="this.$route.query.getF.erosion=='observation'">
                                        <div class="position-relative form-group">
                                            <select class="form-control" disabled>
                                                <option :selected="this.$route.query.getF.erosionval==1">Tailing
                                                    impoundment and/or contaminated
                                                    material appears stable
                                                    (no seepage / erosion)</option>
                                                <option :selected="this.$route.query.getF.erosionval==2">Evidence of
                                                    slight erosion of waste /
                                                    contaminated material
                                                </option>
                                                <option :selected="this.$route.query.getF.erosionval==3">Evidence of
                                                    moderate erosion of waste /
                                                    contaminated material
                                                </option>
                                                <option :selected="this.$route.query.getF.erosionval==4">Tailings /
                                                    waste unstable (high erosion
                                                    evident)
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-if="this.$route.query.getF.erosion=='ruslemodel'">
                                        <div class="position-relative form-group">
                                            <select class="form-control" disabled>
                                                <option :selected="this.$route.query.getF.erosionval==0">Very low
                                                    (&lt;6.7 tons/ha/year)
                                                </option>
                                                <option :selected="this.$route.query.getF.erosionval==0.5">Low (6.7 -
                                                    11)</option>
                                                <option :checked="this.$route.query.getF.erosionval==1">Moderate (11.2
                                                    - 22.4)</option>
                                                <option :selected="this.$route.query.getF.erosionval==1.5">High (22.4 -
                                                    33.6)</option>
                                                <option :selected="this.$route.query.getF.erosionval==2">Severe
                                                    (&gt;33.6)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <div class="position-relative form-group">
                                            <label>Relative growth rate (aquatic environment)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <input type="text" :value="this.$route.query.getF.rgrae" disabled
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-3">
                                        <div class="position-relative form-group">
                                            <label for="">Relative growth rate (terrestrial environment)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <input type="text" :value="this.$route.query.getF.rgrte" disabled
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <h5 class="card-title">Groundwater impact</h5>
                                <div class="form-row">
                                    <div class="col-md-8">
                                        <div class="position-relative form-group">
                                            <label for="">G1: Levels of contaminants</label>
                                            <label for="">Groundwater concentrations are higher than the human health
                                                and ecological investigation or assessment levels?</label>
                                            <fieldset class="position-relative form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="position-relative form-check"><label
                                                                class="form-check-label"><input type="radio"
                                                                    class="form-check-input"
                                                                    :checked="this.$route.query.getG.loc==1" disabled>
                                                                Yes</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="position-relative form-check"><label
                                                                class="form-check-label"><input type="radio"
                                                                    class="form-check-input"
                                                                    :checked="this.$route.query.getG.loc==0" disabled>
                                                                No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-8">
                                        <div class="position-relative form-group">
                                            <label for="">G2: Synthetic precipitation leaching procedure (SPLP) values
                                            </label>
                                            <label for="">SPLP concentrations are higher than the human health and
                                                ecological investigation or assessment levels?</label>
                                            <fieldset class="position-relative form-group">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="position-relative form-check"><label
                                                                class="form-check-label"><input disabled type="radio"
                                                                    class="form-check-input"
                                                                    :checked="this.$route.query.getG.splp==1">
                                                                Yes</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="position-relative form-check"><label
                                                                class="form-check-label"><input disabled type="radio"
                                                                    class="form-check-input"
                                                                    :checked="this.$route.query.getG.splp==0">
                                                                No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-10">
                                        <div class="position-relative form-group">
                                            <label for="">G3: Depth to the groundwater
                                            </label>
                                            <fieldset class="position-relative form-group">
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input type="radio" disabled
                                                            class="form-check-input"
                                                            :checked="this.$route.query.getG.dttg==1">
                                                        Groundwater table in unconfined aquifer below ground
                                                        surface &lt; 5 m bgs. </label>
                                                </div>
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input type="radio" disabled
                                                            class="form-check-input"
                                                            :checked="this.$route.query.getG.dttg==2">
                                                        Groundwater table in unconfined aquifer below ground
                                                        surface &gt; 5 m bgs and &lt; 10 m bgs. </label>
                                                </div>
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input type="radio" disabled
                                                            class="form-check-input"
                                                            :checked="this.$route.query.getG.dttg==3">
                                                        Groundwater table in unconfined aquifer below ground
                                                        surface &gt; 10 m bgs. </label>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-10">
                                        <div class="position-relative form-group">
                                            <label for="">G4: Off-site impact and liability issues
                                            </label>
                                            <fieldset class="position-relative form-group">
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input type="radio" disabled
                                                            class="form-check-input"
                                                            :checked="this.$route.query.getG.oial==1">
                                                        Groundwater flow direction towards sensitive receptor
                                                        and velocity &lt; 5 m/year. </label>
                                                </div>
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input type="radio" disabled
                                                            class="form-check-input"
                                                            :checked="this.$route.query.getG.oial==2">
                                                        Groundwater flow direction towards sensitive receptor
                                                        and velocity &gt; 5 m/year and &lt; 20 m/year. </label>
                                                </div>
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input type="radio" disabled
                                                            class="form-check-input"
                                                            :checked="this.$route.query.getG.oial==3">
                                                        Groundwater flow direction towards sensitive receptor
                                                        and velocity &gt; 20 m/year and &lt; 30 m/year. </label>
                                                </div>
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input type="radio" disabled
                                                            class="form-check-input"
                                                            :checked="this.$route.query.getG.oial==4">
                                                        Groundwater flow direction towards sensitive receptor
                                                        and velocity &gt; 30 m/year. </label>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-10">
                                        <div class="position-relative form-group">
                                            <label for="">G5: Nearest drinking groundwater borehole
                                            </label>
                                            <fieldset class="position-relative form-group">
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input type="radio" disabled
                                                            class="form-check-input"
                                                            :checked="this.$route.query.getG.ndgb==1">
                                                        Nearest drinking groundwater borehole / residence &le;
                                                        5000 m. </label>
                                                </div>
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input type="radio" disabled
                                                            class="form-check-input"
                                                            :checked="this.$route.query.getG.ndgb==2">
                                                        Nearest drinking groundwater borehole / residence &le;
                                                        2000 m. </label>
                                                </div>
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input type="radio" disabled
                                                            class="form-check-input"
                                                            :checked="this.$route.query.getG.ndgb==3">
                                                        Nearest drinking groundwater borehole / residence &le;
                                                        1000 m. </label>
                                                </div>
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input type="radio" disabled
                                                            class="form-check-input"
                                                            :checked="this.$route.query.getG.ndgb==4">
                                                        Nearest drinking groundwater borehole / residence &le;
                                                        500 m. </label>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-10">
                                        <div class="position-relative form-group">
                                            <label for="">G6: Applicability of institution control
                                            </label>
                                            <fieldset class="position-relative form-group">
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input type="radio" disabled
                                                            class="form-check-input"
                                                            :checked="this.$route.query.getG.aoic==1">
                                                        Stringent institutional control could be applied.
                                                    </label>
                                                </div>
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input type="radio" disabled
                                                            class="form-check-input"
                                                            :checked="this.$route.query.getG.aoic==2">
                                                        Institutional control could be applied but difficult to follow
                                                        up.
                                                    </label>
                                                </div>
                                                <div class="position-relative form-check"><label
                                                        class="form-check-label"><input type="radio" disabled
                                                            class="form-check-input"
                                                            :checked="this.$route.query.getG.aoic==3">
                                                        No institutional control could be applied.
                                                    </label>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="main-card mb-3 card">
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="clearfix">
                                        <a @click="$router.go(-1)" type="button"
                                            class="btn-shadow float-left btn btn-lg btn-link">Back</a>
                                        <button type="submit"
                                            class="btn-shadow btn-wide float-right btn-pill btn-hover-shine btn btn-success btn-lg">Submit
                                            Data</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    import Swal from 'sweetalert2';

    export default {
        title() {
            return 'Look at the summary page';
        },
        data() {
            return {
                tableData: [],
            }
        },
        methods: {
            renderTable() {
                this.tableData = this.$route.query.chemicalData;
            },
            async saveSummaries() {
                var _this = this;
                let dataSum = new FormData();
                for (let x in this.$route.query.getRf) {
                    dataSum.append(x, this.$route.query.getRf[x]);
                }
                for (let y in this.$route.query.getF) {
                    dataSum.append(y, this.$route.query.getF[y]);
                }
                for (let z in this.$route.query.getG) {
                    dataSum.append(z, this.$route.query.getG[z]);
                }
                const result = await Swal.fire({
                    title: 'Are you sure wanna submit data?',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonText: `Submit`,
                });
                if (result.isConfirmed) {
                    let c = await axios.post('saveSummaries', dataSum).then(response => {
                        this.$router.push({
                            path: '/scores-page',
                            query: _this.scoresCalculate()
                        });
                    });
                }
            },
            scoresCalculate() {
                let filename = this.$route.query.getF.filename;
                let totalG = this.$route.query.getF.g;
                // Total F for children
                // // Formula [F]= F1×(F2+F3)+F4×(F5+F6)+F4×(F7+F8)+F9×(F10+F11)+F12
                let stepOneChildren = this.$route.query.getF.f1 * (this.$route.query.getF.f2c +
                    this.$route.query.getF.f3c);
                let stepTwoChildren = this.$route.query.getF.f4 * (this.$route.query.getF.f5c +
                    this.$route.query.getF.f6c);
                let stepThreeChildren = this.$route.query.getF.f13 * (this.$route.query.getF.f7c +
                    this.$route.query.getF.f8c);
                let stepFourChildren = this.$route.query.getF.f9 * (this.$route.query.getF.f10 +
                    this.$route.query.getF.f11);
                let stepLastChildren = this.$route.query.getF.f12;
                let totalFc = stepOneChildren + stepTwoChildren + stepThreeChildren + stepFourChildren +
                    stepLastChildren;
                // Total F for Adults
                // // Formula [F]= F1×(F2+F3)+F4×(F5+F6)+F4×(F7+F8)+F9×(F10+F11)+F12
                let stepOneAdult = this.$route.query.getF.f1 * (this.$route.query.getF.f2a +
                    this.$route.query.getF.f3a);
                let stepTwoAdult = this.$route.query.getF.f4 * (this.$route.query.getF.f5a +
                    this.$route.query.getF.f6a);
                let stepThreeAdult = this.$route.query.getF.f13 * (this.$route.query.getF.f7a +
                    this.$route.query.getF.f8a);
                let stepFourAdult = this.$route.query.getF.f9 * (this.$route.query.getF.f10 +
                    this.$route.query.getF.f11);
                let stepLastAdult = this.$route.query.getF.f12;
                let totalFa = stepOneAdult + stepTwoAdult + stepThreeAdult + stepFourAdult +
                    stepLastAdult;


                let w = this.$route.query.getF.f4;
                let scoreChild = w * (totalFc + totalG);
                let scoreAdult = w * (totalFa + totalG);
                return {
                    totalFa: totalFa,
                    totalFc: totalFc,
                    filename: filename,
                    scoreChild: scoreChild,
                    scoreAdult: scoreAdult,
                }
            }
        },
        mounted() {
            this.renderTable();
            window.scrollTo(0, 0);
        },

    }

</script>

<style scoped>
    .main-card span {
        color: #fff;
    }
</style>
