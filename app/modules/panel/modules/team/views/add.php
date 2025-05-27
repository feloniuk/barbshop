<form id="form_box" action="{URL:panel/team/add}" method="post" enctype="multipart/form-data">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing">
            <!-- Title ROW -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <h1 class="page_title"><a href="{URL:panel/team}">Team</a>&nbsp;» New</h1>
                    </div>
                </div>
            </div>


            <!-- General -->
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <h3>General</h3>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="firstname">First Name</label>
                            <input class="form-control" type="text" name="firstname" id="firstname" value="<?= post('firstname', false); ?>"><!--required-->
                        </div>
                        <div class="form-group col-md-6">
                            <label for="lastname">Last Name</label>
                            <input class="form-control" type="text" name="lastname" id="lastname" value="<?= post('lastname', false); ?>"><!--required-->
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" name="email" id="email" value="<?= post('email', false); ?>"><!--required-->
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">Password</label>
                            <input class="form-control" type="password" name="password" id="password" value="<?= post('password', false); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" name="role" id="role" required>
                            <option value="admin">Admin</option>
                          <option value="moder" >Manager</option>
                          <option value="master" >Master</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Save Buttons -->
            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div>
                            <button type="submit" name="submit" class="btn btn-success" onclick="load('panel/team/add', 'form:#form_box'); return false;"><i class="fas fa-save"></i>Save Changes</button>
                            <a class="btn btn-outline-warning" href="{URL:panel/team}"><i class="fas fa-ban"></i>Cancel</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>