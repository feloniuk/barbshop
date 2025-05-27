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
                            <p>Here is a new candidate for the role of <?= $this->vacancy->title ?>:</p>
                            <p>Please click this button to be taken to the client portal.</p>
                            <p><a class="calc_btn"  href="{URL:login}">Client Portal</a></p>
                            <p>Here you can do any of the following:</p>
                            <p>-View the candidate details and see why I think they are a great fit.</p>
                            <p>-Download and share CV</p>
                            <p>-Ask a question</p>
                            <p>-Arrange an interview and provide availability</p>
                            <p>-Arrange a technical challenge</p>
                            <p>-Reject the candidate and give feedback</p>
                            <br>
                            <br>
                            <p>Of course, you can always pick up the phone too!</p>
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

