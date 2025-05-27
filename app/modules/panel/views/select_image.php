<?php Popup::head('ADD IMAGE', 'old-popup-styles full-height'); ?>

<form id="image_form" class="pop_form" style="margin-top: 24px; width: 100%; max-width: 502px">
    <div class="file_img_block">
        <input id="files" type="file" accept="image/jpeg,image/png,image/gif" onchange="initFile(this); addSpinnerIMG(this, true); load('panel/upload_image_crop/',
                'field=<?= $this->field ?>', 'width=<?= $this->width ?>', 'height=<?= $this->height ?>', 'select_image=true',
                'preview=<?= $this->preview ?>');">
        <div class="file_img_btn"><span class="fa fa-paperclip"></span> Choose the file or Ctrl + V to paste...</div>
    </div>

    <h4>or select file from uploaded</h4>
    <div class="img_grid_block">
        <?php if (is_array($this->images) && count($this->images) > 0) { ?>
            <?php foreach ($this->images as $item) { ?>
                <div>
                    <div class="igb-pic" style="background-image: url('<?= _SITEDIR_ ?>data/last_uploaded_images/mini_<?= $item->image ?>')"
                         onclick="addSpinnerIMG(this); load('panel/upload_image_crop/', 'name=<?= $item->image ?>', 'field=<?= $this->field ?>',
                                 'width=<?= $this->width ?>', 'height=<?= $this->height ?>', 'preview=<?= $this->preview ?>', 'type=image_from_last');"></div>
                    <span class="img_del" onclick="load('panel/remove_select_image/<?= $item->id ?>', 'name=<?= $item->image ?>', 'field=<?= $this->field ?>',
                            'width=<?= $this->width ?>', 'height=<?= $this->height ?>'); return false;"><span class="fa fa-times-circle-o"></span></span>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</form>

<script>
    $(document).ready(function($){
        // Paste Ctrl + V
        let fileInput = document.getElementById("files");

        document.getElementById('site').addEventListener('paste', e => {
            console.log('paste');
            console.log(e.clipboardData.files);

            if (e.clipboardData.files.length) {
                fileInput.files = e.clipboardData.files;
                load('panel/upload_image_crop/',
                    'field=<?= $this->field ?>', 'width=<?= $this->width ?>', 'height=<?= $this->height ?>', 'select_image=true',
                    'preview=<?= $this->preview ?>');
            }
        });
    });
</script>

<?php Popup::foot(); ?>
<?php Popup::closeListener(); ?>
