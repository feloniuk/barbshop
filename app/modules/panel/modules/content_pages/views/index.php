<!-- BEGIN PAGE LEVEL STYLES -->
<link rel="stylesheet" type="text/css" href="<?= _SITEDIR_ ?>assets/css/components/tabs-accordian/custom-tabs.css">
<!-- END PAGE LEVEL STYLES -->

<div class="layout-px-spacing">
    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="widget-content widget-content-area vertical-line-pill br-6">
                <div class="flex-start">
                    <div>
                        <h1 class="page_title">Content Pages</h1>
                    </div>
                    <div class="ml-5">
                        <input id="page_filter" type="text" class="form-control" placeholder="Search..." required="">
                    </div>
                    <hr>
                </div>

                <div class="row mb-4 mt-3">
                    <div class="col-sm-3 col-12" style="max-width: 300px;">
                        <div class="nav flex-column nav-pills mb-sm-0 mb-3 mx-auto" id="v-line-pills-tab" role="tablist" aria-orientation="vertical">

                            <?php foreach ($this->list as $module => $array) { ?>
                                <a class="nav-link <?= ($module == 'page' ? 'active' : '') ?>" id="v-line-pills-<?= $module ?>-tab" data-toggle="pill" href="#v-line-pills-<?= $module ?>"
                                   role="tab" aria-controls="v-line-pills-<?= $module ?>"><?= ucfirst(str_replace('_', ' ', trim($module))) ?></a>
                            <?php } ?>

                        </div>
                    </div>

                    <div class="col-sm-9 col-12">
                        <div class="tab-content" id="v-line-pills-tabContent">
                            <?php foreach ($this->list as $module => $array) { ?>
                                <div class="tab-pane tab-pane_spacing fade show <?= ($module == 'page' ? 'active' : '') ?>" id="v-line-pills-<?= $module ?>" role="tabpanel" aria-labelledby="v-line-pills-<?= $module ?>-tab">

                                    <h3 class="orange"><?= ucfirst(str_replace('_', ' ', trim($module))) ?></h3>
                                    <div class="list__">
                                        <?php foreach ($array as $item) { ?>
                                            <?php if ($item->page && $module) { ?>
                                                <a class="pan_tit pages" href="{URL:panel/content_pages/edit}?module=<?= $module ?>&page=<?= $item->page; ?>">
                                                    <strong><?= ucfirst(str_replace('_', ' ', $item->page_name ? : $item->page)) . ' (url: ' . SITE_URL . str_replace('$', '',removeGetParams($item->pattern)) . ')'; ?></strong>
                                                </a>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<script>

    //check active tab id
    var activeTabId;
    $('.nav-link').each(function (i, link) {
        if ($(link).hasClass('active'))
            activeTabId = $(link).attr('id');
    });

    //check active tab id after changes
    $('.nav-link').on('click', function () {
        activeTabId = $(this).attr('id');
    });

    $('#page_filter').keyup(function () {
        var text = $(this).val().toLowerCase().trim();
        if (text.length > 0) {
            $('.tab-pane').each(function (i, tab) {
                $(tab).removeClass('active')
            });

            $('.pages').each(function (i, page) {

                if ($(page).text().trim().toLowerCase().indexOf(text) === -1) {
                    $(page).addClass('hidden')
                } else {
                    $(page).removeClass('hidden')
                    $(page).parent().parent().addClass('active')

                    $(page).parent().parent().addClass('show')
                }
            });
        } else {
            $('.pages').each(function (i, page) {
                $(page).removeClass('hidden')
                $(page).parent().parent().removeClass('active')
            });

            $('#' + activeTabId.slice(0, -4)).addClass('active');
        }
    });
</script>
