<link rel="stylesheet" type="text/css" href="<?= _SITEDIR_ ?>assets/css/forms/switches.css">
<link rel="stylesheet" href="<?= _SITEDIR_ ?>public/css/backend/colorPick.css">
<script src="<?= _SITEDIR_ ?>public/js/backend/colorPick.js"></script>
<style>
    .picker {
        border-radius: 5px;
        width: 36px;
        height: 36px;
        cursor: pointer;
        -webkit-transition: all linear .2s;
        -moz-transition: all linear .2s;
        -ms-transition: all linear .2s;
        -o-transition: all linear .2s;
        transition: all linear .2s;
        border: thin solid #eee;
    }
</style>
<form id="form_box" action="{URL:panel/analytics/config}" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow widget-top">
                    <div class="widget-header">

                        <div class="items_group items_group-wrap">
                            <div class="items_left-side">
                                <div class="title-block">
                                    <a class="btn-ellipse bs-tooltip fa fa-cookie"></a>
                                    <h1 class="page_title">Cookie Popup</h1>
                                </div>
                            </div>

                            <div class="items_right-side hide_block1024">
                                <div class="items_small-block"></div>
                                <a class="btn btn-outline-warning" href="{URL:panel}"><i class="fas fa-reply"></i>Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- General -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>General</h4>

                    <label for="site_key">Enable Popup</label>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6 p-0">
                        <label class="switch s-icons s-outline  s-outline-success  mb-4 mr-2">
                            <input type="checkbox" name="enable_popup" value="1" <?php if ($this->enable_cookie) echo 'checked' ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>

                    <!-- Content -->
                    <label for="site_key">Content</label>
                    <div class="form-group mb-0">
                        <textarea class="form-control" name="content" id="text_content" rows="20"><?= post('content', false, $this->cookie_content); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Styles -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>Styles</h4>

                    <div class="form-row">
                        <div class="form-group col-md-2 mb-0">
                            <label for="site_key">BG Color</label>
                            <div class="picker" id="bg_color_block"></div>
                            <input type="hidden" name="bg_color" id="bg_color" value="<?= post('bg_color', false, $this->bg_color); ?>">
                        </div>

                        <div class="form-group col-md-2 mb-0">
                            <label for="site_key">Text Color</label>
                            <div class="picker" id="text_color_block"></div>
                            <input type="hidden" name="text_color" id="text_color" value="<?= post('text_color', false, $this->text_color); ?>">
                        </div>
                        <div class="form-group col-md-2 mb-0">
                            <label for="site_key">Button Color</label>
                            <div class="picker" id="button_color_block"></div>
                            <input type="hidden" name="button_color" id="button_color" value="<?= post('button_color', false, $this->button_color); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing sticky-block-bottom">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header widget-bottom">
                        <a class="btn btn-outline-warning" href="{URL:panel}"><i class="fas fa-reply"></i>Back</a>
                        <a class="btn btn-success" onclick="setTextareaValue();load('panel/settings/cookie', 'form:#form_box'); return false;"><i class="fas fa-save"></i>Save Changes</a>
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

    // Styles
    $("#bg_color_block").colorPick({
        'initialColor' : '<?= $this->bg_color ?>',
        'palette': [
            "#64c2c8", "#1abc9c", "#16a085", "#2ecc71", "#27ae60",
            "#3498db", "#2980b9", "#9b59b6", "#8e44ad",
            "#34495e", "#2c3e50", "#34495e", "#000000",
            "#f1c40f", "#f39c12", "#e67e22", "#d35400", "#e74c3c",
            "#c0392b", "#ecf0f1"
        ],
        'onColorSelected': function() {
            $('#bg_color').val(this.color);
            this.element.css({'backgroundColor': this.color, 'color': this.color});
        }
    });

    $("#text_color_block").colorPick({
        'initialColor' : '<?= $this->text_color ?>',
        'palette': [
            "#64c2c8", "#1abc9c", "#16a085", "#2ecc71", "#27ae60",
            "#3498db", "#2980b9", "#9b59b6", "#8e44ad",
            "#34495e", "#2c3e50", "#34495e", "#000000",
            "#f1c40f", "#f39c12", "#e67e22", "#d35400", "#e74c3c",
            "#c0392b", "#ecf0f1"
        ],
        'onColorSelected': function() {
            $('#text_color').val(this.color);
            this.element.css({'backgroundColor': this.color, 'color': this.color});
        }
    });

    $("#button_color_block").colorPick({
        'initialColor' : '<?= $this->button_color ?>',
        'palette': [
            "#64c2c8", "#1abc9c", "#16a085", "#2ecc71", "#27ae60",
            "#3498db", "#2980b9", "#9b59b6", "#8e44ad",
            "#34495e", "#2c3e50", "#34495e", "#000000",
            "#f1c40f", "#f39c12", "#e67e22", "#d35400", "#e74c3c",
            "#c0392b", "#ecf0f1"
        ],
        'onColorSelected': function() {
            $('#button_color').val(this.color);
            this.element.css({'backgroundColor': this.color, 'color': this.color});
        }
    });
</script>