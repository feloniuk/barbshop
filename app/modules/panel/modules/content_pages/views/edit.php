<link href="<?= _SITEDIR_ ?>public/plugins/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css" rel="stylesheet">
<script src="<?= _SITEDIR_ ?>public/plugins/ckeditor/ckeditor.js"></script>
<script src="<?= _SITEDIR_ ?>public/plugins/ckeditor/samples/js/sample.js"></script>

<?php
$name = $this->page_name->content ?: ucfirst(get('page'));

// Get page url
$module = get('module');
$page   = get('page');

if ($module == 'page' && $page == 'index') {
    $url = '/';
} else if ($module != 'page' && $page == 'index') {
    $url = $module;
} else
    $url = $module . '/' . $page;

$routesArray = Route::getList();
foreach ($routesArray as $route) {
    if ($route['action'] == $page && $route['controller'] == $module) {
        if (strpos($route['pattern'], '/([a-z0-9\+\-\.\,_%]{1,250})')) {
            $patternArray = explode('/([a-z0-9\+\-\.\,_%]{1,250})', $route['pattern']);

            if ($patternArray[0])
                $route['pattern'] = $patternArray[0] . '/{slug}';
        }
        $url = str_replace(['^', '?$~si', '~'], '', $route['pattern']);
    }
}

$url = str_replace(['_', '$'], ['-', ''], $url);

$url = removeGetParams($url);
?>
<style>
    .content_box .option__buttons a {
        display: none;
    }
    .content_box:hover .option__buttons a {
        display: block;
    }
</style>

<form id="form_box" action="{URL:panel/content_pages/edit/}?module=<?= get('module'); ?>&page=<?= get('page'); ?>" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing sticky-block-top">
                <div class="statbox widget box box-shadow widget-top">
                    <div class="widget-header">

                        <div class="items_group items_group-wrap">
                            <div class="items_left-side">
                                <div class="title-block">
                                    <a class="btn-ellipse bs-tooltip fa fa-desktop" href="{URL:panel/content_pages}"></a>
                                    <h1 class="page_title"><?= ucfirst(str_replace('_', ' ',get('module'))); ?> » <?= $name ?></h1>
                                </div>
                            </div>

                            <div class="items_right-side">
                                <div class="items_small-block">
                                    <?php if ($page != 'view' && $page != 'banner'){ ?>
                                        <a href="{URL:<?= $url ?>}" class="btn-rectangle bs-tooltip fa fa-eye" title="View Page" target="_blank"></a>
                                    <?php }?>
                                </div>

                                <a class="btn btn-outline-warning" href="{URL:panel/content_pages}"><i class="fas fa-reply"></i>Back</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Page name -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>Page Name <span class="info_text">(Visible only in panel)</span></h4>
                    <div class="form-group mb-0">
                        <input class="form-control" type="text" name="page_name" id="page_name"
                                value="<?= post('page_name', false, $name); ?>">
                    </div>
                </div>
            </div>

            <!-- SEO: Meta title, keywords, description -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>SEO</h4>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="meta_title">
                                Meta Title<a href="https://moz.com/learn/seo/title-tag" target="_blank"><i class="fas fa-info-circle"></i></a>
                            </label>
                            <input class="form-control" type="text" name="meta_title" id="meta_title" value="<?= post('meta_title', false, $this->meta_title->content); ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="meta_keywords">
                                Meta Keywords<a href="https://moz.com/learn/seo/what-are-keywords" target="_blank"><i class="fas fa-info-circle"></i></a>
                            </label>
                            <input class="form-control" type="text" name="meta_keywords" id="meta_keywords" value="<?= post('meta_keywords', false, $this->meta_keywords->content); ?>">
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <label for="meta_desc">
                            Meta Description<a href="https://moz.com/learn/seo/meta-description" target="_blank"><i class="fas fa-info-circle"></i></a>
                        </label>
                        <input class="form-control" type="text" name="meta_desc" id="meta_desc" value="<?= post('meta_desc', false, $this->meta_desc->content); ?>">
                    </div>
                </div>
            </div>

            <!-- Content Blocks -->
            <div class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h4>Content Blocks</h4>

                    <?php
                    $counter = 0;
                    foreach ($this->list as $item) {
                        ?>
                        <div class="content_box">
                            <div class="flex-btw">
                                <div class="flex">
                                    <div class="form-row">
                                        <div class="form-group col-md-6" style="min-width: 300px; width: 30%;">
                                            <label for="<?= $item->name; ?>--alias">Block name <span class="info_text">(Visible only in panel)</span></label>
                                            <input type="text" class="form-control" name="<?= $item->name; ?>--alias" id="<?= $item->name; ?>--alias" value="<?= post($item->name . '--alias', false, $item->alias); ?>" placeholder="<?= $item->name; ?>">
                                        </div>

                                        <?php if ($item->type === 'image' || $item->type === 'picture') { ?>
                                            <div class="form-group col-md-6" style="min-width: 300px; width: 30%;">
                                                <label for="<?= $item->name; ?>--video_type"><strong>Alt attribute</strong></label>
                                                <input type="text" class="form-control" name="<?= $item->name; ?>--video_type" id="<?= $item->name; ?>--video_type" value="<?= post($item->video_type . '--video_type', false, $item->video_type); ?>" placeholder="alt">
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="option__buttons">
                                    <a class="bs-tooltip pointer fa fa-clone copy_btn"
                                       data-clipboard-text="{URL:panel/content_pages/edit}?id=<?= $item->id ?>&module=<?= get('module') ?>&page=<?= get('page') ?>#<?= $item->name ?>--alias"
                                       title="Copy Link"></a>
                                    <a href="{URL:panel/content_pages/delete}?id=<?= $item->id ?>&module=<?= get('module') ?>&page=<?= get('page') ?>"
                                       class="bs-tooltip fa fa-trash-restore-alt" title="Reset Element"></a>
                                </div>
                            </div>

                            <!-- TYPES: -->
                            <?php if ($item->type === 'input') { ?>
                                <!-- Input -->
                                <div class="form-group mb-0">
                                    <label for="<?= $item->name; ?>"><strong>Content</strong></label>
                                    <input type="text" class="form-control" name="<?= $item->name; ?>" id="<?= $item->name; ?>" value="<?= post($item->name, false, $item->content); ?>">
                                </div>
                            <?php } else if ($item->type === 'textarea') { ?>
                                <!-- Textarea -->
                                <div class="form-group mb-0">
                                    <label for="<?= $item->name; ?>"><strong>Content</strong></label>
                                    <textarea name="<?= $item->name; ?>" class="form-control" id="<?= $item->name; ?>" rows="20"><?= post($item->name, false, $item->content); ?></textarea>
                                    <script>
                                        var editorField<?= $counter; ?>;
                                        $(function () {
                                            editorField<?= $counter; ?> = CKEDITOR.replace('<?= $item->name; ?>', {
                                                htmlEncodeOutput: false,
                                                wordcount: {
                                                    showWordCount: true,
                                                    showCharCount: true,
                                                    countSpacesAsChars: true,
                                                    countHTML: false,
                                                },
                                                enterMode: CKEDITOR.ENTER_BR,
                                                removePlugins: 'zsuploader',

                                                filebrowserBrowseUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/browse.php?opener=ckeditor&type=files',
                                                filebrowserImageBrowseUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/browse.php?opener=ckeditor&type=images',
                                                filebrowserUploadUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/upload.php?opener=ckeditor&type=files',
                                                filebrowserImageUploadUrl: '<?= _SITEDIR_ ?>public/plugins/kcfinder/upload.php?opener=ckeditor&type=images'
                                            });
                                        });
                                    </script>
                                </div>
                            <?php } else if ($item->type === 'image' || $item->type === 'picture') { ?>
                                <!-- Image -->
                                <div class="form-row">
                                    <div class="form-group col-md-6 mb-0">
                                        <label for="image">
                                            <strong>Image</strong>
                                            <small><i>(Image files must be under <?= file_current_max_size() ?>, and JPG, GIF or PNG format)</i></small>
                                        </label>

                                        <div class="choose-file modern">
                                            <input type="hidden" name="<?= $item->name ?>" id="<?= $item->name ?>" value="<?= post($item->name, false, $item->content); ?>">
                                            <a class="file-fake" onclick="load('panel/select_image', 'field=#<?= $item->name ?>',  'width=<?= $item->image_width ?>',
                                                    'height=<?= $item->image_height ?>', 'preview=#preview_<?= $item->name ?>'<?php if ($item->type === 'picture') { ?>, 'elem_type=picture' <?php } ?>)" style="cursor: pointer;"><i class="fas fa-folder-open"></i>Choose image</a>
                                            <div id="preview_<?= $item->name ?>" class="preview_image">
                                                <img src="<?= rtrim(_DIR_, '/') . $item->content ?>" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } else if ($item->type === 'video') { ?>
                                <!-- Video -->
                                <?php if ($item->video_type == 'youtube') { ?>
                                    <div class="form-group mb-0">
                                        <label for="<?= $item->name; ?>"><strong>Video Link</strong></label>
                                        <input class="form-control" type="text" name="<?= $item->name; ?>" id="<?= $item->name; ?>" value="<?= post($item->name, false, $item->content); ?>">
                                    </div>
                                <?php } else { ?>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="file">
                                                <strong>Video</strong>
                                                <small>
                                                    <i>(Videos must be under <?= file_current_max_size() ?>, and <?= strtoupper(implode(', ', array_keys(Video::$allowedFormats))) ?> format)</i>
                                                </small>
                                                <?= ($item->content ? '<a href="' . rtrim(_DIR_, '/') . $item->content . '" download><i class="fas fa-download"></i> Download</a>' : '') ?>
                                            </label>
                                            <div class="flex-btw flex-vc" >
                                                <div class="choose-file">
                                                    <input type="hidden" name="<?= $item->name ?>" id="<?= $item->name ?>" value="<?= post($item->name, false,  $item->content ); ?>">
                                                    <input type="file" accept="video/mp4, video/avi, video/mkv" onchange="initFile(this); load('panel/uploadVideo/', 'name=<?= randomHash(); ?>', 'preview=#video_<?= $item->name ?>', 'field=#<?= $item->name ?>');">
                                                    <a class="file-fake"><i class="fas fa-folder-open"></i>Choose file</a>
                                                </div>
                                                <div id="video_<?= $item->name ?>"></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } else if ($item->type === 'file') { ?>
                                <!-- File -->
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="file">
                                                <strong>File</strong>
                                                <small>
                                                    <i>(Files must be under <?= file_current_max_size() ?>, and <?= strtoupper(implode(', ', array_keys(Doc::$allowedFormats))) ?> format)</i>
                                                </small>
                                                <?= ($item->content ? '<a href="' . rtrim(_DIR_, '/') . $item->content . '" download="file.' . File::format($item->content) .'"><i class="fas fa-download"></i> Download</a>' : '') ?>
                                            </label>
                                            <div class="flex-btw flex-vc" >
                                                <div class="choose-file">
                                                    <input type="hidden" name="<?= $item->name ?>" id="<?= $item->name ?>" value="<?= post($item->name, false,  $item->content ); ?>">
                                                    <input type="file" onchange="initFile(this); load('panel/upload/', 'name=<?= randomHash(); ?>', 'preview=#file_<?= $item->name ?>', 'field=#<?= $item->name ?>');">
                                                    <a class="file-fake"><i class="fas fa-folder-open"></i>Choose file</a>
                                                </div>
                                                <div id="file_<?= $item->name ?>"></div>
                                            </div>
                                        </div>
                                    </div>
                            <?php } ?>
                        </div>
                        <?php
                        $counter++;
                    }
                    ?>
                </div>
            </div>


            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing sticky-block-bottom">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header widget-bottom">
                        <a class="btn btn-outline-warning" href="{URL:panel/content_pages}"><i class="fas fa-reply"></i>Back</a>
                        <a class="btn btn-success" onclick="setTextareaValue(); load('panel/content_pages/edit?module=<?= get('module'); ?>&page=<?= get('page'); ?>', 'form:#form_box'); return false;">
                            <i class="fas fa-save"></i>Save Changes
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>


<script>
    function setTextareaValue() {
        <?php
        $counter = 0;
        foreach ($this->list as $item) {
            if ($item->type === 'textarea')
                echo '$("#' . $item->name . '").val(editorField' . $counter . '.getData());';
            $counter++;
        }
        ?>
    }
</script>
