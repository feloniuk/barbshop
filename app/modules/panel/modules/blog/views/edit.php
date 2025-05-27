<form id="form_box" action="{URL:panel/blog/edit/<?= $this->blog->id; ?>}" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">

            <?php /*
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
            <div class="flex-btw">

                <div class="breadcrumb-four">
                    <ul class="breadcrumb">
                        <li class="active">
                            <a href="{URL:panel/blog}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rss"><path d="M4 11a9 9 0 0 1 9 9"></path><path d="M4 4a16 16 0 0 1 16 16"></path><circle cx="5" cy="19" r="1"></circle></svg>
                                Blog Posts
                            </a>
                        </li>
                        <li>
                            Edit
                        </li>
                        <li>
                            <?= $this->blog->title; ?>
                        </li>
                    </ul>
                </div>

                <div class="option__buttons">
                    <a href="{URL:blog/<?= $this->blog->slug; ?>}" class="bs-tooltip fa fa-eye" title="View Blog" target="_blank"></a>
                    <a href="{URL:panel/blog/statistic/<?= $this->blog->id; ?>}" class="bs-tooltip fa fa-chart-bar" title="Statistic"></a>
                </div>
            </div>
            </div>
            */ ?>

            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow widget-top">
                    <div class="widget-header">

                        <div class="items_group items_group-wrap">
                            <div class="items_left-side">
                                <div class="title-block">
                                    <a class="btn-ellipse bs-tooltip fas fa-rss" href="{URL:panel/blog}"></a>
                                    <h1 class="page_title"><?= $this->blog->title ?></h1>
                                </div>
                            </div>

                            <div class="items_right-side">
                                <div class="items_small-block">
                                    <a href="{URL:blog/<?= $this->blog->slug; ?>}" class="btn-rectangle bs-tooltip fa fa-eye" title="View Blog" target="_blank"></a>

                                    <div class="social-btns-list">
                                        <a onclick="share_linkedin(this);" class="btn-social" href="#" data-url="{URL:blog/<?= $this->blog->slug; ?>}">
                                            <i class="fa fa-linkedin"></i>
                                        </a>
                                        <a onclick="share_facebook(this);" class="btn-social" href="#" data-url="{URL:blog/<?= $this->blog->slug; ?>}">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                        <a onclick="share_twitter(this);" class="btn-social" href="#" data-url="{URL:blog/<?= $this->blog->slug; ?>}">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                        <a class="btn-social copy_btn" href="#" data-clipboard-text="{URL:blog/<?= $this->blog->slug; ?>}">
                                            <i class="fa fa-copy"></i>
                                        </a>
                                    </div>
                                </div>

                                <a class="btn btn-outline-warning" href="{URL:panel/blog}"><i class="fas fa-reply"></i>Back</a>
                            </div>
                        </div>

                        <div class="items_group items_group-wrap items_group-bottom">
                            <div class="items_left-side">
                                <div class="option-btns-list scroll-list">
                                    <a class="btn btn-rectangle_medium active"><i class="bs-tooltip fa fa-pencil-alt"></i>Edit</a>
                                    <a href="{URL:panel/blog/statistic/<?= $this->blog->id; ?>}" class="btn btn-rectangle_medium" title="Statistic"><i class="bs-tooltip fa fa-chart-bar"></i>Statistic</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- General -->
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>General</h4>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <div class="form-group">
                                <label for="title">Blog Title</label>
                                <input type="text" class="form-control" name="title" id="title" value="<?= post('title', false, $this->blog->title); ?>">
                            </div>
                            <?php /*
                            <div class="form-group">
                                <label for="subtitle">Subtitle</label>
                                <input type="text" class="form-control" name="subtitle" id="subtitle" value="<?= post('subtitle', false, $this->blog->subtitle); ?>">
                            </div>
                            */ ?>
                            <div class="form-group">
                                <label for="sector">Category</label>
                                <select class="form-control" name="sector" id="sector" required>
                                    <?php if (isset($this->sectors) && is_array($this->sectors) && count($this->sectors) > 0) { ?>
                                        <?php foreach ($this->sectors as $item) { ?>
                                            <option value="<?= $item->id; ?>" <?= checkOptionValue(post('function_ids'), $item->id, $this->blog->sector); ?>><?= $item->name; ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <?= ImageAlts::createField(
                                'image',
                                "'panel/select_image', 'field=#image', 'width=680', 'height=280'",
                                $this->blog->image,
                                _SITEDIR_ . Storage::shardDir('blog', $this->blog->id),
                                $this->blog->alt_attributes['image']
                            ) ?>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 mb-0">
                            <label for="time">Date Published</label>
                            <input class="form-control" type="text" name="time" id="time" value="<?= post('time', false, date("d/m/Y", $this->blog->time ? $this->blog->time : time())); ?>">
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <label for="posted">Published</label>
                            <select class="form-control" name="posted" id="posted" required>
                                <option value="yes" <?= checkOptionValue(post('posted'), 'yes', $this->blog->posted); ?>>Yes</option>
                                <option value="no" <?= checkOptionValue(post('posted'), 'no', $this->blog->posted); ?>>No</option>
                            </select>
                        </div>
                    </div>

                    <?php /*
                    <!-- Checkbox -->
                    <div class="form-group">
                        <div class="form-check pl-0">
                            <div class="custom-control custom-checkbox checkbox-info">
                                <input type="checkbox" class="custom-control-input" id="gridCheck">
                                <label class="custom-control-label" for="gridCheck">Check me out</label>
                            </div>
                        </div>
                    </div>

                    <div class="code-section-container">
                        <button class="btn toggle-code-snippet"><span>Info</span></button>

                        <div class="code-section text-left">
                            <pre>
                                Some notes...
                            </pre>
                        </div>
                    </div>
                    */ ?>
                </div>
            </div>

            <!-- Content -->
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>Content</h4>
                    <div class="form-group mb-0">
                        <textarea class="form-control" name="content" id="text_content" rows="20"><?= post('content', false, $this->blog->content); ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Author -->
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>Author</h4>
                    <div class="form-group mb-0">
                        <select class="form-control" name="consultant_id" id="consultant_id" required>
                            <?php if (isset($this->team) && is_array($this->team) && count($this->team) > 0) { ?>
                                <?php foreach ($this->team as $member) { ?>
                                    <?php if (!$this->blog->consultant_id) { ?>
                                        <option value="<?= $member->id; ?>" <?= checkOptionValue(post('consultant_id'), $member->id, User::get('id')); ?>><?= $member->firstname . ' ' . $member->lastname; ?></option>
                                    <?php } else { ?>
                                        <option value="<?= $member->id; ?>" <?= checkOptionValue(post('consultant_id'), $member->id, $this->blog->consultant_id); ?>><?= $member->firstname . ' ' . $member->lastname; ?></option>
                                    <?php }
                                } ?>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- SEO -->
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>On-page SEO</h4>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="meta_title">
                                Meta Title<a href="https://moz.com/learn/seo/title-tag" target="_blank"><i class="fas fa-info-circle"></i></a>
                            </label>
                            <input class="form-control" type="text" name="meta_title" id="meta_title" value="<?= post('meta_title', false, $this->blog->meta_title); ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="meta_keywords">
                                Meta Keywords<a href="https://moz.com/learn/seo/what-are-keywords" target="_blank"><i class="fas fa-info-circle"></i></a>
                            </label>
                            <input class="form-control" type="text" name="meta_keywords" id="meta_keywords" value="<?= post('meta_keywords', false, $this->blog->meta_keywords); ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6 mb-0">
                            <label for="meta_desc">
                                Meta Description<a href="https://moz.com/learn/seo/meta-description" target="_blank"><i class="fas fa-info-circle"></i></a>
                            </label>
                            <input class="form-control" type="text" name="meta_desc" id="meta_desc" value="<?= post('meta_desc', false, $this->blog->meta_desc); ?>">
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <label for="slug">
                                URL Slug<a href="https://moz.com/blog/15-seo-best-practices-for-structuring-urls" target="_blank"><i class="fas fa-info-circle"></i></a>
                                &nbsp;&nbsp;{URL:blog}/<?= $this->blog->slug; ?>
                            </label>
                            <input class="form-control" type="text" name="slug" id="slug" value="<?= $this->blog->slug; ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing sticky-block-bottom">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header widget-bottom">
                        <a class="btn btn-outline-warning" href="{URL:panel/blog}"><i class="fas fa-reply"></i>Back</a>
                        <a class="btn btn-success" onclick="
                                setTextareaValue();
                                load('panel/blog/edit/<?= $this->blog->id; ?>', 'form:#form_box'); return false;">
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
        $('#text_content').val(editorField.getData());
    }

    $(function () {
        $('#time').datepicker({dateFormat: 'dd/mm/yy'});

        editorField = CKEDITOR.replace('text_content', {
            htmlEncodeOutput: false,
            wordcount: {
                showWordCount: true,
                showCharCount: true,
                countSpacesAsChars: true,
                countHTML: true,
            },
            // enterMode: CKEDITOR.ENTER_BR, // to remove <p>
            // removePlugins: 'zsuploader',

            filebrowserBrowseUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/browse.php?opener=ckeditor&type=files',
            filebrowserImageBrowseUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/browse.php?opener=ckeditor&type=images',
            filebrowserUploadUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/upload.php?opener=ckeditor&type=files',
            filebrowserImageUploadUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/upload.php?opener=ckeditor&type=images'
        });
    });
</script>