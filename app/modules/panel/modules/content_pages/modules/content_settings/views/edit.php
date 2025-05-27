<form id="form_box" action="{URL:panel/content_pages/content_settings/edit/<?= $this->testimonial->id; ?>}" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <h1 class="page_title"><a href="{URL:panel/content_pages/content_settings}">Settings</a>&nbsp;» Edit</h1>
                    </div>
                </div>
            </div>

            <!-- General -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>General</h4>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Name</label>
                            <input class="form-control" type="text" name="name" id="name" value="<?= post('name', false, $this->testimonial->name); ?>">
                        </div>
                        <div class="form-group col-md-6">

                            <label>Pages</label>

                            <input type="text" class="form-control" id="page_filter" value="" autocomplete="off" placeholder="Start typing to filter pages below">
                            <div class="form-check scroll_max_200 border_1">
                                <?php foreach ($this->list as $module => $array) { ?>
                                    <label><strong class="pages"><?= (ucfirst(str_replace('_', ' ', trim($module))) === 'Blogs') ? 'News' : (ucfirst(str_replace('_', ' ', trim($module)))) ?></strong></label>
                                    <?php foreach ($array as $item) { ?>
                                        <div class="custom-control custom-checkbox checkbox-info">
                                            <input class="custom-control-input" type="checkbox" name="pages[]" id="<?= $module . '-' . $item->page ?>" value="<?= $module . '-' . $item->page ?>"
                                                <?= checkCheckboxValue(post('pages'),$module . '-' . $item->page, $this->settings_saved); ?>
                                            ><label class="custom-control-label pages" for="<?= $module . '-' . $item->page ?>"><?= ucfirst(str_replace('_', ' ', $item->page_name ?: $item->page)) . ' (url: ' . str_replace('$', '', SITE_URL . $item->pattern) . ')'; ?></label>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details -->
            <?php /*
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="form-group">
                        <h4>Content</h4>
                        <textarea name="content" id="description" rows="20"><?= post('content', false, $this->testimonial->content); ?></textarea>
                    </div>
                </div>
            </div>
            */ ?>

            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div>
                            <a class="btn btn-success" onclick="
                                    // setTextareaValue();
                                    load('panel/content_pages/content_settings/edit/<?= $this->testimonial->id; ?>', 'form:#form_box'); return false;">
                                <i class="fas fa-save"></i>Save Changes
                            </a>
                            <a class="btn btn-outline-warning" href="{URL:panel/content_pages/content_settings}"><i class="fas fa-ban"></i>Cancel</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

<script>
    $('#page_filter').keyup(function () {
        var q = $(this).val().toLowerCase().trim();

        if (q.length > 0) {
            $('.pages').each(function (i, sector) {
                if ($(sector).text().trim().toLowerCase().indexOf(q) === -1) {
                    $(sector).parent().addClass('hidden')
                } else {
                    $(sector).parent().removeClass('hidden')
                }
            });
        } else {
            $('.pages').each(function (i, sector) {
                $(sector).parent().removeClass('hidden')
            });
        }
    });
</script>