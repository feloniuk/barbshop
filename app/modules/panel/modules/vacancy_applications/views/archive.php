<div class="layout-px-spacing">
    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">

                <!-- Head -->
                <div class="flex-btw flex-vc mob_fc">
                    <h1>Archived Vacancy Applications</h1>

                    <a class="btn btn-primary mb-2 mr-2" href="{URL:panel/vacancy_applications}">
                        <i class="fas fa-database"></i>
                        Active <span class="hide_block768">Vacancy Applications</span>
                    </a>
                </div>

                <!-- Table -->
                <div class="table-responsive mb-4 mt-4">
                    <table id="zero-config" class="table table-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Vacancy</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Tel</th>
                            <th>Date Submitted</th>
                            <th class="w_options">Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($this->list) && is_array($this->list) && count($this->list)) { ?>
                            <?php foreach ($this->list as $item) { ?>
                                <tr class="tr-hovered">
                                    <td><?= $item->id ?></td>
                                    <td><a href="{URL:panel/vacancies/edit/<?= $item->vacancy_id; ?>}"><?= $item->vacancy_title ? $item->vacancy_title : ''; ?></a></td>
                                    <td><a href="{URL:panel/vacancy_applications/edit/<?= $item->id ?>}"><?= $item->name ?></a></td>
                                    <td><?= $item->email; ?></td>
                                    <td><?= $item->tel; ?></td>
                                    <td data-sort="<?= $item->time ?>">
                                        <?= date('Y-m-d', $item->time); ?>
                                    </td>
                                    <td>
                                        <div class="items-row align-items-center">
                                            <div class="dropdown dropup custom-dropdown-icon">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                                                    <a href="{URL:panel/vacancy_applications/edit/<?= $item->id; ?>}" class="dropdown-item"><i class="fa fa-pencil-alt"></i> Edit</a>
                                                    <?php if ($item->job_spec) { ?>
                                                        <a href="<?= _SITEDIR_ ?>data/cvs/<?= $item->job_spec; ?>" download="SPEC.<?= File::format($item->job_spec )?>" class="dropdown-item"><i class="fa fa-download"></i> Download Job Spec</a>
                                                    <?php } ?>
                                                    <?php if ($item->cv) { ?>
                                                        <a href="<?= _SITEDIR_ ?>data/cvs/<?= $item->cv; ?>" download="CV.<?= File::format($item->cv )?>" class="dropdown-item"><i class="fa fa-download"></i> Download CV</a>
                                                    <?php } ?>
                                                    <a href="{URL:panel/vacancy_applications/resume/<?= $item->id ?>}" class="dropdown-item restore-item"><i class="fa fa-trash-restore"></i> Re-live</a>
                                                </div>
                                            </div>

                                            <div class="btns-list">
                                                <?php if ($item->job_spec) { ?>
                                                    <a href="<?= _SITEDIR_ ?>data/cvs/<?= $item->job_spec; ?>" download="SPEC.<?= File::format($item->job_spec )?>" class="btn-rectangle active bs-tooltip fa fa-download" title="Download Job Spec"></a>
                                                <?php } ?>
                                                <?php if ($item->cv) { ?>
                                                    <a href="<?= _SITEDIR_ ?>data/cvs/<?= $item->cv; ?>" download="CV.<?= File::format($item->cv )?>" class="btn-rectangle active bs-tooltip fa fa-download" title="Download CV"></a>
                                                <?php } ?>
                                                <a href="{URL:panel/vacancy_applications/resume/<?= $item->id ?>}" class="btn-rectangle bs-tooltip fa fa-trash-restore restore-item" title="Re-live"></a>
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
            "pageLength": 25,
            "order": [[0, "desc"]]
        });
    });
</script>
<!-- END PAGE LEVEL SCRIPTS -->
