<?php Popup::head('EDIT', 'old-popup-styles full-height'); ?>

<form id="popup_form" class="pop_form" style="margin-top: 24px;">
    <div class="flex-start">
        <div class="form-group col-md-6">
            <label>Version</label>
            <input class="form-control" type="text" name="version" id="version" value="<?= $this->edit->version ?>" /></br>
        </div>

        <div class="form-group col-md-6">
            <label>Visible</label>
            <select class="form-control" name="visible">
                <option value="yes" <?= checkOptionValue(post('visible'), 'yes', $this->edit->visible); ?>>YES</option>
                <option value="no" <?= checkOptionValue(post('visible'), 'no', $this->edit->visible); ?>>No</option>
            </select>
        </div>
    </div>

    <a class="btn btn-success" onclick="load('panel/modules_edit/<?= $this->edit->id ?>', 'form:#popup_form'); return false;" style="cursor: pointer;">Save</a>
</form>

<?php Popup::foot(); ?>
<?php Popup::closeListener(); ?>