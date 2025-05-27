<?php Popup::head('Crop Image', 'old-popup-styles full-height'); ?>

<div style="width: <?= $this->CROP_BLOCK_W ?>px; height: <?= $this->CROP_BLOCK_H ?>px;" id="crop_image">
    <img id="target" src="<?= _SITEDIR_ ?>data/<?= $this->select_image ? $this->path : $this->lastUploadedPath ?>/<?= $this->imagename . '?t=' . randomHash() ?>" alt="" width="<?= $this->CROP_BLOCK_W ?>px" height="<?= $this->CROP_BLOCK_H ?>px">
</div>

<div class="solo_test"></div>

<form id="image_form" class="pop_form" style="margin-top: 24px;">
    <div class="flex-start">
        <div class="coords">
            <div>
                <label>Left corner X:</label>
                <input class="form-control" type="number" name="x1" id="x1" value="0" style="width: 100px;"/></br>
            </div>
            <div>
                <label>Left corner Y:</label>
                <input class="form-control" type="number" name="y1" id="y1" value="0" style="width: 100px;"/><br/>
            </div>
            <div>
                <label>Width:</label>
                <input class="form-control" type="number" name="w"  id="w" value="0" style="width: 100px;"/><br/>
            </div>
            <div>
                <label>Height:</label>
                <input class="form-control" type="number" name="h" id="h" value="0" style="width: 100px;"/><br/>
            </div>
        </div>

<!--            <div class="flex-vc" style="margin-right: 12px;">-->
<!--                <input type="checkbox" id="con"> <i class="fas fa-lock" title=""></i><br/>-->
<!--            </div>-->
    </div>

    <div style="max-width: 440px">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="quality">Format:</label>
                <select class="form-control" name="format" id="format">
                    <option value="jpg" <?= $this->format == 'jpg' ? 'selected' : '' ?>>jpeg</option>
                    <option value="png" <?= $this->format == 'png' ? 'selected' : '' ?>>png</option>
                    <?php /*
                    <option value="webp" <?= $this->format == 'webp' ? 'selected' : '' ?>>webp</option>
                    */ ?>
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="quality">Quality:</label>
                <select class="form-control" name="quality" id="quality">
                    <option value="10">10%</option>
                    <option value="20">20%</option>
                    <option value="30">30%</option>
                    <option value="40">40%</option>
                    <option value="50">50%</option>
                    <option value="60">60%</option>
                    <option value="70">70%</option>
                    <option value="80">80%</option>
                    <option value="90" selected>90%</option>
                    <option value="100">100%</option>
                </select>
            </div>
        </div>
    </div>

    <a class="btn btn-success" onclick="addSpinnerIMG(this); load('panel/crop', 'name=<?=  $this->imagename; ?>', 'form:#image_form',
            'preview=<?= $this->preview ?>', 'field=<?= $this->field ?>', 'path=<?= $this->select_image ? $this->path : $this->lastUploadedPath ?>',
            'image_from=<?= $this->image_from ?>'); return false;">
        <i class="fas fa-crop-alt"></i>Crop
    </a>
</form>

<?php Popup::foot(); ?>
<?php Popup::closeListener(); ?>

<script>
    $(document).ready(function () {
        var jcrop;
        let x1 = document.querySelector('input[name=x1]');
        let y1 = document.querySelector('input[name=y1]');
        let w = document.querySelector('input[name=w]');
        let h = document.querySelector('input[name=h]');


        x1.addEventListener('change', function () {
            jQuery(function($) {
                jcrop = $('#target').Jcrop({
                    // onSelect: showCoords,
                    setSelect: [Number(x1.value), Number(y1.value), Number(x1.value) + Number(w.value), Number(y1.value) + Number(h.value)]
                });
            });
        })

        y1.addEventListener('change', function () {
            jQuery(function($) {
                jcrop = $('#target').Jcrop({
                    // onSelect: showCoords,
                    setSelect: [Number(x1.value), Number(y1.value), Number(x1.value) + Number(w.value), Number(y1.value) + Number(h.value)]
                });
            });
        })


        w.addEventListener('change', function () {
            let checkCon = document.querySelector('#con:checked');

            if (checkCon !== null) {
                let h = document.querySelector('input[name=h]').value;
                document.querySelector('input[name=h]').value = Number(h) - (Number(wOld) -  Number(w.value));
                wOld = document.querySelector('input[name=w]').value;
            }

            jQuery(function($) {
                jcrop = $('#target').Jcrop({
                    // onSelect: showCoords,
                    setSelect: [Number(x1.value), Number(y1.value), Number(x1.value) + Number(w.value), Number(y1.value) + Number(h.value)]
                });
            });
        })

        h.addEventListener('change', function () {
            let checkCon = document.querySelector('#con:checked');

            if (checkCon !== null) {
                let w = document.querySelector('input[name=w]').value;
                document.querySelector('input[name=w]').value = Number(w) - (Number(hOld) -  Number(h.value));
                hOld = document.querySelector('input[name=h]').value;
            }

            jQuery(function($) {
                jcrop = $('#target').Jcrop({
                    // onSelect: showCoords,
                    setSelect: [Number(x1.value), Number(y1.value), Number(x1.value) + Number(w.value), Number(y1.value) + Number(h.value)]
                });
            });
        })


        let wOld = document.querySelector('input[name=w]').value;
        let hOld = document.querySelector('input[name=h]').value;


        //-------------------------------------------//


        function showCoords(c) {
            // variables can be accessed here as
            // c.x, c.y, c.x2, c.y2, c.w, c.h
            $('input[name=x1]').val(c.x);
            $('input[name=y1]').val(c.y);
            $('input[name=w]').val(c.w);
            $('input[name=h]').val(c.h);

            wOld = document.querySelector('input[name=w]').value;
            hOld = document.querySelector('input[name=h]').value;
        }

        jQuery(function($) {
            let x = Number('<?= $this->default_x ?>');
            let y = Number('<?= $this->default_y ?>');
            let w = x + Number('<?= $this->width ?>');
            let h = y + Number('<?= $this->height ?>');

            console.log(x);
            console.log(y);
            console.log(w);
            console.log(h);

            jcrop = $('#target').Jcrop({
                setSelect: [x, y, w, h],// you have set proper x and y coordinates here
                onSelect: showCoords,
                <?php if ($this->ratio) { ?>
                    aspectRatio: <?= $this->ratio ?>,
                <?php } ?>
                // minSize: [100, 100],
                // maxSize: [200, 200],
                // allowResize: false,
            });
        });

    })
</script>
