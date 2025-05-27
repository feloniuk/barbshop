<?php
class TeamController extends Controller
{
    private static $numElement = 25;
    protected $layout = 'layout_panel';

    use Validator, RecordVersion;

    public function indexAction()
    {
        $this->view->count = $count = TeamModel::countActive();
        Pagination::calculate(post('page', 'int', 1), self::$numElement, $count);

        $user = TeamModel::getUser(User::get('id'));
        
        //search
        if (User::getRole() == 'moder') {
            $userByShops = TeamModel::getUsersByShopsWhere(" `shop_id` IN ('" . implode("', '", $user->shop_ids) . "')");
            if ($userByShops)
                $this->view->list = TeamModel::getActive(" and `role` IN ('master') and `id` IN ('" . implode("', '", array_column($userByShops, 'user_id')) . "')", 'id', 'DESC', Pagination::$start, Pagination::$end);
        }
        else
            $this->view->list = TeamModel::getActive(" and `role` IN ('admin', 'moder', 'master')", 'id', 'DESC', Pagination::$start, Pagination::$end);
        
        $this->view->elemPerPage = self::$numElement;

        Request::setTitle('Team Manager');
    }

    public function paginationAction()
    {
        Request::ajaxPart();

        $page        = post('page', 'int', 1); // page
        $orderby     = post('orderby'); //field name
        $sort        = post('ordertype'); //asc desc
        $searchValue = post('search'); // search value

        //prepare query for search
        $where = " and `role` IN ('admin', 'moder', 'master')";

        $user = TeamModel::getUser(User::get('id'));

        if ($searchValue) {
            $where .= " AND (CONCAT(`firstname`, ' ', `lastname`) LIKE '%$searchValue%' OR `email` LIKE '%$searchValue%')";
        }

        $totalRecordWithFilter = TeamModel::countActive($where);
        Pagination::calculate($page, self::$numElement, $totalRecordWithFilter);

        //search
        $this->view->list = TeamModel::getActive($where, $orderby, $sort, Pagination::$start, Pagination::$end);

        
        //search
        if (User::getRole() == 'moder') {
            $userByShops = TeamModel::getUsersByShopsWhere(" `shop_id` IN ('" . implode("', '", $user->shop_ids) . "')");
            
            $where = " and `role` IN ('master') and `id` IN ('" . implode("', '", array_column($userByShops, 'user_id')) . "')";
            if ($searchValue) {
                $where .= "and `role` IN ('master') and `id` IN ('" . implode("', '", array_column($userByShops, 'user_id')) . "') AND (CONCAT(`firstname`, ' ', `lastname`) LIKE '%$searchValue%' OR `email` LIKE '%$searchValue%')";
            }
            if ($userByShops)
                $this->view->list = TeamModel::getActive($where, $orderby, $sort, Pagination::$start, Pagination::$end);
        }
        else
            $this->view->list = TeamModel::getActive($where, $orderby, $sort, Pagination::$start, Pagination::$end);
        

        Request::addResponse('html', '#table-body', $this->getView('modules/panel/modules/team/views/_table_body.php'));

        if ($totalRecordWithFilter > self::$numElement) {
            Request::addResponse('html', '#pagination-box', Pagination::panelPagination('panel/team/pagination', allPost()));
        } else {
            Request::addResponse('html', '#pagination-box', '');
        }

        if (!$this->view->list) {
            Request::addResponse('html', '#pagination-box', '<div class="mt-4"><p>Results not found</p></div>');
        }

        Request::endAjax();
    }

    public function addAction()
    {
        if ($this->startValidation()) {
            $this->validatePost('firstname',    'First Name',       'required|trim|min_length[1]|max_length[100]');
            $this->validatePost('lastname',     'Last Name',        'required|trim|min_length[1]|max_length[100]');
            $this->validatePost('email',        'Email',            'required|trim|email');
            $this->validatePost('password',     'Password',         'required|trim|');

            if ($this->isValid()) {
                $data = array(
                    'firstname'     => post('firstname'),
                    'lastname'      => post('lastname'),
                    'email'         => post('email'),
                    'role'          => post('role'),
                    'password'      => md5(post('password')),
                    'slug'          => Model::createIdentifier('users', makeSlug(post('firstname') . ' ' . post('lastname'))),
                    'reg_time'      => time(),
                    'last_time'     => time(),
                );

                // Copy and remove image
                if ($data['image']) {
                    if (!Storage::copy('data/tmp/' . $data['image'], 'data/users/' . $data['image']))
                        print_data(error_get_last());
                }

                $checkEmail = TeamModel::getUserByEmail($data['email']);
                if ($checkEmail)
                    Request::returnError('This email is already taken');

                $result   = Model::insert('users', $data); // Insert row
                $insertID = Model::insertID();

                if (!$result && $insertID) {
                    $this->makeVersion($insertID, 'users', 'add');

                    Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'add', 'entity' => 'user#' . $insertID, 'time' => time()]);

//                    $this->session->set_flashdata('success', 'User created successfully.');
                    Request::addResponse('redirect', false, url('panel', 'team', 'edit', $insertID));
                } else {
                    Request::returnError('Database error');
                }
            } else {
                if (Request::isAjax())
                    Request::returnErrors($this->validationErrors);
            }
        }

        Request::setTitle('Add Team Member');
    }

    public function editAction()
    {
        $userID = intval(Request::getUri(0));
        $this->view->user = TeamModel::getUser($userID);

        if (!$this->view->user)
            redirect(url('panel/team'));

        if (User::getRole() !== 'superadmin' && $this->view->user->role == 'superadmin')
            redirect(url('panel/team'));

        Model::import('panel/services');
        $this->view->services = ServicesModel::getActive();

        Model::import('panel/shops');
        $this->view->shops = ShopsModel::getActive();

        if ($this->startValidation()) {
            $this->validatePost('firstname',    'First Name',       'required|trim|min_length[1]|max_length[100]');
            $this->validatePost('lastname',     'Last Name',        'required|trim|min_length[1]|max_length[100]');
            $this->validatePost('email',        'Email',            'required|trim|email');
            $this->validatePost('tel',          'Telephone Number', 'trim|min_length[0]|max_length[100]');
            $this->validatePost('password',     'Password',         'trim|password');
            $this->validatePost('job_title',    'Job Title',        'trim|min_length[0]|max_length[150]');
            $this->validatePost('role',         'Role',             'required|trim|min_length[1]|max_length[100]');
            $this->validatePost('description',  'Description',      'trim|min_length[0]');
            $this->validatePost('meta_title',   'Meta Title',       'trim|min_length[0]|max_length[200]');
            $this->validatePost('meta_keywords','Meta Keywords',    'trim|min_length[0]|max_length[200]');
            $this->validatePost('meta_desc',    'Meta Description', 'trim|min_length[0]|max_length[200]');
            $this->validatePost('linkedin',     'LinkedIn URL',     'trim|min_length[0]|max_length[100]|url');
            $this->validatePost('twitter',      'Twitter URL',      'trim|min_length[0]|max_length[100]|url');
            $this->validatePost('skype',        'Skype',            'trim|min_length[0]|max_length[100]');
            $this->validatePost('slug',         'Slug',             'required|trim|min_length[1]|max_length[100]');
            $this->validatePost('image',        'Image',            'trim|min_length[1]|max_length[100]');

            if ($this->isValid()) {
                $data = [
                    'firstname'     => post('firstname'),
                    'lastname'      => post('lastname'),
                    'email'         => post('email'),
                    'tel'           => post('tel'),
                    'job_title'     => post('job_title'),
                    'role'          => post('role'),
                    'description'   => post('description'),
                    'meta_title'    => post('meta_title'),
                    'meta_keywords' => post('meta_keywords'),
                    'meta_desc'     => post('meta_desc'),
                    //'for_fun'       => post('for_fun'),
                    'linkedin'      => processUrl(post('linkedin')),
                    'twitter'       => processUrl(post('twitter')),
                    'display_team'  => post('display_team') ?: 'no',
                    'skype'         => post('skype'),
                    'image'         => post('image'),
                    'slug'          => Model::createIdentifier('users', post('slug'), 'slug', $this->view->user->id),
                ];

                if (post('password'))
                    $data['password'] = md5(post('password'));

                $checkEmail = TeamModel::getUserByEmail($data['email']);
                if ($checkEmail && $checkEmail->id !== $this->view->user->id)
                    Request::returnError('This email is already taken');

                // Copy and remove image
                if ($this->view->user->image !== $data['image'] && $data['image']) {
                    Storage::entityImage('users', $userID, $data['image'], $this->view->user->image);
                }

                $result = Model::update('users', $data, "`id` = '$userID'"); // Update row

                if ($result) {
                    $this->makeVersion($userID, 'users', 'edit');

                    TeamModel::removeServices($userID);
                    if (is_array(post('services_ids')) && count(post('services_ids')) > 0) {
                        foreach (post('services_ids') as $sector_id) {
                            Model::insert('services_users', array(
                                'service_id' => $sector_id,
                                'user_id' => $userID
                            ));
                        }
                    }

                    TeamModel::removeShops($userID);
                    if (is_array(post('shops_ids')) && count(post('shops_ids')) > 0) {
                        foreach (post('shops_ids') as $sector_id) {
                            Model::insert('users_shops', array(
                                'shop_id' => $sector_id,
                                'user_id' => $userID
                            ));
                        }
                    }

                    Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'edit', 'entity' => 'user#' . $userID, 'time' => time()]);

                    Request::addResponse('func', 'noticeSuccess', 'Saved');
                    Request::endAjax();
                } else {
                    Request::returnError('Database error');
                }
            } else {
                if (Request::isAjax())
                    Request::returnErrors($this->validationErrors);
            }
        }

        Request::setTitle('Edit Team Member');
    }

    public function to_archiveAction()
    {
        $id = intval(Request::getUri(0));
        $user = TeamModel::getUser($id);

        if (!$user)
            Request::returnError('Team error');

        $data['deleted'] = 'yes';
        $result = Model::update('users', $data, "`id` = '$id'"); // Update row

        if ($result) {
            PageModel::closeAllSessions($id);

            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'archive', 'entity' => 'user#' . $id, 'time' => time()]);

            Request::addResponse('func', 'noticeSuccess', 'Archived');
            Request::addResponse('remove', '#item_' . $id);
            Request::endAjax();
        } else {
            Request::returnError('Database error');
        }
    }

    public function deleteAction()
    {
        Request::ajaxPart();

        $id = intval(Request::getUri(0));
        $user = TeamModel::getUser($id);

        if (!$user)
            Request::returnError('Team error');

        $result = Model::delete('users', "`id` = '$id'"); // delete row

        if ($result) {

            $this->makeVersion($id, 'users', 'delete');

            PageModel::closeAllSessions($id);

            //remove user images
            Storage::remove('data/users/' . $user->image);
            Storage::remove('data/users/mini_' . $user->image);

            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'delete', 'entity' => 'user#' . $id, 'time' => time()]);

            Request::addResponse('func', 'noticeSuccess', 'Deleted');
            Request::addResponse('remove', '#item_' . $id);
            Request::endAjax();
        } else {
            Request::returnError('Database error');
        }
    }

    public function archiveAction()
    {
        $this->view->team = TeamModel::getArchived();

        Request::setTitle('Archive Team Members');
    }

    public function resumeAction()
    {
        Request::ajaxPart();

        $id = intval(Request::getUri(0));
        $user = TeamModel::getUser($id);

        if (!$user)
            Request::returnError('Team error');

        $result = Model::update('users', ['deleted' => 'no'], "`id` = '" . $id . "'"); // Update row

        if ($result) {
            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'archive', 'entity' => 'user#' . $id, 'time' => time()]);

            Request::addResponse('func', 'noticeSuccess', 'Deleted');
            Request::addResponse('remove', '#item_' . $id);
            Request::endAjax();
        } else {
            Request::returnError('Database error');
        }

    }

    public function sortAction()
    {
        Request::ajaxPart(); // if not Ajax part load

        $userID = Request::getUri(1);
        $direction = Request::getUri(0);
        if ($direction != 'up') $direction = 'down';

        $user = TeamModel::getUser($userID);

        if (!$user)
            redirectAny(url('panel/team'));

        if (!$user->sort) { // if sort = 0
            $biggest = TeamModel::getBiggestSort();
            $data['sort'] = intval($biggest->sort) + 1;
            Model::update('users', $data, "`id` = '$userID'");
        } else { // if sort > 0
            if ($direction == 'up') {
                $smallest = TeamModel::getNextSmallestSort($user->sort);
                if (!$smallest)
                    Request::returnError('Already on the top');

                Model::update('users', ['sort' => $smallest->sort], "`id` = '$userID'");
                Model::update('users', ['sort' => $user->sort], "`id` = '" . ($smallest->id) . "'");
            } else {
                $biggest = TeamModel::getNextBiggestSort($user->sort);
                if (!$biggest)
                    Request::returnError('Already on the bottom');

                Model::update('users', ['sort' => $biggest->sort], "`id` = '$userID'");
                Model::update('users', ['sort' => $user->sort], "`id` = '" . ($biggest->id) . "'");
            }
        }

        redirectAny(url('panel/team'));
    }

    public function remove_funAction()
    {
        Request::ajaxPart(); // if not Ajax part load
        $id = post('id');
        $image = TeamModel::getUserImage($id);

        Model::delete('user_images', "`id` = '$id'");
        Storage::remove('data/fun/' . $image->image);
        Request::addResponse('remove', '#ft_' . $id, false);
    }

    public function vacanciesAction()
    {
        $id = intval(Request::getUri(0));

        $this->view->user = TeamModel::getUser($id);
        if (!$this->view->user)
            redirectAny(url('panel/team'));

        Model::import('panel/vacancies');
        $this->view->list = VacanciesModel::getVacanciesForConsultant($id);

        Request::setTitle('Consultant Vacancies');
    }
}
/* End of file */