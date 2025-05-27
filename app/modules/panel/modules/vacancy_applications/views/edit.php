
<form id="form_box" action="{URL:panel/vacancy_applications/edit/<?= $this->edit->id; ?>}" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow widget-top">
                    <div class="widget-header">

                        <div class="items_group items_group-wrap">
                            <div class="items_left-side">
                                <div class="title-block">
                                    <a class="btn-ellipse bs-tooltip fa fa-address-card-o" href="{URL:panel/vacancy_applications}"></a>
                                    <h1 class="page_title"><?= $this->edit->name ?></h1>
                                </div>
                            </div>

                            <div class="items_right-side">
                                <div class="items_small-block">
                                    <?php if ($this->edit->vacancy_id) { ?>
                                        <a class="btn-social copy_btn" href="{URL:panel/vacancies/edit/<?= $this->edit->vacancy_id ?>}">
                                            <i class="fa fa-briefcase"></i>
                                        </a>
                                    <?php } ?>
                                    <?php if ($this->edit->cv) { ?>
                                        <a class="btn-social copy_btn bs-tooltip" href="<?= _SITEDIR_ ?>data/cvs/<?= $this->edit->cv ?>" target="_blank" title="Download CV"
                                           download="<?= $this->edit->name ?>.<?= File::format($this->edit->cv) ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    <?php } ?>
                                    <?php if ($this->edit->job_spec) { ?>
                                        <a class="btn-social copy_btn bs-tooltip" href="<?= _SITEDIR_ ?>data/spec/<?= $this->edit->job_spec ?>" target="_blank" title="Download Job Spec"
                                           download="<?= $this->edit->name ?>_spec.<?= File::format($this->edit->job_spec) ?>">
                                            <i class="fa fa-download"></i>
                                        </a>
                                    <?php } ?>
                                </div>

                                <a class="btn btn-outline-warning" href="{URL:panel/vacancy_applications}"><i class="fas fa-reply"></i>Back</a>
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
                            <label for="title">Full name</label>
                            <input class="form-control" type="text" name="name" id="name" value="<?= post('name', false, $this->edit->name); ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="ref">Email</label>
                            <input class="form-control" type="text" name="email" id="email" value="<?= post('email', false, $this->edit->email); ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 mb-0">
                            <label for="salary_value">Contact number</label>
                            <input class="form-control" type="text" name="tel" id="tel" value="<?= post('tel', false, $this->edit->tel); ?>">
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <label for="contract_type">LinkedIn</label>
                            <input class="form-control" type="text" name="linkedin" id="linkedin" value="<?= post('linkedin', false, $this->edit->linkedin); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>Message</h4>
                    <div class="form-group mb-0">
                        <textarea class="form-control" name="message" id="message" rows="20"><?= post('message', false, $this->edit->message); ?></textarea>
                    </div>
                </div>
            </div>


            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing sticky-block-bottom">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header widget-bottom">
                        <a class="btn btn-outline-warning" href="{URL:panel/vacancy_applications}"><i class="fas fa-reply"></i>Back</a>
                        <a class="btn btn-success" onclick="
                                setTextareaValue();
                                load('panel/vacancy_applications/edit/<?= $this->edit->id; ?>', 'form:#form_box'); return false;">
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
        $('#message').val(editorField.getData());
    }

    $(function () {
        editorField = CKEDITOR.replace('message', {
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
