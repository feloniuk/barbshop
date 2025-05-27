<form id="form_box" action="{URL:panel/team/edit/<?= $this->user->id; ?>}" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow widget-top">
                    <div class="widget-header">

                        <div class="items_group items_group-wrap">
                            <div class="items_left-side">
                                <div class="title-block">
                                    <a class="btn-ellipse bs-tooltip fa fa-user-friends" href="{URL:panel/team}"></a>
                                    <h1 class="page_title"><?= $this->user->firstname . ' ' . $this->user->lastname ?></h1>
                                </div>
                            </div>

                            <div class="items_right-side">
                                <div class="items_small-block">
                                </div>

                                <a class="btn btn-outline-warning" href="{URL:panel/team}"><i class="fas fa-reply"></i>Back</a>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

            <!-- General -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>General</h4>

                    <div class="form-row-flex">
                        <div class="form-left-side">
                            <!-- Image -->
                            <div class="form-group">
                                <?= ImageAlts::createField(
                                    'image',
                                    "'panel/select_image', 'field=#image', 'width=330', 'height=430'",
                                    $this->user->image,
                                    _SITEDIR_ . Storage::shardDir('users', $this->user->id),
                                    $this->user->firstname . ' ' . $this->user->lastname
                                ) ?>
                            </div>
                        </div>

                        <div class="form-right-side">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="firstname">First Name</label>
                                    <input class="form-control" type="text" name="firstname" id="firstname" value="<?= post('firstname', false, $this->user->firstname); ?>"><!--required-->
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="lastname">Last Name</label>
                                    <input class="form-control" type="text" name="lastname" id="lastname" value="<?= post('lastname', false, $this->user->lastname); ?>"><!--required-->
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6 form-group-flex">
                                    <label for="email">Email</label>
                                    <input class="form-control" type="email" name="email" id="email" value="<?= post('email', false, $this->user->email); ?>"><!--required-->
                                </div>

                                <div class="form-group col-md-6 form-group-flex">
                                    <label for="password">Password (Leave Empty If Do Not Want to Change)</label>
                                    <input class="form-control" type="password" name="password" id="password" value="<?= post('password', false); ?>">
                                </div>

                                <?php if (Request::getParam('tracker') == 'yes') { ?>
                                    <div class="form-group col-md-6">
                                        <label for="email">Auto-login link: (<i class="fa fa-eye"></i>Visible in test mode only!)</label>
                                        <div class="input-group">
                                            <input class="form-control" id="copy_url" value="<?= SITE_URL ?>panel/login?e=<?= $this->user->email ?>&p=<?= $this->user->password ?>" readonly>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-warning" type="button" onclick="copyToClipboard('copy_url');">Copy</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        <select class="form-control" name="role" id="role" required onchange="toggleServicesBox()">
                                            <option value="admin" <?= checkOptionValue(post('role'), 'admin', $this->user->role); ?>>Admin</option>
                                            <option value="moder" <?= checkOptionValue(post('role'), 'moder', $this->user->role); ?>>Manager</option>
                                            <option value="master" <?= checkOptionValue(post('role'), 'master', $this->user->role); ?>>Master</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input class="form-control" type="text" name="slug" id="slug" value="<?= post('slug', false, $this->user->slug); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6" id="services_box" style="display: none;">
                                    <label>Services</label>
                                    <div class="form-check scroll_max_200 border_1">
                                        <?php if ($this->services) { ?>
                                            <?php foreach ($this->services as $item) { ?>
                                                <div class="custom-control custom-checkbox checkbox-info">
                                                    <input class="custom-control-input" type="checkbox" name="services_ids[]" id="service_<?= $item->id ?>" value="<?= $item->id; ?>"
                                                        <?= checkCheckboxValue(post('services_ids'), $item->id, $this->user->service_ids); ?>><label class="custom-control-label sectors" for="service_<?= $item->id ?>"><?= $item->title ?></label>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group col-md-6" id="shops_box" style="display: none;">
                                    <label>Barber-Shops</label>
                                    <div class="form-check scroll_max_200 border_1">
                                        <?php if ($this->shops) { ?>
                                            <?php foreach ($this->shops as $item) { ?>
                                                <div class="custom-control custom-checkbox checkbox-info">
                                                    <input class="custom-control-input" type="checkbox" name="shops_ids[]" id="shop_<?= $item->id ?>" value="<?= $item->id; ?>"
                                                        <?= checkCheckboxValue(post('shops_ids'), $item->id, $this->user->shop_ids); ?>><label class="custom-control-label sectors" for="shop_<?= $item->id ?>"><?= $item->title ?></label>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>

                                <script>
                                    function toggleServicesBox() {
                                        var roleSelect = document.getElementById("role");
                                        var servicesBox = document.getElementById("services_box");
                                        var shopsBox = document.getElementById("shops_box");
                                        servicesBox.style.display = (roleSelect.value === "master") ? "block" : "none";
                                        shopsBox.style.display = (roleSelect.value === "moder" || roleSelect.value === "master") ? "block" : "none";
                                    }

                                    // Вызываем функцию при загрузке, чтобы учесть предустановленное значение
                                    document.addEventListener("DOMContentLoaded", toggleServicesBox);
                                </script>

                                <?php /*
                                <div class="form-group col-md-6 mb-0">
                                    <label for="name">Is visible on site?</label>
                                    <div class="custom-control custom-checkbox checkbox-info">
                                        <input type="checkbox" class="custom-control-input" name="display_team" id="display_team"  value="yes" <?php if ($this->user->display_team === 'yes') echo 'checked'?>>
                                        <label class="custom-control-label" for="display_team">Display on team page</label>
                                    </div>
                                </div>*/ ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>Details</h4>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="title">Job Title</label>
                            <input class="form-control" type="text" name="job_title" id="job_title" value="<?= post('job_title', false, $this->user->job_title); ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tel">Telephone Number</label>
                            <input class="form-control" type="tel" name="tel" id="tel" value="<?= post('tel', false, $this->user->tel); ?>">
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label for="description">Description</label>
                        <textarea name="description" id="description" rows="20"><?= post('description', false, $this->user->description); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing sticky-block-bottom">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header widget-bottom">
                        <a class="btn btn-outline-warning" href="{URL:panel/team}"><i class="fas fa-reply"></i>Back</a>
                        <a class="btn btn-success" onclick="
                                setTextareaValue();
                                load('panel/team/edit/<?= $this->user->id; ?>', 'form:#form_box'); return false;">
                            <i class="fas fa-save"></i>Save Changes
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>


<link rel="stylesheet" href="<?= _SITEDIR_ ?>public/plugins/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">
<script src="<?= _SITEDIR_ ?>public/plugins/ckeditor/ckeditor.js"></script>
<script src="<?= _SITEDIR_ ?>public/plugins/ckeditor/samples/js/sample.js"></script>

<!-- Connect editor -->
<script>
    var editorField;

    function setTextareaValue() {
        $('#description').val(editorField.getData());
    }

    $(function() {
        $("#firstname, #lastname").keyup(function() {
            initSlug('#slug', '#firstname,#lastname');
        });

        editorField = CKEDITOR.replace('description', {
            htmlEncodeOutput: false,
            wordcount: {
                showWordCount: true,
                showCharCount: true,
                countSpacesAsChars: true,
                countHTML: false,
            },
            removePlugins: 'zsuploader',

            filebrowserBrowseUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/browse.php?opener=ckeditor&type=files',
            filebrowserImageBrowseUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/browse.php?opener=ckeditor&type=images',
            filebrowserUploadUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/upload.php?opener=ckeditor&type=files',
            filebrowserImageUploadUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/upload.php?opener=ckeditor&type=images'
        });
    });
</script>