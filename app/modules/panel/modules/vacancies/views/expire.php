<form id="form_box" action="{URL:panel/vacancies/expire/<?= $this->edit->id; ?>}" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <h1 class="page_title"><a href="{URL:panel/vacancies}">Vacancy</a>&nbsp;» Reason</h1>
                    </div>
                </div>
            </div>

            <!-- Reason -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="form-group">
                        <label for="reason">Reason</label>
                        <input class="form-control" type="text" name="reason" id="reason" value="<?= post('reason')?>">
                    </div>
                </div>
            </div>

            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div>
                            <button type="submit" name="submit" class="btn btn-primary mt-3" onclick="load('panel/vacancies/expire/<?= $this->edit->id; ?>', 'form:#form_box'); return false;"><i class="fas fa-save"></i>Save Changes</button>
                            <a class="btn btn-outline-warning mt-3" href="{URL:panel/vacancies}"><i class="fas fa-ban"></i>Cancel</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>





