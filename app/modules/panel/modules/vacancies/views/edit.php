<script src="<?= _SITEDIR_ ?>public/js/backend/Sortable.min.js"></script>

<form id="form_box" action="{URL:panel/vacancies/edit/<?= $this->edit->id; ?>}" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing sticky-container">
            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing sticky-block-top">
                <div class="statbox widget box box-shadow widget-top">
                    <div class="widget-header">

                        <div class="items_group items_group-wrap">
                            <div class="items_left-side">
                                <div class="title-block">
                                    <a class="btn-ellipse bs-tooltip fa fa-briefcase" href="{URL:panel/vacancies}"></a>
                                    <h1 class="page_title"><?= $this->edit->title ?></h1>
                                </div>
                            </div>

                            <div class="items_right-side">
                                <div class="items_small-block">
                                    <a href="{URL:job/<?= $this->edit->slug; ?>}" class="btn-rectangle bs-tooltip fa fa-eye" title="View Job" target="_blank"></a>

                                    <div class="social-btns-list">
                                        <a onclick="share_linkedin(this);" class="btn-social" href="#" data-url="{URL:job/<?= $this->edit->slug; ?>}">
                                            <i class="fa fa-linkedin"></i>
                                        </a>
                                        <a onclick="share_facebook(this);" class="btn-social" href="#" data-url="{URL:job/<?= $this->edit->slug; ?>}">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                        <a onclick="share_twitter(this);" class="btn-social" href="#" data-url="{URL:job/<?= $this->edit->slug; ?>}">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                        <a class="btn-social copy_btn" href="#" data-clipboard-text="{URL:job/<?= $this->edit->slug; ?>}">
                                            <i class="fa fa-copy"></i>
                                        </a>
                                    </div>
                                </div>

                                <a class="btn btn-outline-warning" href="{URL:panel/vacancies}"><i class="fas fa-reply"></i>Back</a>
                            </div>
                        </div>

                        <div class="items_group items_group-wrap items_group-bottom">
                            <div class="items_left-side">
                                <div class="option-btns-list scroll-list">
                                    <a class="btn btn-rectangle_medium active"><i class="bs-tooltip fa fa-pencil-alt"></i>Edit</a>
                                    <a href="{URL:panel/vacancies/applications/<?= $this->edit->id; ?>}" class="btn btn-rectangle_medium" title="Applications List"><i class="bs-tooltip far fa-user"></i>Applications</a>
                                    <a href="{URL:panel/vacancies/statistic/<?= $this->edit->id; ?>}" class="btn btn-rectangle_medium" title="Statistic"><i class="bs-tooltip fa fa-chart-bar"></i>Statistic</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- General -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>General</h4>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="title">Job Title</label>
                            <input class="form-control" type="text" name="title" id="title" value="<?= post('title', false, $this->edit->title); ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="ref">Job Ref (Letters, numbers and hyphens (-) only)</label>
                            <input class="form-control" type="text" name="ref" id="ref" value="<?= post('ref', false, $this->edit->ref); ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Industries/Sectors</label>
                            <input type="text" class="form-control" id="sector_filter" value="" autocomplete="off" placeholder="Start typing to filter sectors below">
                            <div class="form-check scroll_max_200 border_1">
                                <?php if (isset($this->sectors) && is_array($this->sectors) && count($this->sectors) > 0) { ?>
                                    <?php foreach ($this->sectors as $item) { ?>
                                        <div class="custom-control custom-checkbox checkbox-info">
                                            <input class="custom-control-input" type="checkbox" name="sector_ids[]" id="sector_<?=$item->id?>" value="<?= $item->id; ?>"
                                                <?= checkCheckboxValue(post('sector_ids'), $item->id, $this->edit->sector_ids); ?>
                                            ><label class="custom-control-label sectors" for="sector_<?=$item->id?>"><?= $item->name; ?></label>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Locations</label>
                            <input type="text" class="form-control" id="location_filter" value="" autocomplete="off" placeholder="Start typing to filter locations below">
                            <div class="form-check scroll_max_200 border_1">
                                <?php if (isset($this->locations) && is_array($this->locations) && count($this->locations) > 0) { ?>
                                <?php foreach ($this->locations as $item) { ?>
                                    <div class="custom-control custom-checkbox checkbox-info">
                                        <input class="custom-control-input" type="checkbox" name="location_ids[]" id="location_<?=$item->id?>" value="<?= $item->id; ?>"
                                            <?= checkCheckboxValue(post('location_ids'), $item->id, $this->edit->location_ids); ?>
                                        ><label class="custom-control-label locations" for="location_<?=$item->id?>"><?= $item->name; ?></label>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="salary_value">Salary</label>
                            <input class="form-control" type="text" name="salary_value" id="salary_value" value="<?= post('salary_value', false, $this->edit->salary_value); ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="contract_type">Contract Type</label>
                            <select class="form-control" name="contract_type" id="contract_type" required>
                                <option value="permanent" <?= checkOptionValue(post('contract_type'), 'permanent', $this->edit->contract_type); ?>>Permanent</option>
                                <option value="temporary" <?= checkOptionValue(post('contract_type'), 'temporary', $this->edit->contract_type); ?>>Temporary</option>
                                <option value="contract" <?= checkOptionValue(post('contract_type'), 'contract', $this->edit->contract_type); ?>>Contract</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="time">Date Published</label>
                            <input class="form-control" type="text" name="time" id="time" value="<?= post('time', false, date("d/m/Y", $this->edit->time)); ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="time_expire">Date Expires</label>
                            <input class="form-control" type="text" name="time_expire" id="time_expire" value="<?= post('time_expire', false, date("d/m/Y", $this->edit->time_expire)); ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="posted" class="bold red">Published</label>
                            <select class="form-control" name="posted" id="posted" required>
                                <option value="yes" <?= checkOptionValue(post('posted'), 'yes', $this->edit->posted); ?>>
                                    Yes
                                </option>
                                <option value="no" <?= checkOptionValue(post('posted'), 'no', $this->edit->posted); ?>>
                                    No
                                </option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="name">Internal</label>
                            <div class="custom-control custom-checkbox checkbox-info">
                                <input type="checkbox" class="custom-control-input" name="internal" id="internal"  value="1" <?= $this->edit->internal ? 'checked' : '' ?>>
                                <label class="custom-control-label" for="internal">Display on work for us page</label>
                            </div>
                        </div>
                        <?php /*
                        <div class="form-group col-md-6">
                            <!-- Image -->
                            <label for="image">Image<small><i>(Image files must be under <?= file_current_max_size() ?>, and JPG, GIF or PNG format)</i></small></label>
                            <div class="choose-file modern">
                                <input type="hidden" name="image" id="image" value="<?= post('image', false, $this->blog->image); ?>">
                                <a class="file-fake" onclick="load('panel/select_image', 'field=#image')" style="cursor: pointer;"><i class="fas fa-folder-open"></i>Choose image</a>

                                <div id="preview_image" class="preview_image">
                                    <img src="<?= _SITEDIR_ ?>data/vacancy/<?= post('image', false, $this->edit->image); ?>" alt="">
                                </div>
                            </div>
                        </div>
                        */ ?>
                    </div>
                </div>
            </div>

            <!-- Short Description -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="form-row">
                        <div class="form-group col-md-12 mb-0">
                            <h4>Short Description</h4>
                            <textarea class="form-control" name="content_short" id="content_short" rows="20"><?= post('content_short', false, $this->edit->content_short); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="form-row">
                        <div class="form-group col-md-12 mb-0">
                            <h4>Description</h4>
                            <textarea class="form-control" name="content" id="description" rows="20"><?= post('content', false, $this->edit->content); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Consultant -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="form-row">
                        <div class="form-group col-md-12 mb-0">
                            <h4>Consultant</h4>
                            <select class="form-control" name="consultant_id" id="consultant_id" required>
                                <option value="0">- No Consultant -</option>
                                <?php if (isset($this->consultants) && is_array($this->consultants) && count($this->consultants) > 0) { ?>
                                    <?php foreach ($this->consultants as $member) { ?>
                                        <option value="<?= $member->id; ?>" <?= checkOptionValue(post('consultant_id'), $member->id, $this->edit->consultant_id); ?>><?= $member->firstname . ' ' . $member->lastname; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>On-page SEO</h4>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="meta_title">
                                Meta Title<a href="https://moz.com/learn/seo/title-tag" target="_blank"><i class="fas fa-info-circle"></i></a>
                            </label>
                            <input class="form-control" type="text" name="meta_title" id="meta_title" value="<?= post('meta_title', false, $this->edit->meta_title); ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="meta_keywords">
                                Meta Keywords<a href="https://moz.com/learn/seo/what-are-keywords" target="_blank"><i class="fas fa-info-circle"></i></a>
                            </label>
                            <input class="form-control" type="text" name="meta_keywords" id="meta_keywords" value="<?= post('meta_keywords', false, $this->edit->meta_keywords); ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 mb-0">
                            <label for="meta_desc">
                                Meta Description<a href="https://moz.com/learn/seo/meta-description" target="_blank"><i class="fas fa-info-circle"></i></a>
                            </label>
                            <input class="form-control" type="text" name="meta_desc" id="meta_desc" value="<?= post('meta_desc', false, $this->edit->meta_desc); ?>">
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <label for="slug">
                                URL Slug<a href="https://moz.com/blog/15-seo-best-practices-for-structuring-urls" target="_blank"><i class="fas fa-info-circle"></i></a>
                                &nbsp;&nbsp;{URL:job}/<?= $this->edit->slug; ?>
                            </label>
                            <input class="form-control" type="text" name="slug" id="slug" value="<?= $this->edit->slug; ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing sticky-block-bottom">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header widget-bottom">
                        <a class="btn btn-outline-warning" href="{URL:panel/vacancies}"><i class="fas fa-reply"></i>Back</a>
                        <a class="btn btn-success" onclick="
                                setTextareaValue();
                                load('panel/vacancies/edit/<?= $this->edit->id; ?>', 'form:#form_box'); return false;">
                            <i class="fas fa-save"></i>Save Changes
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

<link rel="stylesheet" href="<?= _SITEDIR_ ?>public/plugins/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
<script src="<?= _SITEDIR_ ?>public/plugins/ckeditor/ckeditor.js"></script>
<script src="<?= _SITEDIR_ ?>public/plugins/ckeditor/samples/js/sample.js"></script>

<!-- Connect editor -->
<script>
    $('.scroll-list').addClass('scrollbarHide');
    $('.scroll-list').scrollbar({
        "ignoreOverlay": false,
        "ignoreMobile": false
    });

    $('#sector_filter').keyup(function () {
        var q = $(this).val().toLowerCase().trim();

        if (q.length > 0) {
            $('.sectors').each(function (i, sector) {
                if ($(sector).text().trim().toLowerCase().indexOf(q) === -1) {
                    $(sector).parent().addClass('hidden')
                } else {
                    $(sector).parent().removeClass('hidden')
                }
            });
        } else {
            $('.sectors').each(function (i, sector) {
                $(sector).parent().removeClass('hidden')
            });
        }
    });

    $('#location_filter').keyup(function () {
        var q = $(this).val().toLowerCase().trim();

        if (q.length > 0) {
            $('.locations').each(function (i, location) {
                if ($(location).text().trim().toLowerCase().indexOf(q) === -1) {
                    $(location).parent().addClass('hidden')
                } else {
                    $(location).parent().removeClass('hidden')
                }
            });
        } else {
            $('.locations').each(function (i, location) {
                $(location).parent().removeClass('hidden')
            });
        }
    });

    var editorField;
    var editorField2;

    function setTextareaValue() {
        $('#content_short').val(editorField.getData());
        $('#description').val(editorField2.getData());
    }

    $(function () {
        $("#candidate_name").on("change paste keyup", function() {
            load('panel/vacancies/search_candidates','candidate_name=' + $(this).val(), 'vacancy_id=<?=$this->edit->id?>'); return false;
        });

        $('#time').datepicker({dateFormat: 'dd/mm/yy'});
        $('#time_expire').datepicker({dateFormat: 'dd/mm/yy'});

        editorField = CKEDITOR.replace('content_short', {
            htmlEncodeOutput: false,
            wordcount: {
                showWordCount: true,
                showCharCount: true,
                countSpacesAsChars: true,
                countHTML: false,
            },
            removePlugins: 'zsuploader',

            filebrowserBrowseUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/browse.php?opener=ckeditor&type=files',
            filebrowserImageBrowseUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/browse.php?opener=ckeditor&type=images',
            filebrowserUploadUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/upload.php?opener=ckeditor&type=files',
            filebrowserImageUploadUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/upload.php?opener=ckeditor&type=images'
        });

        editorField2 = CKEDITOR.replace('description', {
            htmlEncodeOutput: false,
            wordcount: {
                showWordCount: true,
                showCharCount: true,
                countSpacesAsChars: true,
                countHTML: false,
            },
            removePlugins: 'zsuploader',

            filebrowserBrowseUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/browse.php?opener=ckeditor&type=files',
            filebrowserImageBrowseUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/browse.php?opener=ckeditor&type=images',
            filebrowserUploadUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/upload.php?opener=ckeditor&type=files',
            filebrowserImageUploadUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/upload.php?opener=ckeditor&type=images'
        });
    });
</script>
