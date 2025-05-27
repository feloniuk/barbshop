<?php
class SectorsController extends Controller
{
    private static $numElement = 25;
    protected $layout = 'layout_panel';

    use Validator, RecordVersion;

    public function indexAction()
    {
        $this->view->count = $count = SectorsModel::countActive();
        Pagination::calculate(post('page', 'int', 1), self::$numElement, $count);

        //search
            $this->view->list = SectorsModel::getActive(false, 'id', 'DESC', Pagination::$start, Pagination::$end);
        
        $this->view->elemPerPage = self::$numElement;

        Request::setTitle('Industry Sectors');
    }

    public function paginationAction()
    {
        Request::ajaxPart();

        $page        = post('page', 'int', 1); // page
        $orderby     = post('orderby'); //field name
        $sort        = post('ordertype'); //asc desc
        $searchValue = post('search'); // search value

        //prepare query for search
        $where = " ";

        if ($searchValue) {
            $where = " AND `name` LIKE '%$searchValue%'";
        }

        $totalRecordWithFilter = SectorsModel::countActive($where);
        Pagination::calculate($page, self::$numElement, $totalRecordWithFilter);

        //search
        $this->view->list = SectorsModel::getActive($where, $orderby, $sort, Pagination::$start, Pagination::$end);

        Request::addResponse('html', '#table-body', $this->getView('modules/panel/modules/shops/modules/sectors/views/_table_body.php'));

        if ($totalRecordWithFilter > self::$numElement) {
            Request::addResponse('html', '#pagination-box', Pagination::panelPagination('panel/shops/sectors/pagination', allPost()));
        } else {
            Request::addResponse('html', '#pagination-box', '');
        }

        if (!$this->view->list) {
            Request::addResponse('html', '#pagination-box', '<div class="mt-4"><p>Results not found</p></div>');
        }

        Request::endAjax();
    }

    public function archiveAction()
    {
        $this->view->list = SectorsModel::getArchived();

        Request::setTitle('Archived Sectors');
    }

    public function resumeAction()
    {
        $id = (Request::getUri(0));
        $user = SectorsModel::get($id);

        if (!$user)
            redirect(url('panel/shops/sectors/archive'));

        $result = Model::update('shops_sectors', ['deleted' => 'no'], "`id` = '$id'"); // Update row

        if ($result) {
            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'restore', 'entity' => 'sector#' . $id, 'time' => time()]);
        } else {
            Request::returnError('Database error');
        }

        redirect(url('panel/shops/sectors/archive'));

    }

    public function addAction()
    {
        if ($this->startValidation()) {
            $this->validatePost('name',             'Name',           'required|trim|min_length[1]|max_length[200]');

            if ($this->isValid()) {
                $data = array(
                    'name'          => post('name'),
                );

                $result   = Model::insert('shops_sectors', $data); // Insert row
                $insertID = Model::insertID();

                if (!$result && $insertID) {
                    $this->makeVersion($insertID, 'shops_sectors', 'add');

                    Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'add', 'entity' => 'sectors#' . $insertID, 'time' => time()]);

                    //                    $this->session->set_flashdata('success', 'User created successfully.');
                    Request::addResponse('redirect', false, url('panel', 'shops', 'sectors', 'edit', $insertID));
                } else {
                    Request::returnError('Database error');
                }
            } else {
                if (Request::isAjax())
                    Request::returnErrors($this->validationErrors);
            }
        }

        Request::setTitle('Add Industry Sector');
    }

    public function editAction()
    {
        $id = intval(Request::getUri(0));
        $this->view->edit = SectorsModel::get($id);

        if (!$this->view->edit)
            redirect(url('panel/shops/sectors'));

        if ($this->startValidation()) {
            $this->validatePost('name',             'Name',           'required|trim|min_length[1]|max_length[200]');

            if ($this->isValid()) {
                $data = array(
                    'name'          => post('name'),
                );

                $result = Model::update('shops_sectors', $data, "`id` = '$id'"); // Update row

                if ($result) {
                    $this->makeVersion($id, 'shops_sectors', 'edit');

                    Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'edit', 'entity' => 'sectors#' . $id, 'time' => time()]);

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

        Request::setTitle('Edit Industry Sector');
    }

    public function deleteAction()
    {
        Request::ajaxPart();

        $id = intval(Request::getUri(0));
        $user = SectorsModel::get($id);

        if (!$user)
            Request::returnError('Archived Sectors error');

        $data['deleted'] = 'yes';
        $result = Model::update('shops_sectors', $data, "`id` = '$id'"); // Update row

        if ($result) {
            $this->makeVersion($id, 'shops_sectors', 'delete');

            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'delete', 'entity' => 'sectors#' . $id, 'time' => time()]);

            Request::addResponse('func', 'noticeSuccess', 'Removed');
            Request::addResponse('remove', '#item_' . $id);
            Request::endAjax();
        } else {
            Request::returnError('Database error');
        }
    }
}
/* End of file */
