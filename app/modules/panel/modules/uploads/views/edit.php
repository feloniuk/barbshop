<form id="form_box" action="{URL:panel/uploads/edit/<?= $this->edit->id; ?>}" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow widget-top">
                    <div class="widget-header">

                        <div class="items_group items_group-wrap">
                            <div class="items_left-side">
                                <div class="title-block">
                                    <a class="btn-ellipse bs-tooltip fa fa-comments-o" href="{URL:panel/uploads}"></a>
                                    <h1 class="page_title"><?= $this->edit->name ?></h1>
                                </div>
                            </div>

                            <div class="items_right-side hide_block1024">
                                <div class="items_small-block">
                                </div>

                                <a class="btn btn-outline-warning" href="{URL:panel/uploads}"><i class="fas fa-reply"></i>Back</a>
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
                            <label for="name">Name</label>
                            <input class="form-control" type="text" name="name" id="name" value="<?= post('name', false, $this->edit->name); ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="slug">Slug
                                <a href="https://moz.com/blog/15-seo-best-practices-for-structuring-urls" target="_blank"><i class="fas fa-info-circle"></i></a>
                                &nbsp;&nbsp;{URL:uploads}/<?= $this->edit->slug; ?>
                            </label>
                            <input class="form-control" type="text" name="slug" id="slug" value="<?= post('slug', false, $this->edit->slug); ?>">
                        </div>

                        <div class="form-group col-md-3">
                            <!-- File -->
                            <div class="flex-btw">
                                <label for="image">
                                    File
                                    <?= ($this->edit->file ? '<a href="' . _SITEDIR_ . 'data/uploads/' . $this->edit->file . '" id="file_btn2" download="' . $this->edit->slug .'.' . File::format($this->edit->file) . '"><i class="fas fa-download"></i> Download</a>' : '') ?>
                                </label>
                            </div>
                            <div class="flex-btw flex-vc" id="download">
                                <div class="choose-file">
                                    <input type="hidden" name="file" id="file"
                                           value="<?= post('file', false, $this->edit->file); ?>">
                                    <input type="file"
                                           onchange="initFile(this); load('page/upload/', 'name=<?= randomHash(); ?>', 'preview=#file_name', 'field=#file');">
                                    <a class="file-fake"><i class="fas fa-folder-open"></i>Choose file</a>
                                </div>
                                <div id="file_name"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing sticky-block-bottom">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header widget-bottom">
                        <a class="btn btn-outline-warning" href="{URL:panel/uploads}"><i class="fas fa-reply"></i>Back</a>
                        <a class="btn btn-success" onclick="
                                load('panel/uploads/edit/<?= $this->edit->id; ?>', 'form:#form_box'); return false;">
                            <i class="fas fa-save"></i>Save Changes
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>
