<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>New Email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            line-height: 100%;
            font-size: 14px;
        }

        body * {
            margin: 0;
            padding: 0;
        }

        :root {
            --font-mont: 'Montserrat', sans-serif;
        }

        table, td, div, h1, h2, h3, p {
            font-family: var(--font-mont);
        }

        .logo {
            width: 120px;
        }

        .main {
            background-color: #ffffff;
            margin: 0 auto;
            max-width: 600px;
            padding-top: 50px;
        }

        .header-td {
            padding: 0 0 30px;
        }

        .main-tb td + td p {
            color: #393D43;
        }

        .main-tb {
            padding: 0 50px 15px;
            width: 100%;
        }

        .footer-tb {
            background-color: #FCFCFC;
            padding: 35px 50px;
        }

        .padding {
            padding: 0 50px 15px;
        }

        .social a {
            display: inline-block;
            margin-right: 20px;
        }

        .social a:last-child {
            margin-right: 0;
        }

        .privacy p {
            display: inline-block;
            margin-right: 15px;
        }

        .privacy p:last-child {
            margin-right: 0;
        }

        h1,
        h2,
        h3 {
            color: #111111;
        }

        p {
            color: #7E8084;
            font-weight: 500;
            font-size: 14px;
            margin: 0 0 5px;
        }

        @media (max-width: 769px) {
            .main {
                padding-top: 25px;
            }

            .main-tb {
                padding: 0 25px 10px;
            }

            .padding {
                padding: 0 25px 10px;
            }

            .footer-tb {
                padding: 15px 25px;
            }
        }

        @media (max-width: 428px) {
            .main-tb td + td {
                max-width: 210px;
                word-break: break-all;
            }
        }
    </style>
</head>

<body style="margin: 0; padding: 0;">
<div style="font-size:0px;font-color:#ffffff;opacity:0;visibility:hidden;width:0;height:0;display:none;"></div>

<table cellpadding="0" cellspacing="0" width="100%" bgcolor="#ffffff">
    <tr>
        <td>
            <table class="main table-600" cellpadding="0" cellspacing="0" width="100%" align="center">
                <tr>
                    <td class="header-td">
                        <table cellpadding="0" cellspacing="0" align="center" width="100%">
                            <tr>
                                <td align="center" class="logo">
                                    <img src="{URL:/}app/public/images/email_images/am_logo.png" width="120" style="height: auto; object-fit: contain" alt="logo"/>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <!-- Email body -->
                    <?php echo Mail::getBody(); ?>
                    <!-- /Email body -->
                </tr>
                <tr>
                    <td>
                        <table class="footer-tb" width="100%"  align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="logo" style="padding: 0;" align="left">
                                    <img src="{URL:/}app/public/images/email_images/am_logo.png" width="84" style="height: auto; object-fit: contain;" alt="">
                                </td>

                                <td class="social" style="padding: 0;" align="right">
                                    <?php if (Request::getParam('instagram')) { ?>
                                        <a href="<?= Request::getParam('instagram') ?>" target="_blank">
                                            <img src="{URL:/}app/public/images/email_images/insta.png" width="24" height="24" style="object-fit: contain;" alt="">
                                        </a>
                                    <?php } ?>
                                    <?php if (Request::getParam('facebook')) { ?>
                                        <a href="<?= Request::getParam('facebook') ?>" target="_blank">
                                            <img src="{URL:/}app/public/images/email_images/facebook.png" width="24" height="24" style="object-fit: contain;" alt="">
                                        </a>
                                    <?php } ?>
                                    <?php if (Request::getParam('youtube')) { ?>
                                        <a href="<?= Request::getParam('youtube') ?>" target="_blank">
                                            <img src="{URL:/}app/public/images/email_images/youtube.png" width="24" height="24" style="object-fit: contain;" alt="">
                                        </a>
                                    <?php } ?>
                                    <?php if (Request::getParam('twitter')) { ?>
                                        <a href="<?= Request::getParam('twitter') ?>" target="_blank">
                                            <img src="{URL:/}app/public/images/email_images/twitter.png" width="24" height="24" style="object-fit: contain;" alt="">
                                        </a>
                                    <?php } ?>
                                    <?php if (Request::getParam('linkedin')) { ?>
                                        <a href="<?= Request::getParam('linkedin') ?>" target="_blank">
                                            <img src="{URL:/}app/public/images/email_images/linkedin.png" width="24" height="24" style="object-fit: contain;" alt="">
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 20px 0 0" colspan="2">
                                    <a href="<?= SITE_URL ?>" target="_blank" style="color: #393D43"><?= SITE_NAME ?></a>
                                </td>
                            </tr>

                            <tr>
                                <td class="privacy" style="padding: 10px 0 0" colspan="2">
                                    <p><?= date('Y') ?> <?= SITE_NAME ?>.</p>
                                    <p>All rights reserved.</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>