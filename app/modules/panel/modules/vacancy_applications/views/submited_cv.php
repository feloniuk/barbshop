<!--LOADER-->
<div id="loader_fon">
    <div id="loader"></div>
</div>
<!--END LOADER-->

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">

        <!-- Title ROW -->
        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="statbox widget box box-shadow widget-top">
                <div class="widget-header">
                    <!-- Head -->
                    <div class="flex-btw flex-vc mob_fc">
                        <h1>Uploaded CVs</h1>
                        <div>
                            <a class="btn btn-primary mb-2 mr-2" href="{URL:panel/vacancy_applications/cvs_archive}">
                                <i class="fas fa-archive mp768_0"></i>
                                <span class="hide_block768">Archived</span>
                            </a>
                            <a class="btn btn-primary mb-2 mr-2" onclick="load('panel/vacancy_applications/export_data', 'type=upload'); return false;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></svg>
                                <span class="hide_block768">Export</span> to CSV
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive mb-4 mt-1" id="table-container">
                    <input type="hidden" id="table-orderby" name="orderby" value="time">
                    <input type="hidden" id="table-ordertype" name="ordertype" value="desc">

                    <div class="flex-end mb-2">
                        <div>
                            <input type="text" class="form-control" name="search" id="table-search" placeholder="Search">
                        </div>
                    </div>

                    <table id="zero-config" class="table table-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th class="pointer sort-field">
                                <span class="flex">Name <span class="sort-arrows" data-sort="name"><i class="fas fa-sort"></i></span></span>
                            </th>
                            <th class="pointer sort-field">
                                <span class="flex">Email <span class="sort-arrows" data-sort="email"><i class="fas fa-sort"></i></span></span>
                            </th>
                            <th class="pointer sort-field">
                                <span class="flex">Date Submitted <span class="sort-arrows" data-sort="time"><i class="fas fa-sort-up"></i></span></span>
                            </th>
                            <th>Status</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody id="table-body">
                        <?php include _SYSDIR_ . 'modules/panel/modules/vacancy_applications/views/_table_body_cv.php' ?>
                        </tbody>
                    </table>
                    <div id="pagination-box">
                        <?php if ($this->list) {?>
                            <?= $this->count > $this->elemPerPage ? Pagination::panelPagination('panel/vacancy_applications/pagination_cvs', ['orderby' => 'time', 'ordertype' => 'desc']) : '' ?>
                        <?php } else { ?>
                            <div class="mt-4">
                                <p>Results not found</p>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<script>
    $(function () {
        let pagination = new Pagination('table-search', 'table-orderby', 'table-ordertype', 'vacancy_applications', 'pagination_cvs');
        pagination.initialization();
    });
</script>
