<table border="0" cellpadding="0" cellspacing="0" class="body">
    <tr>
        <td>&nbsp;</td>
        <td class="container">
            <div class="content">
                <!-- START CENTERED WHITE CONTAINER -->
                <table class="main">
                    <!-- START MAIN CONTENT AREA -->
                    <tr>
                        <td class="wrapper" align="center">
                            <img src="<?= SITE_URL ?>app/public/images/logo.png" alt="" width="250" height="350">
                        </td>
                    </tr>

                    <tr>
                        <td class="wrapper">
                            <p>Hi <?= $this->customer->firstname ?>,</p>
                            <p>There has been an update to <?= $this->user->firstname ?> that you should take a look at in your portal.</p>
                            <br>
                            <p><a class="calc_btn"  href="{URL:login}">Client Portal</a></p>
                            <br>
                            <p>Regards,<br>
                                Simon Monaghan</p>
                        </td>
                    </tr>
                    <!-- END MAIN CONTENT AREA -->
                </table>
                <!-- START FOOTER --><!-- END FOOTER -->
                <!-- END CENTERED WHITE CONTAINER -->
            </div>
        </td>
        <td>&nbsp;</td>
    </tr>
</table>
