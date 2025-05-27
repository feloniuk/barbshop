<?php if ($this->list) { ?>
    <?php foreach ($this->list as $item) { ?>
        <tr class="tr-hovered">
            <td>
                <?php echo $item->id; ?>
            </td>
            <td>
                <a href="{URL:panel/uploads/edit/<?= $item->id ?>}"><?= $item->name; ?></a>
            </td>
            <td>
                <div class="items-row align-items-center">
                    <div class="dropdown dropup custom-dropdown-icon">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                            <a class="dropdown-item copy_btn" href="#" data-clipboard-text="{URL:uploads/<?= $item->slug; ?>}"><i class="fa fa-copy"></i>Copy Link</a>
                            <a href="{URL:uploads/<?= $item->slug; ?>}" class="dropdown-item" target="_blank"><i class="fa fa-eye"></i>View</a>
                            <a href="{URL:panel/uploads/edit/<?= $item->id; ?>}" class="dropdown-item"><i class="fa fa-pencil-alt"></i> Edit</a>
                            <a href="{URL:panel/uploads/delete/<?= $item->id; ?>}" class="dropdown-item remove-item"><i class="fa fa-trash-alt"></i> Delete</a>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    <?php } ?>

    <script>
        $(() => reInitConfirmation());
    </script>
<?php } ?>
