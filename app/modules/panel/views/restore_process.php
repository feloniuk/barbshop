<div class="form-container">
    <div class="form-form">

        <div class="form-form-wrap">
            <div class="form-container">
                <div class="form-content">
                    <a href="{URL:panel/login}">Back to login</a>
                    <h1 class="">Please, type your new password</h1>
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
                            <?php } else { ?>

                                <div id="password-field" class="field-wrapper input mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Password" value="<?= post('password'); ?>">
                                </div>
                                <div id="password-field" class="field-wrapper input mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                    <input id="password2" name="password2" type="password" class="form-control" placeholder="Confirm Password" value="<?= post('password2'); ?>">
                                </div>

                                <div class="d-sm-flex justify-content-between">
                                    <div class="field-wrapper toggle-pass">
                                    </div>
                                    <div class="field-wrapper">
                                        <button type="submit" name="login" onclick="load('panel/restore_process?email=<?= get('email') ?>&hash=<?= get('hash') ?>', 'form:#restore_form'); return false;" class="btn btn-primary" value="">Submit</button>
                                    </div>
                                </div>

                            <?php } ?>
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