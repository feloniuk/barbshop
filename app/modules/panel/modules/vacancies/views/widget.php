<div class="column">
    <h1>Latest Vacancies</h1>

    <?php foreach ($this->list as $item) { ?>
        <div class="widget flex-btw flex-center">
            <div class="flex flex-center">
                <span class="ref mr20"><strong>#<?= $item->ref; ?></strong></span>
                <a class="title" href="{URL:panel/vacancies/edit/<?= $item->id; ?>}" target="_blank">
                    <?= $item->title; ?>
                </a>
            </div>
            <span class="date"><em>Posted: <?= date("d/m/Y", $item->time); ?></em></span>

            <?php /*
            <span class="title"><?= $item->title; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="actions">
                <a href="{URL:panel/vacancies/edit/<?= $item->id; ?>}" target="_blank">
                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                </a>
            </div>
            */ ?>
        </div>
    <?php } ?>
</div>