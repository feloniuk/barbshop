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

                    <div class="items_group items_group-wrap">
                        <div class="items_left-side">
                            <div class="title-block">
                                <a class="btn-ellipse bs-tooltip fa fa-user-friends" href="{URL:panel/team}"></a>
                                <h1 class="page_title"><?= $this->user->firstname . ' ' . $this->user->lastname ?></h1>
                            </div>
                        </div>

                        <div class="items_right-side">
                            <div class="items_small-block">
                                <a href="{URL:about-us/profile/<?= $this->user->slug; ?>}" class="btn-rectangle bs-tooltip fa fa-eye" title="View Member" target="_blank"></a>

                                <div class="social-btns-list">
                                    <a onclick="share_linkedin(this);" class="btn-social" href="#" data-url="{URL:about-us/profile/<?= $this->user->slug; ?>}">
                                        <i class="fa fa-linkedin"></i>
                                    </a>
                                    <a onclick="share_facebook(this);" class="btn-social" href="#" data-url="{URL:about-us/profile/<?= $this->user->slug; ?>}">
                                        <i class="fa fa-facebook"></i>
                                    </a>
                                    <a onclick="share_twitter(this);" class="btn-social" href="#" data-url="{URL:about-us/profile/<?= $this->user->slug; ?>}">
                                        <i class="fa fa-twitter"></i>
                                    </a>
                                    <a class="btn-social copy_btn" href="#" data-clipboard-text="{URL:about-us/profile/<?= $this->user->slug; ?>}">
                                        <i class="fa fa-copy"></i>
                                    </a>
                                </div>
                            </div>

                            <a class="btn btn-outline-warning" href="{URL:panel/team}"><i class="fas fa-reply"></i>Back</a>
                        </div>
                    </div>

                    <div class="items_group items_group-wrap items_group-bottom">
                        <div class="items_left-side">
                            <div class="option-btns-list scroll-list">
                                <a href="{URL:panel/team/edit/<?= $this->user->id; ?>}" class="btn btn-rectangle_medium"><i class="bs-tooltip fa fa-pencil-alt"></i>Edit</a>
                                <a class="btn btn-rectangle_medium active" title="Applications List"><i class="bs-tooltip fas fa-briefcase"></i>Vacancies</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <?php /*
                <a class="btn btn-primary mb-2 mr-2" href="{URL:panel/vacancies/add/<?= ($this->microsite ? $this->microsite->id : ''); ?>}">
                    <i class="fas fa-plus"></i>
                    Add <span class="hide_block768">New Vacancy</span>
                </a>
                */ ?>

                <!-- Table -->
                <div class="table-responsive mb-4">
                    <table id="zero-config" class="table table-hover" style="width:100%">
                        <thead>
                        <tr>
                            <th>Ref</th>
                            <th>Job Title</th>
                            <th>Sector</th>
                            <th>Location</th>
                            <th>Views</th>
                            <th>Applies</th>
                            <th>Posted</th>
                            <th class="max_w_55">Share</th>
                            <th class="w_options">Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($this->list) && is_array($this->list) && count($this->list)) { ?>
                            <?php foreach ($this->list as $item) { ?>
                                <tr id="item_<?= $item->id; ?>" class="tr-hovered">
                                    <td class="mini_mize max_w_60" title="<?= $item->ref; ?>">
                                        <?= $item->ref; ?>
                                    </td>
                                    <td>
                                        <!--<i class="fas fa-arrow-right" style="padding-right: 5px;"></i>-->
                                        <a href="{URL:panel/vacancies/edit/<?= $item->id ?>}"><?= $item->title; ?></a>
                                    </td>
                                    <td>
                                        <?php echo implode(", ", array_map(function ($sector) {
                                            return $sector->sector_name;
                                        }, $item->sectors)); ?>
                                    </td>
                                    <td>
                                        <?php echo implode(", ", array_map(function ($location) {
                                            return $location->location_name;
                                        }, $item->locations)); ?>
                                    </td>
                                    <td>
                                        <?= $item->views; ?>
                                    </td>
                                    <td>
                                        <a href="{URL:panel/vacancies/applications/<?= $item->id; ?>}"><?= $item->applications; ?></a>
                                    </td>
                                    <td data-sort="<?= $item->time ?>">
                                        <?= date('Y-m-d', $item->time); ?>
                                    </td>
                                    <td>
                                        <a class="btn__ bs-tooltip fas fa-share-alt dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference<?= $item->id; ?>"
                                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent"></a>

                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuReference<?= $item->id; ?>">
                                            <a onclick="share_linkedin(this);" class="dropdown-item copy_btn" href="#" data-url="{URL:job/<?= $item->slug; ?>}"><i class="fa fa-linkedin"></i> Share to LinkedIn</a>
                                            <a onclick="share_facebook(this);" class="dropdown-item copy_btn" href="#" data-url="{URL:job/<?= $item->slug; ?>}"><i class="fa fa-facebook"></i> Share to Facebook</a>
                                            <a onclick="share_twitter(this);" class="dropdown-item copy_btn" href="#" data-url="{URL:job/<?= $item->slug; ?>}"><i class="fa fa-twitter"></i> Share to Twitter</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item copy_btn" href="#" data-clipboard-text="{URL:job/<?= $item->slug; ?>}"><i class="fa fa-copy"></i> Copy Link</a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="items-row align-items-center">
                                            <div class="dropdown dropup custom-dropdown-icon">
                                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                                </a>

                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                                                    <a href="{URL:panel/vacancies/edit/<?= $item->id; ?>}" class="dropdown-item"><i class="fa fa-pencil-alt"></i> Edit</a>
                                                    <a href="{URL:job/<?= $item->slug; ?>}" class="dropdown-item" target="_blank"><i class="fa fa-eye"></i> View Job</a>
                                                    <a onclick="load('panel/vacancies/duplicate/<?= $item->id; ?>');" style="cursor: pointer;" class="dropdown-item"><i class="fa fa-clone"></i> Duplicate</a>
                                                    <a href="{URL:panel/vacancies/statistic/<?= $item->id; ?>}" class="dropdown-item"><i class="fa fa-chart-bar"></i> Statistic</a>
                                                    <a href="{URL:panel/vacancies/expire/<?= $item->id; ?>}" class="dropdown-item"><i class="fa fa-hourglass-end"></i> Expire</a>
                                                    <a @click="load('panel/vacancies/delete/<?= $item->id; ?>');" class="dropdown-item remove-item"><i class="fa fa-trash-alt"></i> Delete</a>
                                                </div>
                                            </div>

                                            <div class="btns-list">
                                                <a href="{URL:job/<?= $item->slug; ?>}" class="btn-rectangle bs-tooltip fa fa-eye" target="_blank" title="View Job"></a>
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
                    "aTargets": [-2, -1],
                    "bSortable": false,
                },
                {
                    "aTargets": [-2, -1],
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
