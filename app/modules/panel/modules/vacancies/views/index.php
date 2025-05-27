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
                    <div class="flex-btw flex-vc mob_fc">
                        <h1 class="page_title">Vacancies</h1>

                        <div class="mb-2-centered mt10-mob">
                            <?php if (intval(Request::getUri(0))) { ?>
                                <a class="btn btn-primary mb-2 mr-2" href="{URL:panel/microsites}">
                                    <i class="fas fa-arrow-circle-left"></i>
                                    Back
                                </a>
                            <?php } ?>

                            <a class="btn btn-outline-dark mb-2 mr-2" href="{URL:panel/vacancies/download_xml}" target="_blank">
                                <i class="fas fa-file-export"></i> <span class="hide_block768">Export</span> to XML
                            </a>
                            <a class="btn btn-outline-dark mb-2 mr-2" href="{URL:panel/vacancies/download_csv}" onclick="loader(); load('panel/vacancies/download_csv'); return false;">
                                <i class="fas fa-file-export"></i> <span class="hide_block768">Export</span> to CSV
                            </a>
                            <a class="btn btn-primary mb-2 mr-2" href="{URL:panel/vacancies/archive}">
                                <i class="fas fa-archive mp768_0"></i>
                                <span class="hide_block768">Archived</span>
                            </a>
                            <a class="btn btn-primary mb-2 mr-2" href="{URL:panel/vacancies/add/<?= $this->microsite->id ?? ''; ?>}">
                                <i class="fas fa-plus"></i>
                                Add <span class="hide_block768">New Vacancy</span>
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
                            <th class="pointer sort-field"><span class="flex">Ref <span class="sort-arrows" data-sort="ref"><i class="fas fa-sort"></i></span></span></th>
                            <th class="pointer sort-field"><span class="flex">Job Title <span class="sort-arrows" data-sort="title"><i class="fas fa-sort"></i></span></span></th>
                            <th class="pointer"><span class="flex">Sector <span class="sort-arrows"></span></span></th>
                            <th class="pointer"><span class="flex">Location <span class="sort-arrows"></span></span></th>
                            <th class="pointer sort-field"><span class="flex">Views <span class="sort-arrows" data-sort="views"><i class="fas fa-sort"></i></span></span></th>
                            <th class="pointer"><span class="flex">Applies <span class="sort-arrows"></span></span></th>
                            <th class="pointer sort-field"><span class="flex">Posted <span class="sort-arrows" data-sort="posted"><i class="fas fa-sort"></i></span></span></th>
                            <th class="pointer sort-field"><span class="flex">Date Posted<span class="sort-arrows" data-sort="time"><i class="fas fa-sort-up"></i></span></span></th>
                            <th>Share</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody id="table-body">
                        <?php include _SYSDIR_ . 'modules/panel/modules/vacancies/views/_table_body.php' ?>
                        </tbody>
                    </table>
                    <div id="pagination-box">
                        <?php if ($this->list) {?>
                            <?= $this->count > $this->elemPerPage ? Pagination::panelPagination('panel/vacancies/pagination', ['orderby' => 'time', 'ordertype' => 'desc']) : '' ?>
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
        let pagination = new Pagination('table-search', 'table-orderby', 'table-ordertype', 'vacancies', 'pagination');
        pagination.initialization();
    });
</script>
