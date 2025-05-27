<form id="form_box" action="{URL:panel/redirects/edit/<?= $this->testimonial->id; ?>}" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow widget-top">
                    <div class="widget-header">

                        <div class="items_group items_group-wrap">
                            <div class="items_left-side">
                                <div class="title-block">
                                    <a class="btn-ellipse bs-tooltip fa fa-comments-o" href="{URL:panel/redirects}"></a>
                                    <h1 class="page_title">Redirects</h1>
                                </div>
                            </div>

                            <div class="items_right-side hide_block1024">
                                <div class="items_small-block">
                                </div>

                                <a class="btn btn-outline-warning" href="{URL:panel/redirects}"><i class="fas fa-reply"></i>Back</a>
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
                            <label for="uri_from">Uri from</label>
                            <input class="form-control" type="text" name="uri_from" id="uri_from" value="<?= SITE_URL . post('uri_from', false, $this->testimonial->uri_from); ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="uri_to">Uri to</label>
                            <input class="form-control" type="text" name="uri_to" id="uri_to" value="<?=  SITE_URL . post('uri_to', false, $this->testimonial->uri_to); ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing sticky-block-bottom">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header widget-bottom">
                        <a class="btn btn-outline-warning" href="{URL:panel/redirects}"><i class="fas fa-reply"></i>Back</a>
                        <a class="btn btn-success" onclick="
                                load('panel/redirects/edit/<?= $this->testimonial->id; ?>', 'form:#form_box'); return false;">
                            <i class="fas fa-save"></i>Save Changes
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>