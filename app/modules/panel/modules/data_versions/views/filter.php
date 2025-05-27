<table id="zero-config" class="table table-hover" style="width:100%">
    <thead>
    <tr>
        <th class="max_w_60">ID</>
        <th>User</th>
        <th>Entity</th>
        <th>Type</th>
        <th>Time</th>
        <th>Data</th>
        <th class="w_options">Options</th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?= _SITEDIR_ ?>public/plugins/datatable/datatables.js"></script>
<script>
    $(function () {
        $('#zero-config').DataTable({
            'processing': true,
            'serverSide': true,
            'ajax': {
                'url':'<?= SITE_URL ?>/panel/data_versions/pagination',
                'type': 'POST',
                'data': function(data) {
                    // Append to data
                    data.moduleFilter = $('#module').val();
                }
            },
            "createdRow": function( row, data ) {
                $(row).addClass( 'tr-hovered' );
                $(row).attr('id', 'item_' + data['id']);
            },
            'columns': [
                { data: 'id' },
                {
                    "mData": null,
                    "mRender": function (data, type, full) {
                        let html =  `<a target="_blank" class="pointer" href="<?= SITE_URL ?>panel/team/edit/${full.user_id}">${full.user_firstname} ${full.user_lastname}</a>`;
                        return html;
                    }
                },
                {
                    "mData": null,
                    "mRender": function (data, type, full) {
                        let html = '';
                        if (full.entity_id.includes('||')) {
                            let modulePage = full.entity_id.substr(1).slice(0, -1).split('||');
                            html += `<a target="_blank" class="pointer" href="<?= SITE_URL ?>panel/content_pages/edit?module=${modulePage[0]}&page=${modulePage[1]}">${full.table}(${modulePage[0]}|${modulePage[1]})</a>`;
                        } else {
                            html += `<a target="_blank" class="pointer" href="<?= SITE_URL ?>panel/${full.table}/edit/${full.entity_id}">${full.table}#${full.entity_id}</a>`;
                        }
                        return html;
                    }
                },
                { data: 'type' },
                { data: 'time' },
                {
                    "mData": null,
                    "bSortable": false,
                    "mRender": function (data, type, full) {
                        let html =  `<a class="pointer" href="" onclick="load('panel/data_versions/data_popup/${full.id}');"><i class="fa fa-eye"></i></a>`;
                        return html;
                    }
                },
                {
                    "mData": null,
                    "bSortable": false,
                    "mRender": function (data, type, full) {
                        let html = `<td>
                                        <div class="items-row align-items-center">
                                            <div class="dropdown dropup custom-dropdown-icon">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                                                    <a @click="load('<?= SITE_URL ?>panel/data_versions/delete/${full.id}');" class="dropdown-item remove-item"><i class="fa fa-trash-alt"></i> Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>`;

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
                        return html;
                    }
                }
            ],
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "order": [[4, 'desc']],
            "stripeClasses": [],
            "lengthMenu": [2, 5, 25, 50, 100],
            "pageLength": 25
        });
    });
</script>
<!-- END PAGE LEVEL SCRIPTS -->

