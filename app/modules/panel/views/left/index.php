<div class="shadow-bottom"></div>
<ul class="list-unstyled menu-categories" id="accordionExample">
    <!-- Dashboard -->
    <li class="menu">
        <a <?= activeIF(['panel'], 'index', 'data-active="true" aria-expanded="false"') ?>
                href="{URL:panel}" class="dropdown-toggle">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                <span>Dashboard</span>
            </div>
        </a>
    </li>

    <?php if(User::checkRole('admin') || User::checkRole('superadmin') || User::checkRole('moder')) { ?>
<!-- Blog / News -->
<li class="menu">
  <a <?= $show = activeIF(['categories', 'shops'], false, 'data-active="true" aria-expanded="false"',
      (CONTROLLER !== 'panel/learning_development/categories' && CONTROLLER !== 'panel/event_card/categories')) ?>
    href="{URL:panel/shops}" class="dropdown-toggle">
    <div>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bold"><path d="M6 4h8a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"></path><path d="M6 12h9a4 4 0 0 1 4 4 4 4 0 0 1-4 4H6z"></path></svg>  
    <span>Barber-Shops</span>
    </div>
  </a>  
    <?php /*
      <ul class="collapse submenu list-unstyled <?= $show ? 'show' : '' ?>" id="tab_news" data-parent="#accordionExample">
          <li class="<?= activeIF('blog', false, 'active') ?>">
              <a href="{URL:panel/blog}">
                  Blog Posts
              </a>
          </li>
          <li class="<?= activeIF('categories', false, 'active', (CONTROLLER !== 'panel/learning_development/categories' && CONTROLLER !== 'panel/event_card/categories')) ?>">
              <a href="{URL:panel/blog/categories}">
                  Categories
              </a>
          </li>
      </ul>
      */ ?>
</li>
<?php } ?>

<?php if(User::checkRole('admin') ) { ?>
<!-- Blog / News -->
<li class="menu">
  <a <?= $show = activeIF(['panel'], ['scada'], 'data-active="true" aria-expanded="false"',
      (CONTROLLER !== 'panel/learning_development/categories' && CONTROLLER !== 'panel/event_card/categories')) ?>
    href="{URL:panel/scada}" class="dropdown-toggle">
    <div>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-sun"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
    <span>SCADA</span>
    </div>
  </a>  
    <?php /*
      <ul class="collapse submenu list-unstyled <?= $show ? 'show' : '' ?>" id="tab_news" data-parent="#accordionExample">
          <li class="<?= activeIF('blog', false, 'active') ?>">
              <a href="{URL:panel/blog}">
                  Blog Posts
              </a>
          </li>
          <li class="<?= activeIF('categories', false, 'active', (CONTROLLER !== 'panel/learning_development/categories' && CONTROLLER !== 'panel/event_card/categories')) ?>">
              <a href="{URL:panel/blog/categories}">
                  Categories
              </a>
          </li>
      </ul>
      */ ?>
</li>
<?php } ?>
<?php if(User::checkRole('admin') || User::checkRole('superadmin')) { ?>
<!-- Video -->
<li class="menu">
  <a <?= $show = activeIF(['settings'], ['video'], 'data-active="true" aria-expanded="false"',
      (CONTROLLER !== 'panel/learning_development/categories' && CONTROLLER !== 'panel/event_card/categories')) ?>
    href="{URL:panel/settings/video}" class="dropdown-toggle">
    <div>
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-film"><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"></rect><line x1="7" y1="2" x2="7" y2="22"></line><line x1="17" y1="2" x2="17" y2="22"></line><line x1="2" y1="12" x2="22" y2="12"></line><line x1="2" y1="7" x2="7" y2="7"></line><line x1="2" y1="17" x2="7" y2="17"></line><line x1="17" y1="17" x2="22" y2="17"></line><line x1="17" y1="7" x2="22" y2="7"></line></svg>  
    <span>Video</span>
    </div>
  </a>
    <?php /*
      <ul class="collapse submenu list-unstyled <?= $show ? 'show' : '' ?>" id="tab_news" data-parent="#accordionExample">
          <li class="<?= activeIF('blog', false, 'active') ?>">
              <a href="{URL:panel/blog}">
                  Blog Posts
              </a>
          </li>
          <li class="<?= activeIF('categories', false, 'active', (CONTROLLER !== 'panel/learning_development/categories' && CONTROLLER !== 'panel/event_card/categories')) ?>">
              <a href="{URL:panel/blog/categories}">
                  Categories
              </a>
          </li>
      </ul>
      */ ?>
</li>
<?php } ?>

<?php if (in_array(User::getRole(), ['moder', 'admin', 'superadmin'])): ?>
<li class="menu">
    <a href="{URL:panel/scaner}" class="dropdown-toggle">
        <div class="">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
            <span>Відвідуваність</span>
        </div>
    </a>
</li>
<?php endif; ?>

<?php if(User::checkRole('admin') || User::checkRole('superadmin') || User::checkRole('moder')) { ?>
  <li class="menu">
    <a <?= $show = activeIF(['services'], false, 'data-active="true" aria-expanded="false"',
        (CONTROLLER !== 'panel/learning_development/categories' && CONTROLLER !== 'panel/event_card/categories')) ?>
      href="{URL:panel/services}" class="dropdown-toggle">
      <div>
        <i class="far fa-gem"></i><span>Services</span>
      </div>
    </a>
      <?php /*
        <ul class="collapse submenu list-unstyled <?= $show ? 'show' : '' ?>" id="tab_news" data-parent="#accordionExample">
            <li class="<?= activeIF('blog', false, 'active') ?>">
                <a href="{URL:panel/blog}">
                    Blog Posts
                </a>
            </li>
            <li class="<?= activeIF('categories', false, 'active', (CONTROLLER !== 'panel/learning_development/categories' && CONTROLLER !== 'panel/event_card/categories')) ?>">
                <a href="{URL:panel/blog/categories}">
                    Categories
                </a>
            </li>
        </ul>
        */ ?>
  </li>
  <?php } ?>

  <?php if(User::checkRole('admin') || User::checkRole('superadmin') || User::checkRole('moder')) { ?>
    <!-- Team Management -->
    <li class="menu">
        <a <?= $show = activeIF(['team'], false, 'data-active="true" aria-expanded="false"') ?>
                href="#tab_team" data-toggle="collapse" class="dropdown-toggle">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                <span>Users</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled <?= $show ? 'show' : '' ?>" id="tab_team" data-parent="#accordionExample">
            <li class="<?= activeIF('team', false, 'active') ?>">
                <a href="{URL:panel/team}">
                Users Manager
                </a>
            </li>
        </ul>
    </li>
    <?php } ?>

    
    <?php if(User::checkRole('admin') || User::checkRole('superadmin') || User::checkRole('superadmin')) { ?>

    <!-- Settings -->
    <li class="menu">
        <a <?= $show = activeIF(['panel', 'data_generator', 'dashboard_settings', 'sitemap', 'settings', 'dashboard', 'parser', 'redirects', 'logs'], false, 'data-active="true" aria-expanded="false"',
            !(CONTROLLER == 'panel' && ACTION == 'index') && !(CONTROLLER == 'panel' && ACTION == 'logs') && !(CONTROLLER == 'panel' && ACTION == 'scada') && !(CONTROLLER == 'panel/settings' && ACTION == 'video') && !(CONTROLLER == 'panel' && ACTION == 'email_logs')  && !(CONTROLLER == 'panel' && ACTION == 'user_logs')) ?>
                href="#tab_settings" data-toggle="collapse" class="dropdown-toggle">
            <div class="">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                <span>Settings</span>
            </div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </div>
        </a>
        <ul class="collapse submenu list-unstyled <?= $show ? 'show' : '' ?>" id="tab_settings" data-parent="#accordionExample">
            <li class="<?= activeIF('settings', 'index', 'active') ?>">
                <a href="{URL:panel/settings}">
                    General
                </a>
            </li>
            <li class="<?= activeIF('dashboard', 'index', 'active', !(CONTROLLER_SHORT == 'dashboard_settings' && ACTION == 'google')) ?>">
                <a href="{URL:panel/settings/dashboard}">
                    Dashboard
                </a>
            </li>
            <li class="<?= activeIF('settings', 'social_networks', 'active') ?>">
                <a href="{URL:panel/settings/social_networks}">
                    Social Links
                </a>
            </li>
            <?php if (User::checkAccessLevel(50)) { ?>
              <li class="<?= activeIF('panel', 'logs', 'active') ?>">
                <a href="{URL:panel/logs}">
                  Logs
                </a>
              </li>
            <?php } ?>
        </ul>
    </li>
    <?php } ?>

    <li style="margin-bottom: 100px;"></li>
</ul>
<!-- <div class="shadow-bottom"></div> -->
