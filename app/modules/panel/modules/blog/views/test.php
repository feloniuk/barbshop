<form id="form_box" action="{URL:panel/blog/edit/<?= $this->blog->id; ?>}" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <h1 class="page_title"><a href="{URL:panel/blog}">Blog</a>&nbsp;» Edit</h1>
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
                            <!-- Image -->
                            <label for="image">Image<small><i>(Image files must be under <?= file_current_max_size() ?>, and JPG, GIF or PNG format)</i></small></label>
                            <div class="choose-file modern">
                                <input type="hidden" name="image" id="image" value="<?= post('image', false, $this->blog->image); ?>">
                                <a class="file-fake" onclick="load('panel/select_image', 'field=#image', 'width=600', 'height=400')" style="cursor: pointer;"><i class="fas fa-folder-open"></i>Choose image</a>

                                <div id="preview_image" class="preview_image">
                                    <img src="<?= _SITEDIR_ ?>data/blog/<?= post('image', false, $this->blog->image); ?>" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="time">Date Published</label>
                            <input class="form-control" type="text" name="time" id="time" value="<?= post('time', false, date("d/m/Y", $this->blog->time ? $this->blog->time : time())); ?>">
                        </div>
                        <div class="form-group col-md-6">
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

            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>Author</h4>
                    <div class="form-group">
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
                        <div class="form-group col-md-6">
                            <label for="meta_desc">
                                Meta Description<a href="https://moz.com/learn/seo/meta-description" target="_blank"><i class="fas fa-info-circle"></i></a>
                            </label>
                            <input class="form-control" type="text" name="meta_desc" id="meta_desc" value="<?= post('meta_desc', false, $this->blog->meta_desc); ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="slug">
                                URL Slug<a href="https://moz.com/blog/15-seo-best-practices-for-structuring-urls" target="_blank"><i class="fas fa-info-circle"></i></a>
                                &nbsp;&nbsp;{URL:blog}/<?= $this->blog->slug; ?>
                            </label>
                            <input class="form-control" type="text" name="slug" id="slug" value="<?= $this->blog->slug; ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>Content</h4>

                    <div class="form-group">
                        <textarea id="text_content" name="content"><?= $this->blog->content ?></textarea>
                    </div>
                </div>
            </div>

            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div>
                            <a class="btn btn-success" onclick="
                                    setTextareaValue();
                                    load('panel/blog/test/<?= $this->blog->id; ?>', 'form:#form_box'); return false;">
                                <i class="fas fa-save"></i>Save Changes
                            </a>
                            <a class="btn btn-outline-warning" href="{URL:panel/blog}"><i class="fas fa-ban"></i>Cancel</a>
                            <a class="btn btn-dark" href="{URL:blog}/<?= $this->blog->slug; ?>" target="_blank"><i class="fas fa-eye"></i>View Blog</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

<script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
<!-- Connect editor -->
<script>

    var editorField;

    function setTextareaValue() {
        $('#text_content').val(editorField.getData());
    }

    $(function () {
        $('#time').datepicker({dateFormat: 'dd/mm/yy'});

        editorField =  ClassicEditor.create( document.querySelector('#text_content' )).then( newEditor => {
            editorField = newEditor;
        } )
    });
</script>