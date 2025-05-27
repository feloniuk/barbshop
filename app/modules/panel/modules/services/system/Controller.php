<?php

class ServicesController extends Controller
{
    private static $numElement = 25;
    protected $layout = 'layout_panel';

    use Validator;
    use RecordVersion;

    public function indexAction()
    {
        $this->view->count = $count = ServicesModel::countActive();
        Pagination::calculate(post('page', 'int', 1), self::$numElement, $count);

        //search
        $this->view->list = ServicesModel::getActive(false, 'time', 'DESC', Pagination::$start, Pagination::$end);
        $this->view->elemPerPage = self::$numElement;

        Request::setTitle('Services');
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

        $totalRecordWithFilter = ServicesModel::countActive($where);
        Pagination::calculate($page, self::$numElement, $totalRecordWithFilter);

        //search
        $this->view->list = ServicesModel::getActive($where, $orderby, $sort, Pagination::$start, Pagination::$end);

        Request::addResponse('html', '#table-body', $this->getView('modules/panel/modules/services/views/_table_body.php'));

        if ($totalRecordWithFilter > self::$numElement) {
            Request::addResponse('html', '#pagination-box', Pagination::panelPagination('panel/services/pagination', allPost()));
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
                    'slug'  => Model::createIdentifier('services', makeSlug(post('title'))),
                    'time'  => time()
                ];

                $result   = Model::insert('services', $data); // Insert row
                $insertID = Model::insertID();

                if (!$result && $insertID) {

                    $this->makeVersion($insertID, 'services', 'add');

                    Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'add', 'entity' => 'services#' . $insertID, 'time' => time()]);

                    Request::addResponse('redirect', false, url('panel', 'services', 'edit', $insertID));
                } else {
                    Request::returnError('Database error');
                }
            } else {
                if (Request::isAjax()) {
                    Request::returnErrors($this->validationErrors);
                }
            }
        }

        Request::setTitle('Add Services');
    }

    public function editAction()
    {
        $id = intval(Request::getUri(0));
        $this->view->edit = ServicesModel::get($id);

        if (!$this->view->edit) {
            redirect(url('panel/services'));
        }

        Model::import('panel/vacancies/sectors');
        $this->view->sectors = SectorsModel::getAll();

        if ($this->startValidation()) {
            $this->validatePost('title',        'Title',                'required|trim|min_length[1]|max_length[200]');
            $this->validatePost('image',        'Image',                'required|trim|min_length[1]|max_length[100]');
            $this->validatePost('sector_ids',   'Industries/Sectors',   'is_array');
            $this->validatePost('content',      'Page Content',         'required|trim|min_length[0]');

            if ($this->isValid()) {
                $data = array(
                    'title'   => post('title'),
                    'image'   => post('image'),
                    'price'   => post('price'),
                    'service_time'    => post('service_time'),
                    'content' => post('content'),
                    'posted'  => post('posted'),
                    'slug'    => Model::createIdentifier('services', post('title'), 'slug', $this->view->edit->id),
                    'time'    => time()
                );

                // Copy and remove image
                if ($this->view->edit->image !== $data['image'] && $data['image']) {
                    Storage::entityImage('services', $id, $data['image'], $this->view->edit->image);
                }

                //Copy file
                if ($data['file'] && $this->view->edit->file !== $data['file']) {
                    if (Storage::copy('data/tmp/' . $data['file'], 'data/services/' . $data['file'])) {
                        Storage::remove('data/services/' . $this->view->edit->file);
                    } else
                        print_data(error_get_last());
                }

                $result = Model::update('services', $data, "`id` = '$id'");

                if ($result) {
                   //save alt attributes
                    ImageAlts::saveAlts(post('alt_attributes'), 'services', $id);

                    //Versions
                    $this->makeVersion($id, 'services', 'edit');

                     // Remove and after insert sectors
                    ServicesModel::removeSectors($id);
                    if (post('sector_ids')) {
                        foreach (post('sector_ids') as $sector_id) {
                            Model::insert('services_sectors', array(
                                'service_id' => $id,
                                'sector_id' => $sector_id
                            ));
                        }
                    }

                    Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'edit', 'entity' => 'services#' . $id, 'time' => time()]);

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

        Request::setTitle('Edit services');
    }

    public function deleteAction()
    {
        Request::ajaxPart();

        $id = intval(Request::getUri(0));
        $item = ServicesModel::get($id);

        if (!$item) {
            Request::returnError('Services error');
        }

        $data['deleted'] = 'yes';
        $result = Model::update('services', $data, "`id` = '$id'"); // Update row

        if ($result) {

            $this->makeVersion($id, 'services', 'delete');

            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'delete', 'entity' => 'services#' . $id, 'time' => time()]);

            Request::addResponse('func', 'noticeSuccess', 'Removed');
            Request::addResponse('remove', '#item_' . $id);
            Request::endAjax();
        } else {
            Request::returnError('Database error');
        }
    }

    public function archiveAction()
    {
        $this->view->list = ServicesModel::getArchived();

        Request::setTitle('Archive Services');
    }

    public function resumeAction()
    {
        $id = Request::getUri(0);
        $item = ServicesModel::get($id);

        if (!$item) {
            redirect(url('panel/services/archive'));
        }

        $result = Model::update('services', ['deleted' => 'no'], "`id` = '$id'"); // Update row

        if ($result) {
            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'restore', 'entity' => 'services#' . $id, 'time' => time()]);
        } else {
            Request::returnError('Database error');
        }

        redirect(url('panel/services/archive'));
    }
}
