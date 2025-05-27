<?php if ($this->vacancies) { ?>
    <?php foreach ($this->vacancies as $item) { ?>
        <tr>
            <td class="max_w_80" title="#<?= $item->ref; ?>">
                <div class="td-content customer-name mini_mize">#<?= $item->ref; ?></div>
            </td>
            <td>
                <div class="td-content product-brand">
                    <a class="title" href="{URL:panel/vacancies/edit/<?= $item->id; ?>}" target="_blank">
                        <?= $item->title; ?>
                    </a>
                </div>
            </td>
            <td>
                <div class="td-content"><?= date("d/m/Y", $item->time); ?></div>
            </td>
        </tr>
    <?php } ?>
<?php } ?>
