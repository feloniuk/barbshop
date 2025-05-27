<?php

class DocumentsController extends Controller
{
    private static $numElement = 25;
    protected $layout = 'layout_panel';

    use Validator;
    use RecordVersion;

    public function indexAction()
    {
        $this->view->count = $count = DocumentsModel::countActive();
        Pagination::calculate(post('page', 'int', 1), self::$numElement, $count);

        //search
        $this->view->list = DocumentsModel::getActive(false, 'time', 'DESC', Pagination::$start, Pagination::$end);
        $this->view->elemPerPage = self::$numElement;

        Request::setTitle('Documents');
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

        $totalRecordWithFilter = DocumentsModel::countActive($where);
        Pagination::calculate($page, self::$numElement, $totalRecordWithFilter);

        //search
        $this->view->list = DocumentsModel::getActive($where, $orderby, $sort, Pagination::$start, Pagination::$end);

        Request::addResponse('html', '#table-body', $this->getView('modules/panel/modules/documents/views/_table_body.php'));

        if ($totalRecordWithFilter > self::$numElement) {
            Request::addResponse('html', '#pagination-box', Pagination::panelPagination('panel/documents/pagination', allPost()));
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
                    'time'  => time()
                ];

                $result   = Model::insert('documents', $data); // Insert row
                $insertID = Model::insertID();

                if (!$result && $insertID) {

                    $this->makeVersion($insertID, 'documents', 'add');

                    Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'add', 'entity' => 'documents#' . $insertID, 'time' => time()]);

                    Request::addResponse('redirect', false, url('panel', 'documents', 'edit', $insertID));
                } else {
                    Request::returnError('Database error');
                }
            } else {
                if (Request::isAjax()) {
                    Request::returnErrors($this->validationErrors);
                }
            }
        }

        Request::setTitle('Add Documents');
    }

    public function editAction()
    {
        $id = intval(Request::getUri(0));
        $this->view->edit = DocumentsModel::get($id);

        if (!$this->view->edit) {
            redirect(url('panel/documents'));
        }

        if ($this->startValidation()) {
            $this->validatePost('title', 'Title', 'required|trim|min_length[1]|max_length[200]');

            if ($this->isValid()) {
                $data = array(
                    'title' => post('title'),
                    'time'  => time()
                );

                $result = Model::update('documents', $data, "`id` = '$id'");

                if ($result) {
                    //Versions
                    $this->makeVersion($id, 'documents', 'edit');

                    Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'edit', 'entity' => 'documents#' . $id, 'time' => time()]);

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

        Request::setTitle('Edit documents');
    }

    public function deleteAction()
    {
        Request::ajaxPart();

        $id = intval(Request::getUri(0));
        $item = DocumentsModel::get($id);

        if (!$item) {
            Request::returnError('Documents error');
        }

        $data['deleted'] = 'yes';
        $result = Model::update('documents', $data, "`id` = '$id'"); // Update row

        if ($result) {

            $this->makeVersion($id, 'documents', 'delete');

            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'delete', 'entity' => 'documents#' . $id, 'time' => time()]);

            Request::addResponse('func', 'noticeSuccess', 'Removed');
            Request::addResponse('remove', '#item_' . $id);
            Request::endAjax();
        } else {
            Request::returnError('Database error');
        }
    }

    public function archiveAction()
    {
        $this->view->list = DocumentsModel::getArchived();

        Request::setTitle('Archive Documents');
    }

    public function resumeAction()
    {
        $id = Request::getUri(0);
        $item = DocumentsModel::get($id);

        if (!$item) {
            redirect(url('panel/documents/archive'));
        }

        $result = Model::update('documents', ['deleted' => 'no'], "`id` = '$id'"); // Update row

        if ($result) {
            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'restore', 'entity' => 'documents#' . $id, 'time' => time()]);
        } else {
            Request::returnError('Database error');
        }

        redirect(url('panel/documents/archive'));
    }
}
