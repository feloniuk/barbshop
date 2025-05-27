<form id="form_box" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow widget-top">
                    <div class="widget-header">

                        <div class="items_group items_group-wrap">
                            <div class="items_left-side">
                                <div class="title-block">
                                    <a class="btn-ellipse bs-tooltip fa fa-robot"></a>
                                    <h1 class="page_title">Robots.txt</h1>
                                </div>
                            </div>

                            <div class="items_right-side">
                                <div class="items_small-block">
                                    <a href="<?= url('robots.txt') ?>" class="btn-rectangle bs-tooltip fa fa-eye" title="View robots.txt" target="_blank"></a>
                                </div>

                                <a class="btn btn-outline-warning" href="{URL:panel}"><i class="fas fa-reply"></i>Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="form-group mb-0">
                        <label for="content">Content</label>
                        <textarea class="form-control" type="text" name="text" id="text" rows="16"><?= reFilter($this->content) ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing sticky-block-bottom">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header widget-bottom">
                        <a class="btn btn-outline-warning" href="{URL:panel}"><i class="fas fa-reply"></i>Back</a>
                        <a class="btn btn-success" onclick="load('panel/settings/robots', 'form:#form_box'); return false;"><i class="fas fa-save"></i>Save Changes</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>