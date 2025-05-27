<?php

class ShopsController extends Controller
{
    private static $numElement = 25;
    protected $layout = 'layout_panel';

    use Validator;
    use RecordVersion;

    public function indexAction()
    {
        $this->view->count = $count = ShopsModel::countActive();
        Pagination::calculate(post('page', 'int', 1), self::$numElement, $count);

        //search
        Model::import('panel/team');
        $user = TeamModel::getUser(User::get('id'));
        
        //search
        if (User::getRole() == 'moder') {
            $this->view->list = ShopsModel::getActive(" and `id` IN ('" . implode("', '", $user->shop_ids) . "')", 'id', 'DESC', Pagination::$start, Pagination::$end);
        }
        else
            $this->view->list = ShopsModel::getActive(false, 'id', 'DESC', Pagination::$start, Pagination::$end);
        $this->view->elemPerPage = self::$numElement;

        Request::setTitle('Shops');
    }

    // FOR Ajax Pagination
    public function paginationAction()
    {
        Request::ajaxPart();

        $page        = post('page', 'int', 1); // page
        $orderby     = post('orderby'); //field name
        $sort        = post('ordertype'); //asc desc
        $searchValue = post('search'); // search value

        //prepare query for search
        $where = "";

        if ($searchValue) {
            $where = " AND (`title` LIKE '%$searchValue%')";
        }

        $totalRecordWithFilter = ShopsModel::countActive($where);
        Pagination::calculate($page, self::$numElement, $totalRecordWithFilter);

        //search
        $this->view->list = ShopsModel::getActive($where, $orderby, $sort, Pagination::$start, Pagination::$end);

        Request::addResponse('html', '#table-body', $this->getView('modules/panel/modules/shops/views/_table_body.php'));

        if ($totalRecordWithFilter > self::$numElement) {
            Request::addResponse('html', '#pagination-box', Pagination::panelPagination('panel/shops/pagination', allPost()));
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
            $this->validatePost('title', 'Title', 'required|trim|min_length[1]|max_length[255]');

            if ($this->isValid()) {
                $data = [
                    'title' => post('title'),
                    'posted' => 'no',
                    'slug'  => Model::createIdentifier('shops', makeSlug(transliterateIfCyrillic(post('title')))),
                    'time'  => time()
                ];

                $result   = Model::insert('shops', $data); // Insert row
                $insertID = Model::insertID();

                if (!$result && $insertID) {

                    $this->makeVersion($insertID, 'shops', 'add');

                    Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'add', 'entity' => 'shops#' . $insertID, 'time' => time()]);

                    Request::addResponse('redirect', false, url('panel', 'shops', 'edit', $insertID));
                } else {
                    Request::returnError('Database error');
                }
            } else {
                if (Request::isAjax()) {
                    Request::returnErrors($this->validationErrors);
                }
            }
        }

        Request::setTitle('Add Shops');
    }

    public function editAction()
    {
        $id = intval(Request::getUri(0));
        $this->view->edit = ShopsModel::get($id);

        if (!$this->view->edit) {
            redirect(url('panel/shops'));
        }

        Model::import('panel/vacancies/sectors');
        $this->view->sectors = SectorsModel::getAll();

        Model::import('panel/team');
        $this->view->users = TeamModel::getActive(" and `role` IN ('master')");

        if ($this->startValidation()) {
            $this->validatePost('title',        'Title',                'required|trim|min_length[1]|max_length[200]');
            $this->validatePost('image',        'Image',                'required|trim|min_length[1]|max_length[100]');
            $this->validatePost('slug',         'Slug',                 'required|trim|min_length[1]|max_length[200]');
            $this->validatePost('sector_ids',   'Industries/Sectors',   'is_array');
            $this->validatePost('content',      'Page Content',         'required|trim|min_length[0]');

            if ($this->isValid()) {
                $data = array(
                    'title'     => post('title'),
                    'image'     => post('image'),
                    'content'   => post('content'),
                    'work_time' => post('work_time'),
                    'address'   => post('address'),
                    'address_link' => post('address_link'),
                    'posted'    => post('posted'),
                    'slug'      => Model::createIdentifier('shops', makeSlug(transliterateIfCyrillic(post('slug'))), 'slug', $this->view->edit->id),
                    'time'      => time(),
                    'time_from' => post('time_from'),
                    'time_to'   => post('time_to'),
                );

                // Copy and remove image
                if ($this->view->edit->image !== $data['image'] && $data['image']) {
                    Storage::entityImage('shops', $id, $data['image'], $this->view->edit->image,
                        600, 400, true);
                }

                //Copy file
                if ($data['file'] && $this->view->edit->file !== $data['file']) {
                    if (Storage::copy('data/tmp/' . $data['file'], 'data/shops/' . $data['file'])) {
                        Storage::remove('data/shops/' . $this->view->edit->file);
                    } else
                        print_data(error_get_last());
                }

                $result = Model::update('shops', $data, "`id` = '$id'");

                if ($result) {
                   //save alt attributes
                    ImageAlts::saveAlts(post('alt_attributes'), 'shops', $id);

                    //Versions
                    $this->makeVersion($id, 'shops', 'edit');

                     // Remove and after insert sectors
                    ShopsModel::removeSectors($id);
                    if (post('sector_ids')) {
                        foreach (post('sector_ids') as $sector_id) {
                            Model::insert('shops_sectors', array(
                                'shop_id' => $id,
                                'sector_id' => $sector_id
                            ));
                        }
                    }

                    ShopsModel::removeUsers($id);
                    if (is_array(post('user_ids')) && count(post('user_ids')) > 0) {
                        foreach (post('user_ids') as $user_id) {
                            Model::insert('users_shops', array(
                                'shop_id' => $id,
                                'user_id' => $user_id
                            ));
                        }
                    }

                    Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'edit', 'entity' => 'shops#' . $id, 'time' => time()]);

                    Request::addResponse('func', 'noticeSuccess', 'Saved');
                    Request::endAjax();
                } else {
                    Request::returnError('Database error');
                }
            } else {
                if (Request::isAjax()) {
                    Request::returnErrors($this->validationErrors);
                }
            }
        }

        Request::setTitle('Edit shops');
    }

    public function deleteAction()
    {
        Request::ajaxPart();

        $id = intval(Request::getUri(0));
        $item = ShopsModel::get($id);

        if (!$item) {
            Request::returnError('Shops error');
        }

        $data['deleted'] = 'yes';
        $result = Model::update('shops', $data, "`id` = '$id'"); // Update row

        if ($result) {

            $this->makeVersion($id, 'shops', 'delete');

            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'delete', 'entity' => 'shops#' . $id, 'time' => time()]);

            Request::addResponse('func', 'noticeSuccess', 'Removed');
            Request::addResponse('remove', '#item_' . $id);
            Request::endAjax();
        } else {
            Request::returnError('Database error');
        }
    }

    public function archiveAction()
    {
        $this->view->list = ShopsModel::getArchived();

        Request::setTitle('Archive Shops');
    }

    public function resumeAction()
    {
        $id = Request::getUri(0);
        $item = ShopsModel::get($id);

        if (!$item) {
            redirect(url('panel/shops/archive'));
        }

        $result = Model::update('shops', ['deleted' => 'no'], "`id` = '$id'"); // Update row

        if ($result) {
            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'restore', 'entity' => 'shops#' . $id, 'time' => time()]);
        } else {
            Request::returnError('Database error');
        }

        redirect(url('panel/shops/archive'));
    }
}
