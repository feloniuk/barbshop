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
                        <h1>Orders</h1>
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
                                <span class="flex">ID <span class="sort-arrows" data-sort="id"><i class="fas fa-sort"></i></span></span>
                            </th>
                            <th class="pointer sort-field">
                                <span class="flex">Name <span class="sort-arrows" data-sort="name"><i class="fas fa-sort"></i></span></span>
                            </th>
                            <th class="pointer sort-field">
                                <span class="flex">Phone <span class="sort-arrows" data-sort="tel"><i class="fas fa-sort"></i></span></span>
                            </th>
                            <th class="pointer sort-field">
                                <span class="flex">Date <span class="sort-arrows" data-sort="time"><i class="fas fa-sort-up"></i></span></span>
                            </th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody id="table-body">
                            <?php include _SYSDIR_ . 'modules/panel/modules/orders/views/_table_body.php' ?>
                        </tbody>
                    </table>
                    <div id="pagination-box">
                        <?php if ($this->list) {?>
                            <?= $this->count > $this->elemPerPage ? Pagination::panelPagination('panel/orders/pagination', ['orderby' => 'time', 'ordertype' => 'desc']) : '' ?>
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
        let pagination = new Pagination('table-search', 'table-orderby', 'table-ordertype', 'orders', 'pagination');
        pagination.initialization();
    });
</script>
