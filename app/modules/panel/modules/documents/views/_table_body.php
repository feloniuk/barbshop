<?php if ($this->list) { ?>
    <?php foreach ($this->list as $item) { ?>
        <tr id="item_<?= $item->id; ?>" class="tr-hovered">
            <td class="mini_mize max_w_60" title="<?= $item->id; ?>">
                <?= $item->id; ?>
            </td>
            <td>
                <a href="{URL:panel/documents/edit/<?= $item->id; ?>}"><?= $item->title; ?></a>
            </td>
            <td data-sort="<?= $item->time ?>">
                <?= date('Y-m-d', $item->time); ?>
            </td>
            <td>
                <div class="items-row align-items-center">
                    <div class="dropdown dropup custom-dropdown-icon">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                            <a href="{URL:panel/documents/edit/<?= $item->id; ?>}" class="dropdown-item"><i class="fa fa-pencil-alt"></i> Edit</a>
                            <a @click="load('panel/documents/delete/<?= $item->id; ?>');" class="dropdown-item remove-item"><i class="fa fa-trash-alt"></i>Delete</a>
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
