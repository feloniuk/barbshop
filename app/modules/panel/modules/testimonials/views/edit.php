<form id="form_box" action="{URL:panel/testimonials/edit/<?= $this->testimonial->id; ?>}" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow widget-top">
                    <div class="widget-header">

                        <div class="items_group items_group-wrap">
                            <div class="items_left-side">
                                <div class="title-block">
                                    <a class="btn-ellipse bs-tooltip fa fa-comments-o" href="{URL:panel/testimonials}"></a>
                                    <h1 class="page_title"><?= $this->testimonial->name ?></h1>
                                </div>
                            </div>

                            <div class="items_right-side hide_block1024">
                                <div class="items_small-block">
                                </div>

                                <a class="btn btn-outline-warning" href="{URL:panel/testimonials}"><i class="fas fa-reply"></i>Back</a>
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
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" type="text" name="name" id="name" value="<?= post('name', false, $this->testimonial->name); ?>">
                            </div>
                            <div class="form-group">
                                <label for="name">Position</label>
                                <input class="form-control" type="text" name="position" id="position" value="<?= post('position', false, $this->testimonial->position); ?>">
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <!-- Image -->
                            <label for="image">Image<small><i>(Image files must be under <?= file_current_max_size() ?>, and JPG, GIF or PNG format)</i></small></label>

                            <div class="choose-file modern">
                                <input type="hidden" name="image" id="image" value="<?= post('image', false, $this->testimonial->image); ?>">
                                <a class="file-fake" onclick="load('panel/select_image', 'field=#image')" style="cursor: pointer;"><i class="fas fa-folder-open"></i>Choose image</a>
                                <div id="preview_image" class="preview_image">
                                    <img src="<?= _SITEDIR_ ?>data/testimonials/<?= post('image', false, $this->testimonial->image); ?>" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 mb-0">
                            <label for="user_image">Or choose consultant image</label>
                            <select class="form-control" name="user_image" id="user_image" required>
                                <option value="0">- Choose consultant -</option>
                                <?php if (isset($this->team) && is_array($this->team) && count($this->team) > 0) { ?>
                                    <?php foreach ($this->team as $member) { ?>
                                        <option value="<?= $member->id; ?>" <?= checkOptionValue(post('user_image'), $member->id, $this->testimonial->user_image); ?>><?= $member->firstname . ' ' . $member->lastname; ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="form-group mb-0">
                        <h4>Content</h4>
                        <textarea name="content" id="description" rows="20"><?= post('content', false, $this->testimonial->content); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing sticky-block-bottom">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header widget-bottom">
                        <a class="btn btn-outline-warning" href="{URL:panel/testimonials}"><i class="fas fa-reply"></i>Back</a>
                        <a class="btn btn-success" onclick="
                                setTextareaValue();
                                load('panel/testimonials/edit/<?= $this->testimonial->id; ?>', 'form:#form_box'); return false;">
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
        $('#description').val(editorField.getData());
    }

    $(function () {
        editorField = CKEDITOR.replace('description', {
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