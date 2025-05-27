<div class="layout-px-spacing">
    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">

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

                <!-- Table -->
                <div class="table-responsive mb-4 mt-4">
                    <table id="zero-config" class="table table-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th class="max_w_60">ID</th>
                            <th class="min_w_name">Title</th>
                            <th>Views</th>
                            <th>Posted</th>
                            <th>Date</th>
                            <th class="max_w_55">Share</th>
                            <th class="w_options">Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>


<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?= _SITEDIR_ ?>public/plugins/datatable/datatables.js"></script>
<script>
    $(function () {
        var table = $('#zero-config').DataTable({
            'processing': true,
            'serverSide': true,
            'ajax': {
                'url': '<?= SITE_URL ?>/panel/blog/pagination',
                'type': 'POST'
            },
            "createdRow": function (row, data) {
                $(row).addClass('tr-hovered');
                $(row).attr('id', 'item_' + data['id']);
            },
            'columns': [
                {data: 'id'},
                {
                    "mData": null,
                    "bSortable": false,
                    "mRender": function (data, type, full) {
                        let html = `<a href="<?= SITE_URL ?>panel/blog/edit/${full.id}">${full.title}</a>`;
                        return html;
                    }
                },
                {data: 'views'},
                {data: 'posted'},
                {data: 'time'},
                {
                    "mData": null,
                    "bSortable": false,
                    "mRender": function (data, type, full) {
                        return `<td>
                                    <a class="btn__ bs-tooltip fas fa-share-alt dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference${full.id}"
                                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent"></a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference${full.id}">
                                        <a onclick="share_linkedin(this);" class="dropdown-item copy_btn" href="#" data-url="<?= SITE_URL ?>blog/${full.slug}"><i class="fa fa-linkedin"></i> Share to LinkedIn</a>
                                        <a onclick="share_facebook(this);" class="dropdown-item copy_btn" href="#" data-url="<?= SITE_URL ?>blog/${full.slug}"><i class="fa fa-facebook"></i> Share to Facebook</a>
                                        <a onclick="share_twitter(this);" class="dropdown-item copy_btn" href="#" data-url="<?= SITE_URL ?>blog/${full.slug}"><i class="fa fa-twitter"></i> Share to Twitter</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item copy_btn" href="#" data-clipboard-text="<?= SITE_URL ?>blog/${full.slug}"><i class="fa fa-copy"></i> Copy Link</a>
                                    </div>
                                </td>`;
                    }
                },
                {
                    "mData": null,
                    "bSortable": false,
                    "mRender": function (data, type, full) {
                        return `<td>
                                    <div class="items-row align-items-center">
                                        <div class="dropdown dropup custom-dropdown-icon">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                                                <a href="<?= SITE_URL ?>panel/blog/edit/${full.id}" class="dropdown-item"><i class="fa fa-pencil-alt"></i> Edit</a>
                                                <a href="<?= SITE_URL ?>blog/${full.slug}" class="dropdown-item" target="_blank"><i class="fa fa-eye"></i> View Blog</a>
                                                <a href="<?= SITE_URL ?>panel/blog/statistic/${full.id}" class="dropdown-item"><i class="fa fa-chart-bar"></i> Statistic</a>
                                                <a @click="load('<?= SITE_URL ?>panel/blog/delete/${full.id}');" class="dropdown-item remove-item"><i class="fa fa-trash-alt"></i> Delete</a>
                                            </div>
                                        </div>

                                        <div class="btns-list">
                                            <a href="<?= SITE_URL ?>blog/${full.slug}" class="btn-rectangle bs-tooltip fa fa-eye" target="_blank" title="View Blog"></a>
                                        </div>
                                    </div>
                                </td>`;
                    }
                }
            ],
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "stripeClasses": [],
            "lengthMenu": [2, 5, 25, 50, 100],
            "pageLength": 25
        });

        table.on('draw', function () {
            if (!!$.prototype.confirm) {
                // Remove confirmation
                $('.remove-item').confirm({
                    buttons: {
                        tryAgain: {
                            text: 'Yes, delete',
                            btnClass: 'btn-red',
                            action: function () {
                                // old
                                // console.log('Clicked tooltip');
                                // location.href = this.$target.attr('href');

                                const link = this.$target.attr('@click');
                                console.log('Clicked tooltip');

                                if (typeof link === "undefined") {
                                    location.href = this.$target.attr('href');
                                } else {
                                    eval(link);
                                }
                            }
                        },
                        cancel: function () {
                        }
                    },
                    icon: 'fas fa-exclamation-triangle',
                    title: 'Are you sure?',
                    content: 'Are you sure you wish to delete this item? Please re-confirm this action.',
                    type: 'red',
                    typeAnimated: true,
                    boxWidth: '30%',
                    useBootstrap: false,
                    theme: 'modern',
                    animation: 'scale',
                    backgroundDismissAnimation: 'shake',
                    draggable: false
                });
            }
        });
    });
</script>
<!-- END PAGE LEVEL SCRIPTS -->