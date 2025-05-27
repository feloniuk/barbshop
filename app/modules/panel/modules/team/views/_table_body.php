<?php if ($this->list) { ?>
    <?php foreach ($this->list as $item) { ?>
        <tr id="item_<?= $item->id; ?>" class="tr-hovered">
            <td class="mini_mize max_w_60" title="<?= $item->id; ?>">
                <?= $item->id; ?>
            </td>
            <td>
                <div class="items-row">
                    <div class="item-block mr6">
                        <?= $item->sort; ?>
                    </div>

                    <div class="btns-list ml-auto">
                        <a onclick="load('panel/team/sort/up/<?= $item->id; ?>');" class="sort-arrow pointer"><i class="fa fa-arrow-up"></i></a>
                        <a onclick="load('panel/team/sort/down/<?= $item->id; ?>');" class="sort-arrow pointer"><i class="fa fa-arrow-down"></i></a>
                    </div>
                </div>
            </td>
            <td>
                <div class="avatar avatar-sm avatar-indicators <?= ($item->last_time > (time() - 600) ? 'avatar-online' : 'avatar-offline') ?>">
                    <?php if (FileBase::exist(_SYSDIR_ . Storage::shardDir('users', $item->id) . 'mini_' . $item->image)) { ?>
                        <img alt="avatar" src="<?= Storage::get('mini_' . $item->image, 'users', $item->id) ?>" class="rounded-circle" />
                    <?php } else { ?>
                        <img alt="avatar" src="<?= _SITEDIR_ ?>assets/img/90x90.jpg" class="rounded-circle" />
                    <?php } ?>
                </div>&nbsp;
                <a href="{URL:panel/team/edit/<?= $item->id ?>}"><?= $item->firstname . ' ' . $item->lastname ?></a>
            </td>
            <td>
                <?= $item->email; ?>
            </td>
            <td>
                <?= str_replace(['moder', 'master'], ['manager', 'barber'], $item->role); ?>
            </td>
            <?php if(!User::checkRole('moder')) { ?>
            <td>
                <div class="items-row align-items-center">
                    <div class="dropdown dropup custom-dropdown-icon">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                            <a href="{URL:panel/team/edit/<?= $item->id; ?>}" class="dropdown-item"><i class="fa fa-pencil-alt"></i> Edit</a>
                            <?php if (User::get('id') !== $item->id) { ?>
                                <a @click="load('panel/team/to_archive/<?= $item->id; ?>');" class="dropdown-item remove-item"><i class="fa fa-trash-alt"></i>Archive</a>
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </td>
            <?php } ?>
        </tr>
    <?php } ?>
        <script>
            $(() => reInitConfirmation());
        </script>
<?php } ?>
