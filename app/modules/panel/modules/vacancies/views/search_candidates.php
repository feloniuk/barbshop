<div style="margin-top: 10px;">
    <?php if (is_array($this->candidates) && count($this->candidates) > 0) foreach ($this->candidates as $item){?>
        <div class="cand_item" style="display: flex; justify-content: space-between; align-items: center;">
            <div><?= $item->firstname . ' ' . $item->lastname ?></div>
            <a onclick="load('panel/vacancies/add_candidate', 'candidate_id=<?=$item->id?>', 'vacancy_id=<?=$this->vacancy_id?>'); return false;"
               class="icon fa fa-fw fa-plus" title="Add" style="cursor: pointer;"></a>
        </div>
    <?php } ?>
</div>