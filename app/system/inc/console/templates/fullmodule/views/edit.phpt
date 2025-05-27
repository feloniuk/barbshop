<form id="form_box" action="{URL:panel/{{ classNamePath }}/edit/<?= $this->edit->id; ?>}" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">

            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow widget-top">
                    <div class="widget-header">

                        <div class="items_group items_group-wrap">
                            <div class="items_left-side">
                                <div class="title-block">
                                    <a class="btn-ellipse bs-tooltip fas fa-rss" href="{URL:panel/{{ classNamePath }}}"></a>
                                    <h1 class="page_title"><?= $this->edit->title ?></h1>
                                </div>
                            </div>

                            <div class="items_right-side">
                                <div class="items_small-block">

                                </div>

                                <a class="btn btn-outline-warning" href="{URL:panel/{{ classNamePath }}}"><i class="fas fa-reply"></i>Back</a>
                            </div>
                        </div>

                        <div class="items_group items_group-wrap items_group-bottom">
                            <div class="items_left-side">
                                <div class="option-btns-list scroll-list">
                                    <a class="btn btn-rectangle_medium active"><i class="bs-tooltip fa fa-pencil-alt"></i>Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- General -->
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>General</h4>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" value="<?= post('title', false, $this->edit->title); ?>">
                            </div>
                        </div>
                         <div class="form-group col-md-6">
                            <!-- Image -->
                            <?= ImageAlts::createField(
                                'image',
                                "'panel/select_image', 'field=#image', 'width=600', 'height=400'",
                                $this->edit->image,
                                _SITEDIR_ . 'data/{{ classNamePath }}/',
                                $this->edit->alt_attributes['image']
                            )?>
                        </div>
                         <div class="form-group col-md-6">
                            <label for="posted">Posted</label>
                            <select class="form-control" name="posted" id="posted" required>
                                <option value="yes" <?= checkOptionValue(post('posted'), 'yes', $this->edit->posted); ?>>Yes</option>
                                <option value="no" <?= checkOptionValue(post('posted'), 'no', $this->edit->posted); ?>>No</option>
                            </select>
                        </div>
                         <div class="form-group col-md-6">
                            <label>Industries/Sectors</label>
                            <input type="text" class="form-control" id="sector_filter" value="" autocomplete="off" placeholder="Start typing to filter sectors below">
                            <div class="form-check scroll_max_200 border_1">
                                <?php if ($this->sectors) { ?>
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
                        <div class="form-group">
                            <label for="file">File
                                <?= ( $this->edit->file ? '<a href="' . _SITEDIR_ . 'data/{{ classNamePath }}/'  .   $this->edit->file . '" download="' . $this->edit->file . '"><i class="fas fa-download"></i> Download</a>' : '') ?>
                            </label>
                            <div class="flex-btw flex-vc">
                                <div class="choose-file">
                                    <input type="hidden" name="file" id="file_input" value="<?= post($this->edit->file, false,  $this->edit->file ); ?>">
                                    <input type="file" accept="doc, docx, pdf, txt, fotd" onchange="initFile(this); load('page/upload/', 'name=<?= randomHash(); ?>', 'preview=#file_preview', 'field=#file_input');">
                                    <a class="file-fake"><i class="fas fa-folder-open"></i>Choose file</a>
                                </div>
                                <div id="file_preview"></div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="slug">
                                URL Slug<a href="https://moz.com/blog/15-seo-best-practices-for-structuring-urls" target="_blank"><i class="fas fa-info-circle"></i></a>
                                &nbsp;&nbsp;{URL:{{ classNamePath }}}/<?= $this->edit->slug; ?>
                            </label>
                            <input class="form-control" type="text" name="slug" id="slug" value="<?= $this->edit->slug; ?>">
                        </div>
                    </div>
                </div>
            </div>

             <!-- Content -->
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>Content</h4>
                    <div class="form-group mb-0">
                        <textarea class="form-control" name="content" id="text_content" rows="20"><?= post('content', false, $this->edit->content); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing sticky-block-bottom">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header widget-bottom">
                        <a class="btn btn-outline-warning" href="{URL:panel/{{ classNamePath }}}"><i class="fas fa-reply"></i>Back</a>
                        <a class="btn btn-success" onclick="
                                setTextareaValue();
                                load('panel/{{ classNamePath }}/edit/<?= $this->edit->id; ?>', 'form:#form_box'); return false;">
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
    var editorField;

    function setTextareaValue() {
        $('#text_content').val(editorField.getData());
    }

    $(function () {
        $('#time').datepicker({dateFormat: 'dd/mm/yy'});

        editorField = CKEDITOR.replace('text_content', {
            htmlEncodeOutput: false,
            wordcount: {
                showWordCount: true,
                showCharCount: true,
                countSpacesAsChars: true,
                countHTML: true,
            },
            // enterMode: CKEDITOR.ENTER_BR, // to remove <p>
            // removePlugins: 'zsuploader',

            filebrowserBrowseUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/browse.php?opener=ckeditor&type=files',
            filebrowserImageBrowseUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/browse.php?opener=ckeditor&type=images',
            filebrowserUploadUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/upload.php?opener=ckeditor&type=files',
            filebrowserImageUploadUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/upload.php?opener=ckeditor&type=images'
        });
    });
</script>
