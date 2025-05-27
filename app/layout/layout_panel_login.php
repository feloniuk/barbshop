<?php if (!Request::isAjax()) { ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <title><?= Request::getTitle(); ?></title>
    <link rel="icon" type="image/x-icon" href="<?= _SITEDIR_ ?>assets/img/favicon.png"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?= _SITEDIR_ ?>public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= _SITEDIR_ ?>assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <link href="<?= _SITEDIR_ ?>assets/css/authentication/form-1.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link href="<?= _SITEDIR_ ?>public/plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= _SITEDIR_ ?>assets/css/forms/theme-checkbox-radio.css" rel="stylesheet" type="text/css">
    <link href="<?= _SITEDIR_ ?>assets/css/forms/switches.css" rel="stylesheet" type="text/css">
    <link href="<?= _SITEDIR_ ?>public/css/backend/admin-panel.css" rel="stylesheet" type="text/css" />

    <!-- Connect CSS Main File -->
    <link href="<?= _SITEDIR_ ?>public/css/admin.css?(cache)" type="text/css" rel="stylesheet" />

    <script>var site_url = '<?= SITE_URL ?>';</script>
    <script>var site_dir = '<?= _SITEDIR_ ?>';</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="<?= _SITEDIR_ ?>public/js/backend/function.js"></script>
    <script src="<?= _SITEDIR_ ?>public/js/backend/event.js"></script>
    <script src="<?= _SITEDIR_ ?>public/plugins/notification/snackbar/snackbar.min.js"></script>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="form">

<div id="site">
    <div id="content__box" class="content arrive">
<?php } ?>

    <?php
    echo $this->Load('contentPart'); // Content wrapper
    ?>

<?php if (!Request::isAjax()) { ?>
    </div>
</div>

</body>
</html>
<?php } ?>
