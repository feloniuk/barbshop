<div class="form-container">
    <div class="form-form">

        <div class="form-form-wrap">
            <div class="form-container">
                <div class="form-content">
                    <a href="{URL:panel/login}">Back to login</a>
                    <h1 class="">Please enter your email</h1>
                    <!--<p class="signup-link">New Here? <a href="auth_register.html">Create an account</a></p>-->

                    <form class="text-left" method="post" id="restore_form">
                        <div class="form">
                            <style>
                                form.text-left input:-webkit-autofill,
                                form.text-left input:-webkit-autofill:hover,
                                form.text-left input:-webkit-autofill:focus,
                                form.text-left input:-webkit-autofill:active {
                                    -webkit-box-shadow: 0 0 0 30px white inset !important;
                                    background-color: white !important;
                                }
                                input {
                                    filter: none;
                                }
                            </style>

                            <?php if (isset($this->errors) && $this->errors) { ?>
                                <div class="alert alert-danger mb-4" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                                    <?php echo is_array($this->errors) ? implode("<br/>", $this->errors) : $this->errors; ?>
                                </div>
                            <?php } ?>

                            <div id="username-field" class="field-wrapper input">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <input id="username" name="email" type="email" class="form-control" placeholder="Email Address" autofocus value="<?= post('email'); ?>">
                            </div>

                            <div class="d-sm-flex justify-content-between">
                                <div class="field-wrapper toggle-pass">
                                </div>
                                <div class="field-wrapper">
                                    <button type="submit" name="login" onclick="load('panel/restore_password', 'form:#restore_form'); return false;" class="btn btn-primary" value="">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <p class="terms-conditions">© <?= date('Y') ?> Барбершоп.

                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="form-image">
        <div class="l-image">
        </div>
    </div>
</div>