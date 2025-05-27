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
                        <h1>Testimonials</h1>

                        <div>
                            <a class="btn btn-primary mb-2 mr-2" href="{URL:panel/testimonials/archive}">
                                <i class="fas fa-archive mp768_0"></i>
                                <span class="hide_block768">Archived</span>
                            </a>
                            <a class="btn btn-primary mb-2 mr-2" href="{URL:panel/testimonials/add}">
                                <i class="fas fa-plus"></i>
                                Add <span class="hide_block768">New Testimonial</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive mb-4 mt-1" id="table-container">
                    <input type="hidden" id="table-orderby" name="orderby" value="id">
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
                                <span class="flex">ID <span class="sort-arrows" data-sort="id"><i class="fas fa-sort-up"></i></span></span>
                            </th>
                            <th class="pointer sort-field">
                                <span class="flex">Name <span class="sort-arrows" data-sort="name"><i class="fas fa-sort"></i></span></span>
                            </th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody id="table-body">
                        <?php include _SYSDIR_ . 'modules/panel/modules/testimonials/views/_table_body.php' ?>
                        </tbody>
                    </table>
                    <div id="pagination-box">
                        <?php if ($this->list) {?>
                            <?= $this->count > $this->elemPerPage ? Pagination::panelPagination('panel/testimonials/pagination', ['orderby' => 'id', 'ordertype' => 'desc']) : '' ?>
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
        let pagination = new Pagination('table-search', 'table-orderby', 'table-ordertype', 'testimonials', 'pagination');
        pagination.initialization();
    });
</script>
