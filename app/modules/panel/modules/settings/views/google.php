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
                                    <a class="btn-ellipse bs-tooltip fa fa-google"></a>
                                    <h1 class="page_title">Google Settings</h1>
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

            <!-- Google Maps -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>Google Maps</h4>

                    <div class="form-group mb-0">
                        <label for="maps_api_key">
                            API Key <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">Obtain</a>
                        </label>
                        <input class="form-control" type="text" name="maps_api_key" id="maps_api_key" value="<?= post('maps_api_key', false, $this->maps_api_key); ?>" required>
                    </div>
                </div>
            </div>

            <!-- reCaptcha -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>reCaptcha</h4>

                    <div class="form-group">
                        <label for="site_key">
                            reCaptcha Site Key <a href="https://developers.google.com/recaptcha/intro" target="_blank">Obtain</a>
                        </label>
                        <input class="form-control" type="text" name="site_key" id="site_key" value="<?= post('site_key', false, $this->site_key); ?>" required>
                    </div>

                    <div class="form-group mb-0">
                        <label for="recaptcha_key">
                            reCaptcha Secret Key <a href="https://developers.google.com/recaptcha/intro" target="_blank">Obtain</a>
                        </label>
                        <input class="form-control" type="text" name="recaptcha_key" id="recaptcha_key" value="<?= post('recaptcha_key', false, $this->recaptcha_key); ?>" required>
                    </div>
                </div>
            </div>

            <!-- Google Analytics -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>Google Analytics</h4>

                    <div class="form-group">
                        <label for="view_id">
                            View ID <a href="https://ga-dev-tools.appspot.com/account-explorer/" target="_blank">Obtain</a>
                        </label>
                        <input class="form-control" type="text" name="view_id" id="view_id" value="<?= post('view_id', false, $this->view_id); ?>" required>
                    </div>

                    <div class="form-group mb-0">
                        <label for="credentials_json">
                            Credentials JSON
                            <a href="https://developers.google.com/analytics/devguides/reporting/core/v4/quickstart/service-php" target="_blank">Instructions</a>
                        </label>
                        <textarea class="form-control" name="credentials_json" id="credentials_json" required style="width: 100%" rows="14"><?= post('credentials_json', false, $this->credentials_json); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing sticky-block-bottom">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header widget-bottom">
                        <a class="btn btn-outline-warning" href="{URL:panel}"><i class="fas fa-reply"></i>Back</a>
                        <a class="btn btn-success" onclick="load('panel/settings/google', 'form:#form_box'); return false;"><i class="fas fa-save"></i>Save Changes</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>