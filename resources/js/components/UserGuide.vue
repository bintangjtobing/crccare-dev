<template>
    <div>
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-bookmarks icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>User Guide
                        <div class="page-title-subheading">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="accordion mb-4" id="userGuideAccordion">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h5 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne"
                            aria-expanded="true" aria-controls="collapseOne">
                            Getting started
                        </button>
                    </h5>
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                    data-parent="#userGuideAccordion">
                    <div class="card-body">
                        Welcome to mineCARE, developed by CRC CARE. mineCARE is a graphical statistical
                        analysis app that helps consultants, researchers and government representatives
                        prioritise and manage remediation of contaminated mine sites.
                        <br><br>
                        <strong>Dashboard</strong><br>
                        The dashboard is where you will find a summary of data you have entered and
                        graphical representation of the data and statistical analysis.
                        <br><br>
                        The dashboard provides users with information about the number of files they
                        have and the total number of all users’ files. It also provides a summary of
                        their data’s mineCARE scores, including average, maximum and minimum values for
                        Adult and children.
                        <br><br>
                        Administrators can see the number of total users and files, and a summary of the
                        average, maximum and minimum scores for all users.
                        <br><br>
                        <strong>Overview</strong><br>
                        The overview provides a summary of the data all users have entered. It provides
                        details about the number of sets of data entered, a graph of the average and
                        standard deviation, and a comparison of results.
                        <br><br>
                        The 3 graphs are:
                        <div class="graphGuide">
                            <ol>
                                <li>The normal distribution of the data (including mean, and first and
                                    second
                                    standard deviation)
                                <li>A radar chart with the 3 axes representing human impact,
                                    ecological
                                    impact
                                    and groundwater impact – users can compare their data with the
                                    average
                                    and
                                    maximum values of all data, and administrators can compare all users’
                                    files</li>
                                <li>A scatter plot that ranks a user’s data. Administrators can rank all
                                    users’
                                    files. Each dot point on the scatter plot represents a user’s data file,
                                    with
                                    the Filename hyperlinked to the data.</li>
                            </ol>
                        </div>
                        <br>
                        The graphs can be used to identify priority contaminated mine sites for
                        remediation.
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            How to enter data
                        </button>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#userGuideAccordion">
                    <div class="card-body">
                        <strong>Create new file</strong><br>
                        Enter the filename, description of the data and, if available, add relevant
                        reports or documentation about the data to the upload area (you can upload
                        multiple documents).
                        <br><br>
                        <strong>Chemical profile</strong><br>
                        This is where you can enter results from a laboratory-based analysis. Select a
                        chemical from the drop-down list and add chemical concentrations (for soil,
                        groundwater and surface water) from your laboratory-based analysis. Once ready
                        (not all boxes need to be completed), click ‘Add to list’.
                        <br><br>
                        If there are multiple metals at the site, repeat until all chemicals have been
                        entered.
                        <br><br>
                        <strong>Human impact</strong><br>
                        The weighting on human impact should be between 0 and 2 (enter 1 unless you need
                        to increase or decrease the emphasis on human impact).
                        <br><br>
                        Select the area/value of soil based on the description most similar to your
                        site.
                        <br><br>
                        Select whether or not there is a pathway for exposure of groundwater and/or
                        surface water to chemicals. If yes, estimate the amount of water consumed by
                        children less than or equal to 6 years old, and people older than 6 years old.
                        <br><br>
                        <strong>Ecological impact</strong><br>
                        Adjust the slider to estimate the approximate distance between the mine site and
                        the location of the ecological site (e.g. river or forest). Alternatively, you
                        can manually enter the approximate distance in the box.
                        <br><br>
                        Select whether the data are from observation, or modelling using the Revised
                        Universal Soil Loss Equation (RUSLE) model. Then select the extent of erosion.
                        <br><br>
                        If available, use the slider to enter the growth rate of plants in an aquatic or
                        terrestrial environment based on laboratory-based seed tests (this can be left
                        as zero if values are not available.
                        <br><br>
                        <strong>Groundwater impact</strong><br>
                        Select the required answers based on your analytics or other knowledge.
                        <br><br>
                        Click ‘Next step’, check all data are correct, and when ready click ‘Submit
                        data’.
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingThree">
                    <h5 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                            data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Analysing results
                        </button>
                    </h5>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                    data-parent="#userGuideAccordion">
                    <div class="card-body">
                        <strong>Results</strong><br>
                        Results of previously entered data are listed in order (by default, the most
                        recent results are at the bottom of the table, but results can be sorted by
                        clicking the top of any column).
                        <br><br>
                        Users can see their data’s Filename, results and date created. Administrators
                        can see these plus the user’s name.
                        <br><br>
                        Click on the filename or ‘eye’ icon to open the results of a dataset. You can
                        examine or edit the entered data using the ‘Edit’ button.
                        <br><br>
                        Use the ‘bin’ icon if you want to delete the file.
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        title() {
            return 'User guide';
        },
    }

</script>
<style scope>
    .accordion .card .card-body {
        margin-left: 10px;
    }

    .card-header .btn-link {
        color: #fff;
        font-weight: 900;
        font-size: 1rem;
    }

    #userGuideAccordion .card-header {
        background-color: #20aa4f;
    }

    .graphGuide ol,
    ul {
        margin-left: 15px;
    }

</style>
