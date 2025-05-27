<?php Popup::head('VIEW DATA', 'old-popup-styles full-height'); ?>

<ul class="nav nav-tabs  mb-3 mt-3 nav-fill" id="justifyTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="justify-system-tab" data-toggle="tab" href="#justify-system" role="tab" aria-controls="justify-system" aria-selected="true">Versions matching</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="justify-email-tab" data-toggle="tab" href="#justify-email" role="tab" aria-controls="justify-email" aria-selected="false">Json</a>
    </li>
</ul>


<div class="tab-content" id="justifyTabContent">
    <!-- Version Matching-->
    <div class="tab-pane fade show active" id="justify-system" role="tabpanel" aria-labelledby="justify-system-tab">
        <?php if ($this->changedRows || $this->changedManyToManyRows) { ?>
            <div class="mb20">
                <a class="btn btn-outline-success rollback-btn" @click="load('panel/data_versions/rollback/<?= $this->state->id ?>');" href=""><i class="fas fa-undo"></i>Rollback</a>
            </div>
            <?php if ($this->changedRows) { ?>
                <h3>Table Fields</h3>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Field</th>
                        <th scope="col">Current</th>
                        <th scope="col">Old</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($this->changedRows as $field => $value) { ?>
                        <?php if ($value['type'] == 'image') { ?>
                            <tr>
                                <td><?= $field ?></td>
                                <td><img width="100" src="<?= trim(SITE_URL, '/') . $value['current'] ?>"></td>
                                <td><img width="100" src="<?= trim(SITE_URL, '/') . $value['state'] ?>"></td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td><?= $field ?></td>
                                <td><?= $value['current'] ?></td>
                                <td><?= $value['state'] ?></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                    </tbody>
                </table>
            <?php } ?>

            <?php if ($this->changedManyToManyRows) { ?>
                <h3>Relationships</h3>
                <?php foreach ($this->changedManyToManyRows as $tableName => $mode) {
                    $secondKey = $mode['fk_second'];
                    ?>
                    <p><?= $tableName ?></p>
                    <div class="row mb-3">
                        <?php foreach ($mode as $changeMode => $rows) {
                            if ($changeMode === 'fk_second') continue;
                            ?>
                            <div class="col">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col"><?= $changeMode ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($rows as $row) {
                                        ?>
                                        <tr>
                                            <td><?= $row->field_name ?: $row->$secondKey ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            <?php } ?>
        <?php } else { ?>
            <h3>Version matches the current one</h3>
        <?php } ?>
    </div>
    <!--  End Version Matching -->

    <!--  Json-->
    <div class="tab-pane fade" id="justify-email" role="tabpanel" aria-labelledby="justify-email-tab">
        <div>
            <?php printf("<pre>%s</pre>", $this->json); ?>
        </div>
    </div>
    <!--  End json -->
</div>

<?php Popup::foot(); ?>
<?php Popup::closeListener(); ?>
<script>
    $('.rollback-btn').confirm({
        buttons: {
            tryAgain: {
                text: 'Yes, rollback',
                btnClass: 'btn-green',
                action: function () {
                    const link = this.$target.attr('@click');
                    console.log('Clicked tooltip');

                    if (typeof link === "undefined") {
                        location.href = this.$target.attr('href');
                    } else {
                        eval(link);
                    }
                }
            },
            cancel: function () {}
        },
        icon: 'fas fa-exclamation-triangle',
        title: 'Are you sure?',
        content: 'Are you sure you wish to rollback? Please re-confirm this action.',
        type: 'green',
        typeAnimated: true,
        boxWidth: '30%',
        useBootstrap: false,
        theme: 'modern',
        animation: 'scale',
        backgroundDismissAnimation: 'shake',
        draggable: false
    });
</script>
