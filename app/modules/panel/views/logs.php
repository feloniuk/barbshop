<div class="layout-px-spacing">
    <div class="row layout-top-spacing">

        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="widget-content widget-content-area br-6">
                <ul class="nav nav-tabs  mb-3 mt-3 nav-fill" id="justifyTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="justify-system-tab" data-toggle="tab" href="#justify-system" role="tab" aria-controls="justify-system" aria-selected="true">System</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="justify-email-tab" data-toggle="tab" href="#justify-email" role="tab" aria-controls="justify-email" aria-selected="false">Email</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="justify-user-tab" data-toggle="tab" href="#justify-user" role="tab" aria-controls="justify-user" aria-selected="false">User</a>
                    </li>
                </ul>


                <div class="tab-content" id="justifyTabContent">
                    <!--  System Logs-->
                    <div class="tab-pane fade show active" id="justify-system" role="tabpanel" aria-labelledby="justify-system-tab">
                        <!-- Head -->
                        <div class="flex-btw flex-vc mob_fc">
                            <h1>System Logs</h1>
                            <?php if (User::checkRole('superadmin')) { ?>
                                <a class="btn btn-primary mb-2 mr-2" onclick="load('panel/logs', 'q=clear');">Clear Logs</a>
                            <?php } ?>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-4">
                                <thead>
                                <tr>
                                    <th style="width: 70px;">ID</th>
                                    <th style="width: 80px;">Type</th>
                                    <th style="width: 110px;">Where</th>
                                    <th>Error</th>
                                    <th style="width: 10%;">Time</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php if ($this->list->num_rows) { ?>
                                    <?php while ($list = mysqli_fetch_object($this->list)) { ?>
                                        <tr>
                                            <td><?= $list->id; ?></td>
                                            <td><?= $list->status; ?></td>
                                            <td><?= $list->where; ?></td>
                                            <td class="w40p"><?= reFilter($list->error); ?></td>
                                            <td><?= $list->time; ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="5" class="center">No records</td>
                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--  End system logs -->
                    <!--  Email Logs-->
                    <div class="tab-pane fade" id="justify-email" role="tabpanel" aria-labelledby="justify-email-tab">
                        <!-- Head -->
                        <div class="flex-btw flex-vc mob_fc">
                            <h1>Email Logs</h1>

                            <?php if (User::checkRole('superadmin')) { ?>
                                <a class="btn btn-primary mb-2 mr-2" onclick="load('panel/logs/email_logs', 'q=clear');">Clear Logs</a>
                            <?php } ?>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-4">
                                <thead>
                                <tr>
                                    <th style="width: 70px;">ID</th>
                                    <th>Email</th>
                                    <th>Entity</th>
                                    <th>Status</th>
                                    <th>Time</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php if ($this->list_email->num_rows) { ?>
                                    <?php while ($list = mysqli_fetch_object($this->list_email)) { ?>
                                        <tr>
                                            <td><?= $list->id; ?></td>
                                            <td><?= $list->email; ?></td>
                                            <td><?= $list->entity; ?></td>
                                            <td>
                                                <?php
                                                $color = '#515365';
                                                switch($list->status) {
                                                    case 'failed':
                                                        $color = 'red'; break;
                                                    case 'sent':
                                                        $color = 'green'; break;
                                                    case 'read':
                                                        $color = 'blue'; break;
                                                }
                                                ?>
                                                <span style="color: <?= $color ?>;"><?= $list->status ?></span>
                                            </td>
                                            <td><?= date('d-m-Y H:i:s', $list->time); ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="5" class="center">No records</td>
                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--  End Email logs -->
                    <!--  User logs -->
                    <div class="tab-pane fade" id="justify-user" role="tabpanel" aria-labelledby="justify-user-tab">
                        <!-- Head -->
                        <div class="flex-btw flex-vc mob_fc">
                            <h1>User Logs</h1>

                            <?php if (User::checkRole('superadmin')) { ?>
                                <a class="btn btn-primary mb-2 mr-2" onclick="load('panel/logs/user_logs', 'q=clear');">Clear Logs</a>
                            <?php } ?>
                        </div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mb-4">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>Entity</th>
                                    <th>Time</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php if (is_array($this->list_user) && count($this->list_user) > 0) { ?>
                                    <?php foreach ($this->list_user as $list) { ?>
                                        <tr>
                                            <td><?= $list->id; ?></td>
                                            <td><a href="{URL:panel/team/edit/<?= $list->user_id ?>}"><?= $list->user->firstname . ' ' . $list->user->lastname; ?></a></td>
                                            <td><?= $list->action; ?></td>
                                            <td><?= $list->entity; ?></td>
                                            <td><?= date('d-m-Y H:i:s', $list->time); ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="5" class="center">No records</td>
                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!--  End User logs -->
                </div>

            </div>
        </div>

    </div>
</div>