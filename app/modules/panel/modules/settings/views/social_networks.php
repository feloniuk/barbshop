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
                                    <a class="btn-ellipse bs-tooltip fa fa-facebook"></a>
                                    <h1 class="page_title">Social Links</h1>
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

            <!-- Links -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="noreply_mail">Facebook</label>
                            <input class="form-control" type="text" name="facebook" id="facebook" value="<?= post('facebook', false, $this->facebook); ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="noreply_name">LinkedIn</label>
                            <input class="form-control" type="text" name="linkedin" id="linkedin" value="<?= post('linkedin', false, $this->linkedin); ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="noreply_mail">Twitter</label>
                            <input class="form-control" type="text" name="twitter" id="twitter" value="<?= post('twitter', false, $this->twitter); ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="noreply_name">Instagram</label>
                            <input class="form-control" type="text" name="instagram" id="instagram" value="<?= post('instagram', false, $this->instagram); ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="noreply_mail">YouTube</label>
                            <input class="form-control" type="text" name="youtube" id="youtube" value="<?= post('youtube', false, $this->youtube); ?>">
                        </div>
                        <?php /*
                        <div class="form-group col-md-6">
                            <label for="noreply_mail">Pinterest</label>
                            <input class="form-control" type="text" name="pinterest" id="pinterest" value="<?= post('pinterest', false, $this->pinterest); ?>">
                        </div>
                        */ ?>
                    </div>
                </div>
            </div>

            <!-- Upload OG -->
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>Upload OG</h4>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <!-- Og Image -->
                            <label for="image">Main OG Image<small><i>(Image files must be under <?= file_current_max_size() ?>, and JPG, GIF or PNG format)</i></small></label>
                            <div class="choose-file modern">
                                <input type="hidden" name="og_image" id="image" value="<?= post('og_image', false, $this->og_image); ?>">

                                <a class="file-fake" onclick="load('panel/select_image', 'field=#image')" style="cursor: pointer;"><i class="fas fa-folder-open"></i>Choose image</a>

                                <div id="preview_image" class="preview_image">
                                    <img src="<?= _SITEDIR_ ?>data/og/<?= post('og_image', false, $this->og_image); ?>" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <!-- Og Image -->
                            <label for="image">Job OG Image<small><i>(Image files must be under <?= file_current_max_size() ?>, and JPG, GIF or PNG format)</i></small></label>
                            <div class="choose-file modern">
                                <input type="hidden" name="og_job" id="og_job" value="<?= post('og_job', false, $this->og_job); ?>">

                                <a class="file-fake" onclick="load('panel/select_image', 'field=#og_job', 'preview=#preview_og_job')" style="cursor: pointer;"><i class="fas fa-folder-open"></i>Choose image</a>

                                <div id="preview_og_job" class="preview_image">
                                    <img src="<?= _SITEDIR_ ?>data/og/<?= post('og_job', false, $this->og_job); ?>" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <!-- Og Image -->
                            <label for="image">Blog OG Image<small><i>(Image files must be under <?= file_current_max_size() ?>, and JPG, GIF or PNG format)</i></small></label>
                            <div class="choose-file modern">
                                <input type="hidden" name="og_blog" id="og_blog" value="<?= post('og_blog', false, $this->og_blog); ?>">

                                <a class="file-fake" onclick="load('panel/select_image', 'field=#og_blog', 'preview=#preview_og_blog')" style="cursor: pointer;"><i class="fas fa-folder-open"></i>Choose image</a>

                                <div id="preview_og_blog" class="preview_image">
                                    <img src="<?= _SITEDIR_ ?>data/og/<?= post('og_blog', false, $this->og_blog); ?>" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing sticky-block-bottom">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header widget-bottom">
                        <a class="btn btn-outline-warning" href="{URL:panel}"><i class="fas fa-reply"></i>Back</a>
                        <a class="btn btn-success" onclick="load('panel/settings/social_networks', 'form:#form_box'); return false;"><i class="fas fa-save"></i>Save Changes</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>
