<form id="form_box" action="{URL:panel/redirects/add}" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <h1 class="page_title"><a href="{URL:panel/redirects}">Redirects</a>&nbsp;» Add</h1>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="uri_from">Uri from</label>
                            <input class="form-control" type="text" name="uri_from" id="uri_from" value="<?= post('uri_from', false); ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="uri_to">Uri to</label>
                            <input class="form-control" type="text" name="uri_to" id="uri_to" value="<?= post('uri_to', false); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div>
                            <button type="submit" name="submit" class="btn btn-success" onclick="load('panel/redirects/add', 'form:#form_box'); return false;"><i class="fas fa-save"></i>Save Changes</button>
                            <a class="btn btn-outline-warning" href="{URL:panel/redirects}"><i class="fas fa-ban"></i>Cancel</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>
