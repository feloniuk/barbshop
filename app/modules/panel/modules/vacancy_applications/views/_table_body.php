<?php if ($this->list) { ?>
    <?php foreach ($this->list as $item) { ?>
        <tr id="item_<?= $item->id; ?>" class="tr-hovered">
            <td><?= $item->id ?></td>

            <td>
                <a href="{URL:panel/vacancy_applications/edit/<?= $item->id; ?>}">
                    <?php if (!$item->status) { ?>
                        <strong><?= $item->name; ?></strong>
                    <?php } else { ?>
                        <?= $item->name; ?>
                    <?php } ?>
                </a>
            </td>

            <td>
                <?php if (!$item->status) { ?>
                    <strong><?= $item->email; ?></strong>
                <?php } else { ?>
                    <?= $item->email; ?>
                <?php } ?>
            </td>

            <td>
                <a href="{URL:panel/vacancies/edit/<?= $item->vacancy->id; ?>}">
                    <?php if (!$item->status) { ?>
                        <strong><?= $item->vacancy->title; ?></strong>
                    <?php } else { ?>
                        <?= $item->vacancy->title; ?>
                    <?php } ?>
                </a>
            </td>

            <td data-sort="<?= $item->time ?>">
                <?php if (!$item->status) { ?>
                    <strong><?= date('Y-m-d', $item->time); ?></strong>
                <?php } else { ?>
                    <?= date('Y-m-d', $item->time); ?>
                <?php } ?>
            </td>
            <td>
                <div class="form-status-block">
                    <div class="form-status">
                        <div id="status_text_<?= $item->id; ?>">
                            <?= applicationStatus($item->status, true); ?>
                        </div>
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></span>
                    </div>
                    <ul class="fs-list" style="cursor: pointer">
                        <li onclick="load('panel/vacancies/change_app_status/<?= $item->id; ?>', 'status=reviewed', 'vacancy_id=<?= $this->edit->id; ?>');"><div class="fs-item var-1">Reviewed</div></li>
                        <li onclick="load('panel/vacancies/change_app_status/<?= $item->id; ?>', 'status=spoken', 'vacancy_id=<?= $this->edit->id; ?>');"><div class="fs-item var-5">Spoken to Candidate</div></li>
                        <li onclick="load('panel/vacancies/change_app_status/<?= $item->id; ?>', 'status=interviewed', 'vacancy_id=<?= $this->edit->id; ?>');"><div class="fs-item var-4">Interviewed</div></li>
                        <li onclick="load('panel/vacancies/change_app_status/<?= $item->id; ?>', 'status=shortlisted', 'vacancy_id=<?= $this->edit->id; ?>');"><div class="fs-item var-6">Short-listed</div></li>
                        <li onclick="load('panel/vacancies/change_app_status/<?= $item->id; ?>', 'status=rejected', 'vacancy_id=<?= $this->edit->id; ?>');"><div class="fs-item var-2">Rejected</div></li>
                    </ul>
                </div>
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
                                <a href="<?= _SITEDIR_ ?>data/spec/<?= $item->job_spec; ?>" download="<?= $item->name; ?>_spec.<?= File::format($item->job_spec); ?>" class="dropdown-item"><i class="fa fa-download"></i> Download Job Spec</a>
                            <?php } ?>
                            <?php if ($item->cv) { ?>
                                <a href="<?= _SITEDIR_ ?>data/cvs/<?= $item->cv; ?>" download="<?= $item->name; ?>.<?= File::format($item->cv); ?>" class="dropdown-item"><i class="fa fa-download"></i> Download CV</a>
                            <?php } ?>
                            <a @click="load('panel/vacancy_applications/delete/<?= $item->id; ?>');" class="dropdown-item remove-item"><i class="fa fa-trash-alt"></i> Delete</a>
                        </div>
                    </div>

                    <div class="btns-list">
                        <?php if ($item->cv) { ?>
                            <a href="<?= _SITEDIR_ ?>data/cvs/<?= $item->cv; ?>" download="<?= $item->name; ?>.<?= File::format($item->cv); ?>" target="_blank" class="btn-rectangle active bs-tooltip fa fa-download" title="Download CV"></a>
                        <?php } ?>
                        <?php if ($item->job_spec) { ?>
                            <a href="<?= _SITEDIR_ ?>data/spec/<?= $item->job_spec; ?>" download="<?= $item->name; ?>_spec.<?= File::format($item->job_spec); ?>" target="_blank" class="btn-rectangle active bs-tooltip fa fa-download" title="Download Job Spec"></a>
                        <?php } ?>
                    </div>
                </div>
            </td>
        </tr>
    <?php } ?>

    <script>
        $(() => reInitConfirmation());

        $(".form-status").click(function() {
            $('.fs-list').hide();
            $(".form-status-block").removeClass('active');
            $(this).parent().find('.fs-list').toggle();
            $(this).parent().toggleClass('active');
        });
        $(document).on('click', function(e) {
            if (!$(e.target).closest(".form-status-block").length) {
                $('.fs-list').hide();
                $(".form-status-block").removeClass('active');
            }
            e.stopPropagation();
        });
        function closeStatusBlock() {
            $('.fs-list').hide();
            $(".form-status-block").removeClass('active');
        }
    </script>
<?php } ?>
