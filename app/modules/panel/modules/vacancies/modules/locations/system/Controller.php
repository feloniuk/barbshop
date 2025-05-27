<?php
class LocationsController extends Controller
{
    private static $numElement = 25;
    protected $layout = 'layout_panel';

    use Validator, RecordVersion;

    public function indexAction()
    {
        $this->view->count = $count = LocationsModel::countActive();
        Pagination::calculate(post('page', 'int', 1), self::$numElement, $count);

        //search
        $this->view->list = LocationsModel::getActive(false, 'id', 'DESC', Pagination::$start, Pagination::$end);
        $this->view->elemPerPage = self::$numElement;

        Request::setTitle('Locations');
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

        $totalRecordWithFilter = LocationsModel::countActive($where);
        Pagination::calculate($page, self::$numElement, $totalRecordWithFilter);

        //search
        $this->view->list = LocationsModel::getActive($where, $orderby, $sort, Pagination::$start, Pagination::$end);

        Request::addResponse('html', '#table-body', $this->getView('modules/panel/modules/vacancies/modules/locations/views/_table_body.php'));

        if ($totalRecordWithFilter > self::$numElement) {
            Request::addResponse('html', '#pagination-box', Pagination::panelPagination('panel/vacancies/locations/pagination', allPost()));
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
        $this->view->list = LocationsModel::getArchived();

        Request::setTitle('Archived Locations');
    }

    public function resumeAction()
    {
        $id = (Request::getUri(0));
        $user = LocationsModel::get($id);

        if (!$user)
            redirect(url('panel/vacancies/locations/archive'));

        $result = Model::update('locations', ['deleted' => 'no'], "`id` = '$id'"); // Update row

        if ($result) {
            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'restore', 'entity' => 'locations#' . $id, 'time' => time()]);
        } else {
            Request::returnError('Database error');
        }

        redirect(url('panel/vacancies/locations/archive'));

    }

    public function addAction()
    {
        if ($this->startValidation()) {
            $this->validatePost('name', 'Name', 'required|trim|min_length[1]|max_length[200]');

            if ($this->isValid()) {
                $data = array(
                    'name' => post('name')
                );

                $result   = Model::insert('locations', $data); // Insert row
                $insertID = Model::insertID();

                if (!$result && $insertID) {
                    $this->makeVersion($insertID, 'locations', 'add');

                    Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'add', 'entity' => 'locations#' . $insertID, 'time' => time()]);

//                    $this->session->set_flashdata('success', 'Location created successfully.');
                    Request::addResponse('redirect', false, url('panel', 'vacancies', 'locations', 'edit', $insertID));
                } else {
                    Request::returnError('Database error');
                }
            } else {
                if (Request::isAjax()) {
//                    Request::addResponse('func', 'noticeError', Request::returnErrors($this->validationErrors, true));
                    Request::returnErrors($this->validationErrors);
                }
            }
        }

        Request::setTitle('Add Location');
    }

    public function editAction()
    {
        $id = intval(Request::getUri(0));
        $this->view->sector = LocationsModel::get($id);

        if (!$this->view->sector)
            redirect(url('panel/vacancies/locations'));

        if ($this->startValidation()) {
            $this->validatePost('name', 'Name', 'required|trim|min_length[1]|max_length[200]');


            if ($this->isValid()) {
                $data = array(
                    'name' => post('name')
                );

                $result = Model::update('locations', $data, "`id` = '$id'"); // Update row

                if ($result) {
                    $this->makeVersion($id, 'locations', 'edit');

                    Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'edit', 'entity' => 'locations#' . $id, 'time' => time()]);

//                    $this->session->set_flashdata('success', 'Location created successfully.');
//                    Request::addResponse('redirect', false, url('panel', 'locations', 'edit', $id));
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

        Request::setTitle('Edit Location');
    }

    public function deleteAction()
    {
        Request::ajaxPart();

        $id = intval(Request::getUri(0));
        $user = LocationsModel::get($id);

        if (!$user)
            Request::returnError('Location error');

        $data['deleted'] = 'yes';
        $result = Model::update('locations', $data, "`id` = '$id'"); // Update row

        if ($result) {
            $this->makeVersion($id, 'locations', 'delete');

            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'delete', 'entity' => 'locations#' . $id, 'time' => time()]);

            Request::addResponse('func', 'noticeSuccess', 'Removed');
            Request::addResponse('remove', '#item_' . $id);
            Request::endAjax();
        } else {
            Request::returnError('Database error');
        }
    }
}
/* End of file */