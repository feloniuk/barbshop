<?php Popup::head("{$this->apply->name} Application", 'old-popup-styles full-height'); ?>
<form id="apply_form" class="popup-form">
    <div class="pf-flex">
        <div class="pf-column">
            <?php if ($this->apply->name) { ?>
            <div class="pf-row">
                <label class="pf-label">Full Name</label>
                <p><?= $this->apply->name ?></p>
            </div>
            <?php } ?>
            <?php if ($this->apply->tel) { ?>
            <div class="pf-row">
                <label class="pf-label">Telephone Number</label>
                <p><?= $this->apply->tel ?></p>
            </div>
            <?php } ?>
        </div>
        <div class="pf-column">
            <?php if ($this->apply->email) { ?>
            <div class="pf-row">
                <label class="pf-label">Email</label>
                <p><?= $this->apply->email ?></p>
            </div>
            <?php } ?>
            <?php if ($this->apply->linkedin) { ?>
            <div class="pf-row">
                <label class="pf-label">LinkedIn</label>
                <p><a href="<?= $this->apply->linkedin ?>" target="_blank"><?= $this->apply->linkedin ?></a></p>
            </div>
            <?php } ?>
        </div>
    </div>

    <?php if ($this->apply->message) { ?>
        <div>
            <div class="pf-row">
                <label class="pf-label">Message</label>
                <p><?= processDesc($this->apply->message); ?></p>
            </div>
        </div>
    <?php } ?>
    <div>
        <div class="form-status-block pf-row">
            <div class="form-status">
                <div id="popup_status">
                    <?= applicationStatus($this->apply->status === '' ? $this->apply->status = 'reviewed' : $this->apply->status , true); ?>
                </div>
                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></span>
            </div>
            <ul class="fs-list" style="cursor: pointer">
                <li onclick="load('panel/vacancies/change_app_status/<?= $this->apply->id; ?>', 'status=reviewed', 'vacancy_id=<?= post('vacancy_id'); ?>');"><div class="fs-item var-1">Reviewed</div></li>
                <li onclick="load('panel/vacancies/change_app_status/<?= $this->apply->id; ?>', 'status=spoken', 'vacancy_id=<?= post('vacancy_id'); ?>');"><div class="fs-item var-5">Spoken to Candidate</div></li>
                <li onclick="load('panel/vacancies/change_app_status/<?= $this->apply->id; ?>', 'status=interviewed', 'vacancy_id=<?= post('vacancy_id'); ?>');"><div class="fs-item var-4">Interviewed</div></li>
                <li onclick="load('panel/vacancies/change_app_status/<?= $this->apply->id; ?>', 'status=shortlisted', 'vacancy_id=<?= post('vacancy_id'); ?>');"><div class="fs-item var-6">Short-listed</div></li>
                <li onclick="load('panel/vacancies/change_app_status/<?= $this->apply->id; ?>', 'status=rejected', 'vacancy_id=<?= post('vacancy_id'); ?>');"><div class="fs-item var-2">Rejected</div></li>
            </ul>
        </div>
    </div>

    <?php if ($this->apply->cv) { ?>
        <a href="<?= _SITEDIR_ ?>data/cvs/<?= $this->apply->cv; ?>" class="btn btn-outline-dark">Download CV</a>
    <?php } ?>
    <a class="btn btn-outline-info" href="{URL:panel/vacancy_applications/edit/<?= $this->apply->id; ?>}">Edit</a>
    <?php if (post('vacancy_id')) { ?>
        <a class="btn btn-outline-danger dlt_btn" href="{URL:panel/vacancies/apply_delete/<?= $this->apply->id; ?>}?id=<?= post('vacancy_id'); ?>">Delete</a>
    <?php } else { ?>
        <a class="btn btn-outline-danger dlt_btn" href="{URL:panel/vacancy_applications/delete/<?= $this->apply->id; ?>}">Delete</a>
    <?php } ?>
</form>
<?php Popup::foot(); ?>
<?php Popup::closeListener(); ?>
<script>
    if (!!$.prototype.confirm) {
        // Remove confirmation
        $('.dlt_btn').confirm({
            buttons: {
                tryAgain: {
                    text: 'Yes, delete',
                    btnClass: 'btn-red',
                    action: function () {
                        console.log('Clicked tooltip');
                        location.href = this.$target.attr('href');
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
</script>
<script>
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