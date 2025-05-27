<?php
class UploadsController extends Controller
{
    private static $numElement = 25;
    protected $layout = 'layout_panel';

    use Validator;

    public function indexAction()
    {
        $this->view->count = $count = UploadsModel::countActive();
        Pagination::calculate(post('page', 'int', 1), self::$numElement, $count);

        //search
        $this->view->list = UploadsModel::getActive(false, 'id', 'DESC', Pagination::$start, Pagination::$end);
        $this->view->elemPerPage = self::$numElement;

        Request::setTitle('Files');
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

        $totalRecordWithFilter = UploadsModel::countActive($where);
        Pagination::calculate($page, self::$numElement, $totalRecordWithFilter);

        //search
        $this->view->list = UploadsModel::getActive($where, $orderby, $sort, Pagination::$start, Pagination::$end);

        Request::addResponse('html', '#table-body', $this->getView('modules/panel/modules/uploads/views/_table_body.php'));

        if ($totalRecordWithFilter > self::$numElement) {
            Request::addResponse('html', '#pagination-box', Pagination::panelPagination('panel/uploads/pagination', allPost()));
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
        $this->view->list = UploadsModel::getArchived();

        Request::setTitle('Archive Files');
    }

    public function resumeAction()
    {
        $id = (Request::getUri(0));
        $user = UploadsModel::get($id);

        if (!$user)
            redirect(url('panel/uploads/archive'));

        $result = Model::update('uploads', ['deleted' => 'no'], "`id` = '$id'"); // Update row

        if ($result) {
            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'restore', 'entity' => 'document#' . $id, 'time' => time()]);
        } else {
            Request::returnError('Database error');
        }

        redirect(url('panel/uploads/archive'));

    }

    public function addAction()
    {
        Model::import('panel/team');
        $this->view->team = TeamModel::getAllUsers();

        if ($this->startValidation()) {
            $this->validatePost('name',             'Name',           'required|trim|min_length[1]|max_length[200]');

            if ($this->isValid()) {
                $data = array(
                    'name'         => post('name'),
                    'slug'         => Model::createIdentifier('uploads', makeSlug(post('name'))),
                );

                $result   = Model::insert('uploads', $data); // Insert row
                $insertID = Model::insertID();

                if (!$result && $insertID) {
                    Request::addResponse('redirect', false, url('panel', 'uploads', 'edit', $insertID));
                } else {
                    Request::returnError('Database error');
                }
            } else {
                if (Request::isAjax())
                    Request::returnErrors($this->validationErrors);
            }
        }

        Request::setTitle('Add File');
    }

    public function editAction()
    {
        $id = intval(Request::getUri(0));
        $this->view->edit = UploadsModel::get($id);

        if (!$this->view->edit)
            redirect(url('panel/uploads'));

        Model::import('panel/team');
        $this->view->team = TeamModel::getAllUsers();

        if ($this->startValidation()) {
            $this->validatePost('name',                      'Name',           'required|trim|min_length[1]|max_length[200]');
            $this->validatePost('file',                      'File',           'required|trim|min_length[1]|max_length[200]');

            if ($this->isValid()) {
                $data = array(
                    'name'         => post('name'),
                    'file'         => post('file'),
                    'slug'         => Model::createIdentifier('uploads', post('slug'), 'slug', $this->view->edit->id),
                );

                // Copy and remove file
                if ($data['file'] && $data['file'] !== '') {
                    if ($this->view->edit->file !== $data['file']) {
                        if (Storage::copy('data/tmp/' . $data['file'], 'data/uploads/' . $data['file'])) {
                            Storage::remove('data/uploads/' . $this->view->edit->file);
                        } else
                            print_data(error_get_last());
                    }
                }

                $result = Model::update('uploads', $data, "`id` = '$id'"); // Update row

                if ($result) {
//                    Request::addResponse('redirect', false, url('panel', 'uploads', 'edit', $id));
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

        Request::setTitle('Edit File');
    }

    public function deleteAction()
    {
        $id = (Request::getUri(0));
        $user = UploadsModel::get($id);

        if (!$user)
            redirect(url('panel/uploads'));

        $data['deleted'] = 'yes';
        $result = Model::update('uploads', $data, "`id` = '$id'"); // Update row

        if ($result) {
//            $this->session->set_flashdata('success', 'Document created successfully.');
//            Request::addResponse('redirect', false, url('panel', 'uploads', 'edit', $insertID));
        } else {
            Request::returnError('Database error');
        }

        redirect(url('panel/uploads'));
    }
}
/* End of file */