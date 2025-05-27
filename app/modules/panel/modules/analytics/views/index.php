<?php /*
<form id="form_box" action="{URL:panel/analytics}" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <h1 class="page_title">Google Analytics</h1>
                    </div>
                </div>
            </div>

            <!-- General -->
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>System Configuration</h4>

                    <div class="form-group">
                        <label for="view_id">
                            View ID <a href="https://ga-dev-tools.appspot.com/account-explorer/" target="_blank">Obtain</a>
                        </label>
                        <input class="form-control" type="text" name="view_id" id="view_id" value="<?= post('view_id', false, $this->view_id->value); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="credentials_json">
                            Credentials JSON
                            <a href="https://developers.google.com/analytics/devguides/reporting/core/v4/quickstart/service-php" target="_blank">Instructions</a>
                        </label>
                        <textarea class="form-control" name="credentials_json" id="credentials_json" required style="width: 100%" rows="20"><?= post('credentials_json', false, reFilter($this->credentials_json->value)); ?></textarea>
                    </div>
                </div>
            </div>


            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div>
                            <a class="btn btn-success" onclick="load('panel/analytics', 'form:#form_box'); return false;"><i class="fas fa-save"></i>Save Changes</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

*/ ?>