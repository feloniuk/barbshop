<form id="form_box" action="{URL:panel/vacancies/add}" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing sticky-block-top">
                <div class="statbox widget box box-shadow widget-top">
                    <div class="widget-header">

                        <div class="items_group items_group-wrap">
                            <div class="items_left-side">
                                <div class="title-block">
                                    <a class="btn-ellipse bs-tooltip fa fa-briefcase" href="{URL:panel/vacancies}"></a>
                                    <h1 class="page_title">Vacancies</a>&nbsp;» Add</h1>
                                </div>
                            </div>

                            <div class="items_right-side">
                                <div class="items_small-block"></div>
                                <a class="btn btn-outline-warning" href="{URL:panel/vacancies}"><i class="fas fa-reply"></i>Back</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Title -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="form-group mb-0">
                        <label for="title">Job Title</label>
                        <input class="form-control" type="text" name="title" id="title" value="<?= post('title', false); ?>">
                    </div>
                </div>
            </div>

            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing sticky-block-bottom">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header widget-bottom">
                        <a class="btn btn-outline-warning" href="{URL:panel/vacancies}"><i class="fas fa-reply"></i>Back</a>
                        <button type="submit" class="btn btn-success" onclick="load('panel/vacancies/add', 'form:#form_box'); return false;">
                            <i class="fas fa-save"></i>Save Changes
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>
