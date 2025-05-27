<form id="form_box" action="{URL:panel/analytics/include_code}" method="post" enctype="multipart/form-data">
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
                                    <h1 class="page_title">Include Code</h1>
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
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="form-group">
                        <label for="include_code">Header / Top</label>
                        <textarea class="form-control" name="include_code_top" id="include_code_top" required style="width: 100%" rows="20"><?= post('include_code_top', false, reFilter($this->include_code_top)); ?></textarea>
                    </div>

                    <div class="form-group mb-0">
                        <label for="include_code">Footer / Bottom</label>
                        <textarea class="form-control" name="include_code_bottom" id="include_code_bottom" required style="width: 100%" rows="20"><?= post('include_code_bottom', false, reFilter($this->include_code_bottom)); ?></textarea>
                    </div>
                </div>
            </div>


            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing sticky-block-bottom">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header widget-bottom">
                        <a class="btn btn-outline-warning" href="{URL:panel}"><i class="fas fa-reply"></i>Back</a>
                        <a class="btn btn-success" onclick="load('panel/analytics/include_code', 'form:#form_box'); return false;"><i class="fas fa-save"></i>Save Changes</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>