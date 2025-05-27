<div class="w-full items-center">
  <section class="bg-white rounded-lg shadow-lg p-5 w-full text-center mb-6">
    <h1 class="text-2xl font-bold"><?= $this->barber->firstname . ' ' . $this->barber->lastname ?></h1>
    <p class="text-gray-600 mt-2"><?= processDesc($this->barber->description) ?></p>
  </section>

  <section class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-center">

      <?php if ($this->barber->services) foreach ($this->barber->services as $service) { ?>

        <div class="rounded-lg shadow-lg p-5 flex flex-col items-center">
          <?= $service->image ? '<img src="' . Storage::get($service->image, 'services', $service->id) . '" alt="Мастер 1" class="rounded-full mb-4">' : '' ?>
          <h2 class="text-lg font-bold"><?= $service->title ?></h2>
          <p class="text-gray-600">Время: <?= servicesMode($service->service_time) ?></p>
          <p class="text-gray-600">Цена: <?= $service->price ? $service->price . 'грн' : '' ?></p>
          <a class="mt-4 bg-black text-white px-4 py-2 rounded-lg" href="{LINK:zapis}?shop=<?= get('shop') ?>&barber=<?= $this->barber->slug ?>&service=<?= $service->id ?>">Выбрать</a>
        </div>
      <?php } ?>
  </section>
</div>