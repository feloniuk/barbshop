<form id="form_box" action="{URL:panel/blog/add_ref}" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <h1 class="page_title"><a href="{URL:panel/blog}">Blog</a>&nbsp;» Statistic Add Referrer</h1>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="form-group">
                        <label for="title">Referrer Title</label>
                        <input class="form-control" type="text" name="title" id="title" value="<?= post('title', false); ?>">
                    </div>
                </div>
            </div>

            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div>
                            <button type="submit" name="submit" class="btn btn-success" onclick="load('panel/blog/add_ref/<?= $this->blog->id ?>', 'form:#form_box'); return false;">Save Changes</button>
                            <a class="btn btn-outline-warning" href="{URL:panel/blog/statistic/<?= $this->blog->id ?>}"><i class="fas fa-ban"></i>Cancel</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>