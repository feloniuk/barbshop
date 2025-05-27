<?php if (!Request::isAjax()) { ?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php echo reFilter(Request::getParam('include_code_top')); // Top JS code ?>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= Request::getTitle() ?> | <?= Request::getParam('title_prefix') ?></title>

    <meta property="og:title" content="<?= Request::getTitle() ?>">
    <meta property="og:url" content="<?= SITE_URL . trim(_URI_,'/') ?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= SITE_NAME ?>">
    <meta property="og:description" content="<?= Request::getDescription() ?>">

    <!-- Favicon -->
    <link href="<?= _SITEDIR_ ?>data/setting/<?= Request::getParam('favicon'); ?>" rel="shortcut icon" />

    <!-- Connect Google API -->
    <script defer async src="https://www.google.com/recaptcha/api.js?render=<?= Request::getParam('site_key') ?>"></script>

    <!-- Connect CSS Main File -->
  <script src="https://cdn.tailwindcss.com"></script>
    <link href="<?= _SITEDIR_ ?>public/plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" />
    <link href="<?= _SITEDIR_ ?>public/css/style.css" type="text/css" rel="stylesheet" />

    <!-- Connect JS files -->
    <script>var site_url = '<?= SITE_URL ?>';</script>
    <script>var site_dir = '<?= _SITEDIR_ ?>';</script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>

    <script src="<?= _SITEDIR_ ?>public/js/backend/function.js?(cache)"></script>
    <script src="<?= _SITEDIR_ ?>public/js/backend/event.js?(cache)"></script>


</head>
<body class="bg-gray-100 text-gray-900">
<div id="site">
    <!-- POPUPS -->
    <div id="popup" class="popup"></div>
    <div id="notice"></div>
    <!-- /POPUPS -->

    <!-- Header & Menu -->
  <header class="bg-black text-white p-5 flex justify-between items-center w-full">
    <a href="{LINK:/}" class="text-xl font-bold">Барбершоп</a>
    <?php if (User::get('id')) { ?>
        <?php if (User::checkRole('user')) { ?>
          <div>
            <a href="{LINK:profile}" class="bg-gray-700 px-4 py-2 rounded text-white">Профиль</a>
            <a href="{URL:panel/logout}" class="bg-gray-700 px-4 py-2 rounded text-white">Выход</a>
          </div>
        <?php } else { ?>
            <div>
              <a href="{LINK:panel}" class="bg-gray-700 px-4 py-2 rounded text-white">Панель</a>
              <a href="{URL:panel/logout}" class="bg-gray-700 px-4 py-2 rounded text-white">Выход</a>
            </div>
        <?php } ?>
    <?php } else { ?>
      <div>
      <a href="{LINK:panel}" class="bg-gray-700 px-4 py-2 rounded text-white">Войти</a>
      
      <a href="{LINK:/appointments}" class="bg-gray-700 px-4 py-2 rounded text-white">Мои записи</a>
      </div>
    <?php } ?>
  </header>
    <!-- /Header & Menu -->

    <main id="content" class="main">
        <?php } ?>

        <?php
        echo $this->Load('contentPart'); // Content from view page
        ?>

        <?php if (!Request::isAjax()) { ?>
    </main>

    <!-- Footer -->


  <footer class="bg-black text-white p-5 text-center pt-10 pb-10">
    &copy; 2025 Барбершоп. Все права защищены.
  </footer>
    <!-- /FOOTER -->

</div>

<?php echo reFilter(Request::getParam('include_code_bottom')); // Bottom JS code ?>

<script src="<?= _SITEDIR_ ?>public/plugins/notification/snackbar/snackbar.min.js"></script>

</body>
</html>
<?php } ?>
