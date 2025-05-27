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
                            <p>Hi <?= $this->customer->firstname?>,</p>
                            <p>I have added your <?= $this->edit->title ?> Vacancy to the client portal.</p>
                            <p>Please click this button to be taken to the client portal, where you will be able to view the advert.</p>
                            <br>
                            <p><a class="calc_btn"  href="{URL:login}">Client Portal</a></p>
                            <br>
                            <p>You will receive an email with a link to the portal, anytime I add a new candidate for you to view.</p>
                            <p>I will get cracking on the role and you should start to see candidates soon.</p>
                            <br>
                            <p>Best Regards,<br>
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


