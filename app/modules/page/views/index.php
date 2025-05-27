

<div class="p-5">
  <section class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php if ($this->shops) foreach ($this->shops as $shop) { ?>
      <div class="bg-white rounded-lg shadow-lg p-5 flex flex-col items-center">
        <img src="<?= $shop->image ? Storage::get($shop->image, 'shops', $shop->id) : '' ?>" alt="<?= $shop->title ?>" class="rounded-md mb-4 w-full">
        <h2 class="text-lg font-bold"><?= $shop->title ?></h2>
          <?php if ($shop->address_link) { ?>
            <a href="<?= $shop->address_link ?>" target="_blank" class="text-gray-600">Адрес: <?= $shop->address ?></a>
          <?php } else { ?>
            <p class="text-gray-600">Адрес: <?= $shop->address ?></p>
          <?php } ?>
          <?php if ($shop->time_from || $shop->time_to) { ?>
          <p class="text-gray-600">Время работы: <?= $shop->time_from . ($shop->time_to ? ' - ' . $shop->time_to : '') ?></p>
          <?php } ?>
        <a class="mt-4 bg-black text-white px-4 py-2 rounded-lg" href="{LINK:shops/<?= $shop->slug ?>}">Выбрать</a>
      </div>
    <?php } ?>

  </section>
</div>
