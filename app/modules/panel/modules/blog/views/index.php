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
                        <?php /*
                        <div class="breadcrumb-four">
                            <ul class="breadcrumb">
                                <li class="active">
                                    <a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rss"><path d="M4 11a9 9 0 0 1 9 9"></path><path d="M4 4a16 16 0 0 1 16 16"></path><circle cx="5" cy="19" r="1"></circle></svg>
                                        Blog Posts
                                    </a>
                                </li>
                            </ul>
                        </div>
                        */ ?>

                        <h1>Blog Posts</h1>
                        <div>
                            <a class="btn btn-primary mb-2 mr-2" href="{URL:panel/blog/archive}">
                                <i class="fas fa-archive mp768_0"></i>
                                Archived
                            </a>
                            <a class="btn btn-primary mb-2 mr-2" href="{URL:panel/blog/add}">
                                <i class="fas fa-plus"></i>
                                Add <span class="hide_block768">New Blog Post</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="flex-start flex-wrap orders-filter">
                    <input type="hidden" id="filter-category" name="category" value="">
                    <a class="fs-item filters" onclick="load('panel/blog/pagination', 'category=',
                            'search#table-search', 'orderby#table-orderby', 'ordertype#table-ordertype')">All</a>
                    <?php if ($this->categories) { ?>
                        <?php foreach ($this->categories as $category) {?>
                            <a class="fs-item filters" data-value="<?= $category->id ?>" onclick="load('panel/blog/pagination', 'category=<?= $category->id ?>',
                                    'search#table-search', 'orderby#table-orderby', 'ordertype#table-ordertype')"><?= $category->name ?></a>
                        <?php } ?>
                    <?php } ?>
                    <a class="btn__circle pointer fas fa-wrench" href="{URL:panel/blog/categories}"></a>
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
                                <span class="flex">ID <span class="sort-arrows" data-sort="id"><i class="fas fa-sort"></i></span></span>
                            </th>
                            <th class="pointer sort-field">
                                <span class="flex">Title <span class="sort-arrows" data-sort="title"><i class="fas fa-sort"></i></span></span>
                            </th>
                            <th class="pointer sort-field">
                                <span class="flex">Views <span class="sort-arrows" data-sort="views"><i class="fas fa-sort"></i></span></span>
                            </th>
                            <th class="pointer sort-field">
                                <span class="flex">Posted <span class="sort-arrows" data-sort="posted"><i class="fas fa-sort"></i></span></span>
                            </th>
                            <th class="pointer sort-field">
                                <span class="flex">Date <span class="sort-arrows" data-sort="time"><i class="fas fa-sort-up"></i></span></span>
                            </th>
                            <th>Share</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <tbody id="table-body">
                            <?php include _SYSDIR_ . 'modules/panel/modules/blog/views/_table_body.php' ?>
                        </tbody>
                    </table>
                    <div id="pagination-box">
                        <?php if ($this->list) {?>
                            <?= $this->count > $this->elemPerPage ? Pagination::panelPagination('panel/blog/pagination', ['orderby' => 'id', 'ordertype' => 'desc']) : '' ?>
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
        //change sort field
        const filterFields = document.querySelectorAll('.filters');
        const filterInput = document.getElementById('filter-category');

        filterFields.forEach(field => {
            field.addEventListener('click', function (evt) {
                console.log(filterInput.value)
                filterInput.value = this.getAttribute('data-value');
            });
        })

        let pagination = new Pagination('table-search', 'table-orderby', 'table-ordertype', 'blog', 'pagination');
        pagination.filter = 'category#filter-category';
        pagination.initialization();
    });
</script>
