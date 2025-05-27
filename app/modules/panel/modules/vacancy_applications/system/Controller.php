<?php
class Vacancy_applicationsController extends Controller
{
    private static $numElement = 25;
    protected $layout = 'layout_panel';

    use Validator;

    public function indexAction()
    {
        $this->view->count = $count = Vacancy_applicationsModel::countActive();
        Pagination::calculate(post('page', 'int', 1), self::$numElement, $count);

        //search
        $this->view->list = Vacancy_applicationsModel::getActive(false, 'time', 'DESC', Pagination::$start, Pagination::$end);
        $this->view->elemPerPage = self::$numElement;

        Request::setTitle('Vacancy Applications');
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
            $mainWhere = Vacancy_applicationsModel::getByVacancies($searchValue);

            $where = " AND (`name` LIKE '%$searchValue%' OR `email` LIKE '%$searchValue%') $mainWhere";
        }

        $totalRecordWithFilter = Vacancy_applicationsModel::countActive($where);
        Pagination::calculate($page, self::$numElement, $totalRecordWithFilter);

        //search
        $this->view->list = Vacancy_applicationsModel::getActive($where, $orderby, $sort, Pagination::$start, Pagination::$end);

        Request::addResponse('html', '#table-body', $this->getView('modules/panel/modules/vacancy_applications/views/_table_body.php'));

        if ($totalRecordWithFilter > self::$numElement) {
            Request::addResponse('html', '#pagination-box', Pagination::panelPagination('panel/vacancy_applications/pagination', allPost()));
        } else {
            Request::addResponse('html', '#pagination-box', '');
        }

        if (!$this->view->list) {
            Request::addResponse('html', '#pagination-box', '<div class="mt-4"><p>Results not found</p></div>');
        }

        Request::endAjax();
    }

    public function pagination_cvsAction()
    {
        Request::ajaxPart();

        $page        = post('page', 'int', 1); // page
        $orderby     = post('orderby'); //field name
        $sort        = post('ordertype'); //asc desc
        $searchValue = post('search'); // search value

        //prepare query for search
        $where = "";

        if ($searchValue) {
            $where = " AND (`name` LIKE '%$searchValue%' OR `email` LIKE '%$searchValue%')";
        }

        $totalRecordWithFilter = Vacancy_applicationsModel::countActiveCv($where);
        Pagination::calculate($page, self::$numElement, $totalRecordWithFilter);

        //search
        $this->view->list = Vacancy_applicationsModel::getActiveCv($where, $orderby, $sort, Pagination::$start, Pagination::$end);

        Request::addResponse('html', '#table-body', $this->getView('modules/panel/modules/vacancy_applications/views/_table_body_cv.php'));

        if ($totalRecordWithFilter > self::$numElement) {
            Request::addResponse('html', '#pagination-box', Pagination::panelPagination('panel/vacancy_applications/pagination_cvs', allPost()));
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
        $this->view->list = Vacancy_applicationsModel::getArchived();

        Request::setTitle('Archived Vacancy Applications');
    }

    public function resumeAction()
    {
        $id = (Request::getUri(0));
        $user = Vacancy_applicationsModel::get($id);

        if (!$user)
            redirect(url('panel/vacancy_applications/archive'));

        $result = Model::update('cv_library', ['deleted' => 'no'], "`id` = '$id'"); // Update row

        if ($result) {
            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'restore', 'entity' => 'vacancy_application#' . $id, 'time' => time()]);
        } else {
            Request::returnError('Database error');
        }

        redirect(url('panel/vacancy_applications/archive'));

    }

    public function editAction()
    {
        $id = intval(Request::getUri(0));
        $this->view->edit = Vacancy_applicationsModel::get($id);

        if (!$this->view->edit)
            redirect(url('panel/vacancy_applications'));

        if (!$this->view->edit->status) {
            Model::update('cv_library', ['status' => 'reviewed'], "`id` = '$id'");
        }

        if ($this->startValidation()) {
            $this->validatePost('name',         'Full name',            'required|trim|min_length[1]|max_length[200]');
            $this->validatePost('email',        'Email',                'trim|min_length[1]|max_length[200]');
            $this->validatePost('tel',          'Contact number',       'trim|min_length[1]|max_length[200]');
            $this->validatePost('linkedin',     'LinkedIn',             'trim|min_length[1]|max_length[200]|url');
            $this->validatePost('message',      'Message',              'trim|min_length[1]');

            if ($this->isValid()) {
                $data = array(
                    'name'      => post('name'),
                    'email'     => post('email'),
                    'tel'       => post('tel'),
                    'linkedin'  => post('linkedin'),
                    'message'   => post('message'),
                );


                $result = Model::update('cv_library', $data, "`id` = '$id'"); // Update row

                if ($result) {
//                    Request::addResponse('redirect', false, url('panel', 'vacancy_applications', 'edit', $id));
                    Request::addResponse('func', 'noticeSuccess', 'Saved');
                } else {
                    Request::returnError('Database error');
                }
            } else {
                if (Request::isAjax())
                    Request::returnErrors($this->validationErrors);
            }
        }

        Request::setTitle('Edit Vacancy Applications');

    }

    public function export_dataAction()
    {
        Request::ajaxPart();

        if ($this->startValidation()) {
            $this->validatePost('type', 'Type', 'required');

            if ($this->isValid()) {

                $data = Model::fetchAll(Model::select('talent_pool_cv', " `deleted` = 'no' ORDER BY `time` DESC"));

                if (is_array($data) && count($data) > 0) {

                    //prepare data
                    $dataToCsv = [];
                    $i = 0;
                    foreach ($data as $item) {
                        $dataToCsv[$i]['id'] = $item->id;
                        $dataToCsv[$i]['name'] = $item->name;
                        $dataToCsv[$i]['email'] = $item->email;
                        $dataToCsv[$i]['date submitted'] = date('m.d.Y', $item->time);
                        $dataToCsv[$i]['cv link'] = SITE_URL . _SITEDIR_ . 'data/cvs/' . $item->cv ;

                        $i++;
                    }

                    $df = fopen("app/data/tmp/export.csv", 'w');
                    fputcsv($df, array_keys(reset($dataToCsv)), ';');
                    foreach ($dataToCsv as $row) {
                        fputcsv($df, $row, ';');
                    }
                    fclose($df);

                    Request::addResponse('func', 'downloadFile', _SITEDIR_ . 'data/tmp/export.csv');
                    Request::endAjax();
                } else {
                    Request::returnError('No Data');
                }
            } else {
                if (Request::isAjax())
                    Request::returnErrors($this->validationErrors);
            }
        }

    }

    public function submited_cvAction()
    {
        $this->view->count = $count = Vacancy_applicationsModel::countActiveCv();
        Pagination::calculate(post('page', 'int', 1), self::$numElement, $count);

        //search
        $this->view->list = Vacancy_applicationsModel::getActiveCv(false, 'time', 'DESC', Pagination::$start, Pagination::$end);
        $this->view->elemPerPage = self::$numElement;

        Request::setTitle('Uploaded CVs');
    }


    public function submited_popupAction()
    {
        Request::ajaxPart();

        $id = intval(Request::getUri(0));
        $this->view->apply = Vacancy_applicationsModel::getCv($id);

        if (!$this->view->apply)
            redirect(url('panel/vacancy_applications/submited_cv'));

        if (!$this->view->apply->status) {
            Model::update('talent_pool_cv', ['status' => 'reviewed'], "`id` = '$id'");

            $el = applicationStatus('reviewed');
            $select = '<div class="fs-item ' . $el['class'] . '">' . $el['title'] . '</div>';
            Request::addResponse('html', '#status_text_' . $id, $select);
            Request::addResponse('html', '#popup_status', $select);
        }

        Request::addResponse('html', '#popup', $this->getView());
    }


    public function change_cv_statusAction()
    {
        Request::ajaxPart();

        if ($this->startValidation()) {
            $status = $this->validatePost('status',   'status',   'required|trim|min_length[1]|max_length[15]');

            switch ($status) {
                case 'spoken':
                case 'interviewed':
                case 'shortlisted':
                case 'rejected':
                    break;

                default:
                    $status = 'reviewed';
            }

            if ($this->isValid()) {
                $id = intval(Request::getUri(0));

                $result = Model::update('talent_pool_cv', ['status' => $status], "`id` = '$id'"); // Update row

                if ($result) {
                    Request::addResponse('func', 'noticeSuccess', 'Saved');
                    Request::addResponse('func', 'closeStatusBlock');
                    $el = applicationStatus($status);
                    $select = '<div class="fs-item ' . $el['class'] . '">' . $el['title'] . '</div>';
                    Request::addResponse('html', '#status_text_' . $id, $select);
                    Request::addResponse('html', '#popup_status', $select);
                } else {
                    Request::returnError('Database error');
                }
            } else {
                if (Request::isAjax())
                    Request::returnErrors($this->validationErrors);
            }
        }
    }


    public function cvs_archiveAction()
    {
        $this->view->list = Model::fetchAll(Model::select('talent_pool_cv', " `deleted` = 'yes' ORDER BY `time`"));

        Request::setTitle('Archived CVS');
    }

    public function cvs_resumeAction()
    {
        $id = (Request::getUri(0));
        $user = Model::fetch(Model::select('talent_pool_cv', " `deleted` = 'yes' and `id` = '$id'"));

        if (!$user)
            redirect(url('panel/vacancy_applications/cvs_archive'));

        $result = Model::update('talent_pool_cv', ['deleted' => 'no'], "`id` = '$id'"); // Update row

        if ($result) {
            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'restore', 'entity' => 'talent_pool_cv#' . $id, 'time' => time()]);
        } else {
            Request::returnError('Database error');
        }

        redirect(url('panel/vacancy_applications/cvs_archive'));

    }

    public function cv_deleteAction()
    {
        $id = (Request::getUri(0));
        $user = Vacancy_applicationsModel::getCv($id);

        if (!$user)
            redirect(url('panel/vacancy_applications/submited_cv'));


        $data['deleted'] = 'yes';
        $result = Model::update('talent_pool_cv', $data, " `id` = '$id'"); // Update row

        if ($result) {
//            $this->session->set_flashdata('success', 'Vacancy created successfully.');
//            Request::addResponse('redirect', false, url('panel', 'vacancy_applications', 'edit', $insertID));
        } else {
            Request::returnError('Database error');
        }

        redirect(url('panel/vacancy_applications/submited_cv'));
    }

    public function deleteAction()
    {
        Request::ajaxPart();

        $id = intval(Request::getUri(0));
        $user = Vacancy_applicationsModel::get($id);

        if (!$user)
            Request::returnError('Application error');

        $data['deleted'] = 'yes';
        $result = Model::update('cv_library', $data, "`id` = '$id'"); // Update row

        if ($result) {
            Request::addResponse('func', 'noticeSuccess', 'Removed');
            Request::addResponse('remove', '#item_' . $id);
            Request::endAjax();
        } else {
            Request::returnError('Database error');
        }
    }
}
/* End of file */