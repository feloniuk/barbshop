<div class="form-container">
    <div class="form-form" style="width: 100%;">

        <div class="form-form-wrap">
            <div class="form-container">
                <div class="form-content">

                    <h1 class="">Авторизация <span class="brand-name">Пользователя</span></h1>
                    <!--<p class="signup-link">New Here? <a href="auth_register.html">Create an account</a></p>-->

                    <form class="text-left" method="post" action="{URL:panel/login}">
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
                                <input id="username" name="email" type="email" class="form-control" placeholder="Почта" value="<?= post('email'); ?>">
                            </div>

                            <div id="password-field" class="field-wrapper input mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                <input id="password" name="password" type="password" class="form-control" placeholder="Пароль" value="<?= post('password'); ?>">
                            </div>

                            <div class="d-sm-flex justify-content-between align-items-center">
                                <div class="field-wrapper toggle-pass">
<!--                                    <p class="d-inline-block">Show Password</p>-->
<!--                                    <label class="switch s-primary">-->
<!--                                        <input type="checkbox" id="toggle-password" class="d-none">-->
<!--                                        <span class="slider round"></span>-->
<!--                                    </label>-->
                                </div>


                                <div class="field-wrapper">
                                    <button type="submit" class="btn btn-primary" value="">Войти</button>
                                </div>
                            </div>

<!--                            <div class="field-wrapper text-center keep-logged-in">-->
<!--                                <div class="n-chk new-checkbox checkbox-outline-primary">-->
<!--                                    <label class="new-control new-checkbox checkbox-outline-primary">-->
<!--                                        <input type="checkbox" class="new-control-input">-->
<!--                                        <span class="new-control-indicator"></span>Keep me logged in-->
<!--                                    </label>-->
<!--                                </div>-->
<!--                            </div>-->
                        </div>
                    </form>
                    <p class="terms-conditions">© <?= date('Y') ?> Барбершоп.

                    </p>
                </div>
            </div>
        </div>
    </div>
</div>