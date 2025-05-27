<form id="form_box" action="{URL:panel/settings}" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow widget-top">
                    <div class="widget-header">

                        <div class="items_group items_group-wrap">
                            <div class="items_left-side">
                                <div class="title-block">
                                    <a class="btn-ellipse bs-tooltip fa fa-gear"></a>
                                    <h1 class="page_title">Settings</h1>
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


            <!-- Email Settings -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="base_url"><strong>Title prefix</strong></label>
                            <input class="form-control" type="text" name="title_prefix" id="title_prefix"
                                   value="<?= post('title_prefix', false, $this->title_prefix); ?>">
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <!-- Image -->
                            <div class="flex-btw">
                                <label for="cms_logo">CMS Logo<small><i>(Image files must be under <?= file_current_max_size() ?>, and JPG, GIF or PNG format)</i></small></label>
                                <?php if ($this->cms_logo) { ?>
                                    <a onclick="load('panel/settings/remove_setting_img/<?= $this->cms_logo ?>', 'type=cms_logo')" style="color: #f84848; cursor: pointer;">Remove</a>
                                <?php } ?>
                            </div>
                            <div class="choose-file modern">
                                <input type="hidden" name="cms_logo" id="cms_logo" value="<?= post('cms_logo', false, $this->cms_logo); ?>">
                                <a class="file-fake" onclick="load('panel/select_image', 'field=#cms_logo', 'preview=#cms_logo_preview')" style="cursor: pointer;"><i class="fas fa-folder-open"></i>Choose image</a>

                                <div id="cms_logo_preview" class="preview_image">
                                    <?php if ($this->cms_logo) { ?>
                                        <img src="<?= _SITEDIR_ ?>data/setting/<?= post('cms_logo', false, $this->cms_logo); ?>" alt="">
                                    <?php } else { ?>
                                        <img src="<?= _SITEDIR_ ?>assets/img/logo.png" alt="">
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <!-- Image -->
                            <div class="flex-btw">
                                <label for="cms_logo">CMS Login Image<small><i>(Image files must be under <?= file_current_max_size() ?>, and JPG, GIF or PNG format)</i></small></label>
                                <?php if ($this->cms_logo) { ?>
                                    <a onclick="load('panel/settings/remove_setting_img/<?= $this->cms_image ?>', 'type=cms_image')" style="color: #f84848; cursor: pointer;">Remove</a>
                                <?php } ?>
                            </div>
                            <div class="choose-file modern">
                                <input type="hidden" name="cms_image" id="cms_image" value="<?= post('cms_image', false, $this->cms_image); ?>">
                                <a class="file-fake" onclick="load('panel/select_image', 'field=#cms_image', 'preview=#cms_image_preview', 'width=960', 'height=969')" style="cursor: pointer;"><i class="fas fa-folder-open"></i>Choose image</a>

                                <div id="cms_image_preview" class="preview_image">
                                    <?php if ($this->cms_image) { ?>
                                        <img src="<?= _SITEDIR_ ?>data/setting/<?= post('cms_image', false, $this->cms_image); ?>" alt="">
                                    <?php } else { ?>
                                        <img src="<?= _SITEDIR_ ?>assets/img/overview_min.jpg" alt="">
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <!-- Image -->
                            <div class="flex-btw">
                                <label for="favicon">Favicon<small><i>(Image files must be under <?= file_current_max_size() ?>, and JPG, GIF or PNG format)</i></small></label>
                                <?php if ($this->favicon) { ?>
                                    <a onclick="load('panel/settings/remove_setting_img/<?= $this->favicon ?>', 'type=favicon')" style="color: #f84848; cursor: pointer;">Remove</a>
                                <?php } ?>
                            </div>
                            <div class="choose-file modern">
                                <input type="hidden" name="favicon" id="favicon" value="<?= post('favicon', false, $this->favicon); ?>">
                                <div class="file-fake">
                                    <input type="file" onchange="initFile(this); load('panel/upload_ico', 'field=#favicon')" style="cursor: pointer;"><i class="fas fa-folder-open"></i>Choose image
                                </div>

                                <div id="preview_image" class="preview_image">

                                    <?php if ($this->favicon) { ?>
                                        <img src="<?= _SITEDIR_ ?>data/setting/<?= post('image', false, $this->favicon); ?>" alt="">
                                    <?php } else { ?>
                                        <img src="<?= _SITEDIR_ ?>assets/img/favicon.png" alt="">
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email Settings -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>Email Settings</h4>

                    <div class="form-group">
                        <label for="base_url"><strong>Admin email</strong></label>
                        <input class="form-control" type="text" name="admin_mail" id="admin_mail"
                               value="<?= post('admin_mail', false, $this->admin_mail ?: ADMIN_MAIL); ?>">
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 mb-0">
                            <label for="noreply_mail">Noreply email
                                <i class="fas fa-info-circle bs-tooltip" data-original-title="Noreply email - email address from which system messages will be send"></i>
                            </label>
                            <input class="form-control" type="text" name="noreply_mail" id="noreply_mail"
                                   value="<?= post('noreply_mail', false, $this->noreply_mail ?: NOREPLY_MAIL); ?>">
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <label for="noreply_name">Noreply name
                                <i class="fas fa-info-circle bs-tooltip" data-original-title="Noreply name - name of sender 'Noreply email'"></i>
                            </label>
                            <input class="form-control" type="text" name="noreply_name" id="noreply_name"
                                   value="<?= post('noreply_name', false, $this->noreply_name ?: NOREPLY_NAME); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Test mode -->
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>Test Mode</h4>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="test_mode">Turn on "<strong>Test Mode</strong>"?
                                <i class="fas fa-info-circle bs-tooltip" data-original-title="Will send copy of email to tester's email address"></i>
                            </label>
                            <select class="form-control" name="test_mode" id="test_mode">
                                <option value="yes" <?= checkOptionValue(post('test_mode'), 'yes', $this->test_mode) ?>>Yes</option>
                                <option value="no" <?= checkOptionValue(post('test_mode'), 'no', $this->test_mode) ?>>No</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="test_mode_email">Tester's email
                                <i class="fas fa-info-circle bs-tooltip" data-original-title="Write email addresses through of comma"></i>
                            </label>
                            <input class="form-control" type="text" name="test_mode_email" id="test_mode_email"
                                   value="<?= post('test_mode_email', false, $this->test_mode_email) ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 mb-0">
                            <a href="{URL:panel/db}" style="cursor: pointer;">download DB</a>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <a onclick="load('panel/settings/clear_tmp'); return false;" href="#" style="cursor: pointer;">clear tmp folder</a>
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <a href onclick="load('panel/data')" style="cursor: pointer;">download Data Folder</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php /*
            <!-- Tracker -->
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>Bug Tracker</h4>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="tracker">Display "<strong>Report Issue</strong>" button?</label>
                            <select class="form-control" name="tracker" id="tracker">
                                <option value="yes" <?= checkOptionValue(post('tracker'), 'yes', $this->tracker->value); ?>>Yes</option>
                                <option value="no" <?= checkOptionValue(post('tracker'), 'no', $this->tracker->value); ?>>No</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tracker_api">Tracker API key</label>
                            <input class="form-control" type="text" name="tracker_api" id="tracker_api"
                                   value="<?= post('tracker_api', false, $this->tracker_api->value); ?>">
                        </div>
                    </div>

                    <!--                    <div class="code-section-container">-->
                    <!--                        <div class="btn toggle-code-snippet"><span>Info</span></div>-->
                    <!---->
                    <!--                        <div class="code-section text-left">-->
                    <!--                            <div>-->
                    <!--                                <div><span class="darker">Admin email</span> - email address to which will go emails</div>-->
                    <!--                                <div><span class="darker">Noreply email</span> - email address from which system messages will be send</div>-->
                    <!--                                <div><span class="darker">Noreply name</span> - name of sender "Noreply email"</div>-->
                    <!--                            </div>-->
                    <!--                        </div>-->
                    <!--                    </div>-->
                </div>
            </div>
            */ ?>

            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing sticky-block-bottom">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header widget-bottom">
                        <a class="btn btn-outline-warning" href="{URL:panel}"><i class="fas fa-reply"></i>Back</a>
                        <a class="btn btn-success" onclick="load('panel/settings', 'form:#form_box'); return false;">
                            <i class="fas fa-save"></i>Save Changes
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

