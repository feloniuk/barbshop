<?php if (!Request::isAjax()) { ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title><?= Request::getTitle(); ?></title>

    <?php
    if (Request::getParam('favicon'))
        $favicon = _SITEDIR_ . 'data/setting/' . Request::getParam('favicon');
    else
        $favicon = _SITEDIR_ . 'assets/img/favicon.png';
    ?>
    <link rel="icon" type="image/x-icon" href="<?= $favicon ?>"/>
    <link href="<?= _SITEDIR_ ?>assets/css/loader.css" rel="stylesheet" type="text/css" />
    <script src="<?= _SITEDIR_ ?>assets/js/loader.js"></script>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="<?= _SITEDIR_ ?>public/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= _SITEDIR_ ?>assets/css/plugins.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="<?= _SITEDIR_ ?>public/plugins/apex/apexcharts.css" rel="stylesheet" type="text/css">
    <link href="<?= _SITEDIR_ ?>assets/css/dashboard/dash_1.css" rel="stylesheet" type="text/css">
    <link href="<?= _SITEDIR_ ?>assets/css/elements/avatar.css" rel="stylesheet" type="text/css">
    <link href="<?= _SITEDIR_ ?>public/css/backend/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= _SITEDIR_ ?>public/css/backend/jquery.scroll.css" rel="stylesheet" />
    <link href="<?= _SITEDIR_ ?>public/css/backend/jquery.jcrop.css" rel="stylesheet" type="text/css" />
    <link href="<?= _SITEDIR_ ?>public/css/additional_styles.css?(cache)" rel="stylesheet" type="text/css" />
    <!-- toastr -->
    <link href="<?= _SITEDIR_ ?>public/plugins/notification/snackbar/snackbar.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <!-- Datatable -->
    <link rel="stylesheet" type="text/css" href="<?= _SITEDIR_ ?>public/plugins/datatable/datatables.css">
    <link rel="stylesheet" type="text/css" href="<?= _SITEDIR_ ?>public/plugins/datatable/dt-global_style.css">
    <!-- Datatable -->

    <link href="<?= _SITEDIR_ ?>public/css/backend/admin-panel.css" rel="stylesheet" type="text/css" />
    <link href="<?= _SITEDIR_ ?>assets/css/forms/switches.css" rel="stylesheet" type="text/css">
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <!-- Connect CSS Main File -->
    <link href="<?= _SITEDIR_ ?>public/css/admin.css?(cache)" type="text/css" rel="stylesheet" />

    <script>var site_url = '<?= SITE_URL ?>';</script>
    <script>var site_dir = '<?= _SITEDIR_ ?>';</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <!-- Copy to clipboard -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.6/clipboard.min.js"></script>
    <script src="https://kit.fontawesome.com/aaa56c7348.js" crossorigin="anonymous"></script>
    <script src="<?= _SITEDIR_ ?>public/js/backend/jquery.scrollbar.min.js"></script>
    <script src="<?= _SITEDIR_ ?>public/js/backend/function.js?(cache)"></script>
    <script src="<?= _SITEDIR_ ?>public/js/backend/event.js?(cache)"></script>
    <script src="<?= _SITEDIR_ ?>public/plugins/notification/snackbar/snackbar.min.js"></script>
    <script src="<?= _SITEDIR_ ?>public/js/backend/jquery.jcrop.min.js"></script>
    <script src="<?= _SITEDIR_ ?>public/js/backend/pagination.js"></script>

    <!-- Datepicker -->
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <?php /*
    <!-- Datepicker -->
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    */ ?>
</head>
<body id="site">

<!-- BEGIN LOADER -->
<div id="load_screen">
    <div class="loader">
        <div class="loader-content">
            <div class="spinner-grow align-self-center"></div>
        </div>
    </div>
</div>
<!--  END LOADER -->

<!--  NEW GLOBAL LOADER  -->
<div
        id="global-loader"
>
    <div
            role="status"
    >
        <svg aria-hidden="true" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
        </svg>
    </div>
</div>
<!--  END GLOBAL LOADER  -->

<!--  BEGIN NAVBAR  -->
<div class="header-container fixed-top">
    <header class="header navbar navbar-expand-sm">
        <ul class="navbar-item theme-brand flex-row text-center">
            <li style="margin-right: 10px">
                <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                </a>
            </li>

            <li class="nav-item theme-logo">
                <a href="{URL:/}">
                    <img src="<?= Request::getParam('admin_logo') ?>" class="navbar-logo" alt="logo">
                </a>
            </li>
<!--            <li class="nav-item theme-text">-->
<!--                <a href="{URL:/panel}" class="nav-link"> BOLD </a>-->
<!--            </li>-->
        </ul>

<!--        <ul class="navbar-item flex-row ml-md-0 ml-auto">-->
<!--            <li class="nav-item align-self-center search-animated">-->
<!--                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>-->
<!--                <form class="form-inline search-full form-inline search" role="search">-->
<!--                    <div class="search-bar">-->
<!--                        <input type="text" class="form-control search-form-control  ml-lg-auto" placeholder="Search...">-->
<!--                    </div>-->
<!--                </form>-->
<!--            </li>-->
<!--        </ul>-->

        <ul class="navbar-item flex-row ml-sm-auto ml-md-auto">
            <li class="user-profile-info">
                <h3><?= User::get('firstname') . ' ' . User::get('lastname') ?></h3>
                <div><?= User::get('email') ?></div>
            </li>
            <li class="nav-item dropdown user-profile-dropdown">
                
                <a class="nav-link dropdown-toggle user" href="{URL:panel/logout}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"     color: white;
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                class="feather feather-log-out"><path     color: white; d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4">

                                </path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                                
                            </a>
                
            </li>
        </ul>
    </header>
</div>
<!--  END NAVBAR  -->

<!--  BEGIN NAVBAR  -->
<?php /*
<div class="sub-header-container">
    <header class="header navbar navbar-expand-sm">
        <a href="javascript:void(0);" class="sidebarCollapse" data-placement="bottom">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </a>

        <ul class="navbar-nav flex-row">
            <li>
                <div class="page-header">
                    <nav class="breadcrumb-one" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{URL:panel}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><span>Sales</span></li>
                        </ol>
                    </nav>
                </div>
            </li>
        </ul>

        <ul class="navbar-nav flex-row ml-auto ">
            <li class="nav-item more-dropdown">
                <div class="dropdown  custom-dropdown-icon">
                    <a class="dropdown-toggle btn" href="#" role="button" id="customDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span>Settings</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down"><polyline points="6 9 12 15 18 9"></polyline></svg></a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="customDropdown">
                        <a class="dropdown-item" data-value="Settings" href="{URL:panel/setting}">Settings</a>
<!--                        <a class="dropdown-item" data-value="Mail" href="javascript:void(0);">Mail</a>-->
<!--                        <a class="dropdown-item" data-value="Print" href="javascript:void(0);">Print</a>-->
<!--                        <a class="dropdown-item" data-value="Download" href="javascript:void(0);">Download</a>-->
<!--                        <a class="dropdown-item" data-value="Share" href="javascript:void(0);">Share</a>-->
                    </div>
                </div>
            </li>
        </ul>
    </header>
</div>
*/ ?>
<!--  END NAVBAR  -->

<!--  BEGIN MAIN CONTAINER  -->
<div class="main-container" id="container">
    <div class="overlay"></div>
    <div class="search-overlay"></div>

    <!--  BEGIN SIDEBAR  -->
    <div class="sidebar-wrapper sidebar-theme">
        <nav id="sidebar">

            <?php echo View::get('panel/index', 'left'); // !!! LEFT-MENU !!! ?>

        </nav>
    </div>
    <!--  END SIDEBAR  -->

    <!--  BEGIN CONTENT AREA  -->
    <div id="content" class="main-content">
<!--        <div id="content_place" class="content arrive">-->
        <?php } ?>

        <?php echo $this->Load('contentPart'); // Content wrapper ?>

        <?php if (!Request::isAjax()) { ?>

        <div class="footer-wrapper">
            <div class="footer-section f-section-1">
                <p class="">© <?= date("Y") ?> Барбершоп.</p>
            </div>
        </div>

<!--        </div>-->
    </div>
    <!--  END CONTENT AREA  -->
</div>
<!-- END MAIN CONTAINER -->

<div id="popup"></div>
<div id="api_content"></div>

<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="<?= _SITEDIR_ ?>public/plugins/bootstrap/js/popper.min.js"></script>
<script src="<?= _SITEDIR_ ?>public/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?= _SITEDIR_ ?>public/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="<?= _SITEDIR_ ?>assets/js/app.js"></script>
<!--Scroll Lock-->
<script src="<?= _SITEDIR_ ?>public/js/scroll-lock.min.js"></script>

<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="<?= _SITEDIR_ ?>assets/js/custom.js"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

</body>
</html>
<?php } ?>
