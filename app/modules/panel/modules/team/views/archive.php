<style>
    td img {
        width: 32px;
        height: 32px;
        border-radius: 16px;
    }
</style>

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">

                <!-- Head -->
                <div class="flex-btw flex-vc mob_fc">
                    <h1>Archived Team Members</h1>

                    <div>
                        <a class="btn btn-primary mb-2 mr-2" href="{URL:panel/team}">
                            <i class="fas fa-database"></i>
                            Active <span class="hide_block768">Team Members</span>
                        </a>
                    </div>
                </div>


                <!-- Table -->
                <div class="table-responsive mb-4 mt-4">
                    <table id="zero-config" class="table table-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th class="max_w_60">ID</th>
                            <th class="min_w_name">Full Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th class="w_options">Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($this->team) { ?>
                            <?php foreach ($this->team as $item) { ?>
                                <tr class="tr-hovered" id="item_<?= $item->id; ?>">
                                    <td class="mini_mize max_w_60" title="<?= $item->id; ?>">
                                        <?php echo $item->id; ?>
                                    </td>
                                    <td>
                                        <?php /*if ($item->image) { ?>
                                            <img src="<?= _SITEDIR_ ?>data/users/mini_<?= $item->image ?>" alt="ava">
                                        <?php } else { ?>
                                            <img src="<?= _SITEDIR_ ?>assets/img/90x90.jpg" alt="avatar">
                                        <?php } */ ?>

                                        <div class="avatar avatar-sm avatar-indicators <?= ($item->last_time > (time() - 600) ? 'avatar-online' : 'avatar-offline') ?>">
                                            <?php if (FileBase::exist(_SYSDIR_ . Storage::shardDir('users', $item->id) . 'mini_' . $item->image)) { ?>
                                                <img alt="avatar" src="<?= Storage::get('mini_' . $item->image, 'users', $item->id) ?>" class="rounded-circle" />
                                            <?php } else { ?>
                                                <img alt="avatar" src="<?= _SITEDIR_ ?>assets/img/90x90.jpg" class="rounded-circle" />
                                            <?php } ?>
                                        </div>&nbsp;
                                        <a href="{URL:panel/team/edit/<?= $item->id ?>}"><?= $item->firstname . ' ' . $item->lastname ?></a>
                                    </td>
                                    <td>
                                        <?php echo $item->email; ?>
                                    </td>
                                    <td>
                                        <?php echo str_replace(['moder'], ['consultant'], $item->role); ?>
                                    </td>
                                    <td>
                                        <div class="items-row align-items-center">
                                            <div class="dropdown dropup custom-dropdown-icon">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                                                    <a href="{URL:panel/team/edit/<?= $item->id; ?>}" class="dropdown-item"><i class="fa fa-pencil-alt"></i> Edit</a>
                                                    <a @click="load('panel/team/resume/<?= $item->id; ?>');" class="dropdown-item restore-item"><i class="fa fa-trash-restore"></i> Re-live</a>
                                                    <a @click="load('panel/team/delete/<?= $item->id; ?>');" class="dropdown-item remove-item"><i class="fa fa-trash-alt"></i> Delete</a>
                                                </div>
                                            </div>

                                            <div class="btns-list">
                                                <a @click="load('panel/team/resume/<?= $item->id; ?>');" class="btn-rectangle bs-tooltip fa fa-trash-restore restore-item" title="Re-live"></a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
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
        $('#zero-config').DataTable({
            "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Search...",
                "sLengthMenu": "Results :  _MENU_",
            },
            "aoColumnDefs": [
                {
                    "aTargets": [-1],
                    "bSortable": false,
                },
                {
                    "aTargets": [-1],
                    "bSearchable": false
                }
            ],
            "stripeClasses": [],
            "lengthMenu": [10, 25, 50, 100],
            "pageLength": 25
        });
    });
</script>
<!-- END PAGE LEVEL SCRIPTS -->
