<?php if (!Request::isAjax()) { ?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=1.0, minimum-scale=1.0, maximum-scale=5.0"/>
        <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
        <title>404</title>
        <?php
        Model::import('panel/settings');
        if ($favicon = SettingsModel::get('favicon')) { ?>
            <link rel="shortcut icon" href="<?= _SITEDIR_ ?>data/setting/<?= $favicon ?>">
        <?php } ?>


        <!-- Connect CSS Main File -->
        <link href="<?= _SITEDIR_ ?>public/css/style.css?(cache)" type="text/css" rel="stylesheet"/>

        <link href="<?= _SITEDIR_ ?>public/plugins/notification/snackbar/snackbar.min.css" rel="stylesheet"
              type="text/css"/>

        <!-- Connect JS files -->
        <script>var site_url = '<?= SITE_URL ?>';</script>
        <script>var site_dir = '<?= _SITEDIR_ ?>';</script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous"
                referrerpolicy="no-referrer"></script>

        <script src="<?= _SITEDIR_ ?>public/js/backend/function.js?(cache)"></script>
        <script src="<?= _SITEDIR_ ?>public/js/backend/event.js?(cache)"></script>


        <?php /*
            Remove the style tag below if FD has its own 404 page!
            */ ?>
        <style>
            body { color: white; background-color: #64C2C8; }
            a, div, .title { color: white; }
            .center { text-align: center; }
        </style>
    </head>

    <body>
    <div class="wrap">
        <div class="content" style="display: flex
;
    justify-content: center;
    align-items: center;
    height: 100vh;
    width: 150vh;">
<?php } ?>


<!-- 404 page content -->

<div class="page404" style="padding-top: 100px;">
    <div class="title center">Page not found</div>
    <div class="center rose_light">The page may have changed the address or never existed</div>

    <div class="center mt_24">
        <a href="{URL:/}" class="btn gray">Home page</a>
    </div>
</div>

<!-- /404 page content -->


<?php if (!Request::isAjax()) { ?>
        </div>
    </div>


    </body>
    </html>
<?php } ?>