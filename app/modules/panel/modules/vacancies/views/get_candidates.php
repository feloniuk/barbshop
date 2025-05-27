<?php if (is_array($this->vacancy_candidates) && count($this->vacancy_candidates) > 0) foreach ($this->vacancy_candidates as $item){?>
    <div class="cand_item" style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <a href="{URL:panel/candidates_portal/edit/<?= $item->cid ?>}" target="_blank"
               style="text-decoration: none; color: #0075ff;"><?= $item->firstname . ' ' . $item->lastname ?></a>
        </div>
        <a onclick="load('panel/vacancies/delete_candidate', 'candidate_id=<?=$item->cid?>', 'vacancy_id=<?=$this->vacancy_id?>'); return false;"
           class="icon fa fa-fw fa-trash-alt" title="Delete" style="cursor: pointer;"></a>
    </div>
<?php } ?>
