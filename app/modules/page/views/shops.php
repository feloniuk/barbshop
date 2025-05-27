<div class="w-full items-center">
  <section class="bg-white rounded-lg shadow-lg p-5 w-full text-center mb-6">
    <h1 class="text-2xl font-bold"><?= $this->shop->title ?></h1>
    <p class="text-gray-600 mt-2"><?= processDesc($this->shop->content) ?></p>
  </section>

  <section class="grid sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-center">

      <?php if ($this->shop->users) foreach ($this->shop->users as $user) {
        if ($user->role !== 'master') continue; ?>

        <div class="rounded-lg shadow-lg p-5 flex flex-col items-center">
          <img src="<?= $user->image ? Storage::get($user->image, 'users', $user->id) : '' ?>" alt="Мастер 1" class="rounded-full mb-4 ">
          <h2 class="text-lg font-bold"><?= $user->firstname . ' ' . $user->lastname ?></h2>
          <p class="text-gray-600"><?= $user->job_title ?></p>
          <a class="mt-4 bg-black text-white px-4 py-2 rounded-lg" href="{LINK:barber/<?= $user->slug ?>}?shop=<?= $this->shop->slug ?>">Выбрать</a>
        </div>
      <?php } ?>
  </section>
</div>