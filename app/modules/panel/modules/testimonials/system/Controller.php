<?php
class TestimonialsController extends Controller
{
    private static $numElement = 25;
    protected $layout = 'layout_panel';

    use Validator, RecordVersion;

    public function indexAction()
    {
        $this->view->count = $count = TestimonialsModel::countActive();
        Pagination::calculate(post('page', 'int', 1), self::$numElement, $count);

        //search
        $this->view->list = TestimonialsModel::getActive(false, 'id', 'DESC', Pagination::$start, Pagination::$end);
        $this->view->elemPerPage = self::$numElement;

        Request::setTitle('Testimonials');
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

        $totalRecordWithFilter = TestimonialsModel::countActive($where);
        Pagination::calculate($page, self::$numElement, $totalRecordWithFilter);

        //search
        $this->view->list = TestimonialsModel::getActive($where, $orderby, $sort, Pagination::$start, Pagination::$end);

        Request::addResponse('html', '#table-body', $this->getView('modules/panel/modules/testimonials/views/_table_body.php'));

        if ($totalRecordWithFilter > self::$numElement) {
            Request::addResponse('html', '#pagination-box', Pagination::panelPagination('panel/testimonials/pagination', allPost()));
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
        $this->view->list = TestimonialsModel::getArchived();

        Request::setTitle('Archive Testimonials');
    }

    public function resumeAction()
    {
        $id = (Request::getUri(0));
        $user = TestimonialsModel::get($id);

        if (!$user)
            redirect(url('panel/testimonials/archive'));

        $result = Model::update('testimonials', ['deleted' => 'no'], "`id` = '$id'"); // Update row

        if ($result) {
            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'restore', 'entity' => 'testimonial#' . $id, 'time' => time()]);
        } else {
            Request::returnError('Database error');
        }

        redirect(url('panel/testimonials/archive'));

    }

    public function addAction()
    {
        Model::import('panel/team');
        $this->view->team = TeamModel::getAllUsers();

        if ($this->startValidation()) {
            $this->validatePost('name',             'Name',           'required|trim|min_length[1]|max_length[200]');

            if ($this->isValid()) {
                $data = array(
                    'name'     => post('name'),
                );

                $result   = Model::insert('testimonials', $data); // Insert row
                $insertID = Model::insertID();

                if (!$result && $insertID) {

                    $this->makeVersion($insertID, 'testimonials', 'add');

                    Request::addResponse('redirect', false, url('panel', 'testimonials', 'edit', $insertID));
                } else {
                    Request::returnError('Database error');
                }
            } else {
                if (Request::isAjax())
                    Request::returnErrors($this->validationErrors);
            }
        }

        Request::setTitle('Add Testimonial');
    }

    public function editAction()
    {
        $id = intval(Request::getUri(0));
        $this->view->testimonial = TestimonialsModel::get($id);

        if (!$this->view->testimonial)
            redirect(url('panel/testimonials'));

        Model::import('panel/team');
        $this->view->team = TeamModel::getAllUsers();

        if ($this->startValidation()) {
            $this->validatePost('name',                      'Name',           'required|trim|min_length[1]|max_length[200]');
            $this->validatePost('position',                  'Position',       'trim|min_length[1]|max_length[100]');
            $image = $this->validatePost('image',            'Image',          'trim|min_length[1]|max_length[100]');
            $user_image = $this->validatePost('user_image',  'User Image',     'trim|min_length[1]|max_length[100]');
            $this->validatePost('content',                   'Page Content',   'required|trim|min_length[0]');

            if ($user_image == 0) {
                $this->validatePost('image', 'Image', 'required|trim|min_length[1]|max_length[100]');
            } else if (!$image) {
                $this->validatePost('user_image', 'User Image', 'required|trim|min_length[1]|max_length[100]');
            }

            if ($this->isValid()) {
                $data = array(
                    'name'       => post('name'),
                    'position'   => post('position'),
                    'image'      => post('image'),
                    'user_image' => post('user_image', 'int', 0),
                    'content'    => post('content')
                );

                // Copy and remove image
                if ($this->view->testimonial->image !== $data['image'] && $data['image']) {
                    Storage::entityImage('testimonials', $id, $data['image'], $this->view->testimonial->image);
                }

                $result = Model::update('testimonials', $data, "`id` = '$id'"); // Update row

                if ($result) {
                    $this->makeVersion($id, 'testimonials', 'edit');

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

        Request::setTitle('Edit Testimonial');
    }

    public function deleteAction()
    {
        Request::ajaxPart();

        $id = intval(Request::getUri(0));
        $user = TestimonialsModel::get($id);

        if (!$user)
            Request::returnError('Vacancy error');

        $data['deleted'] = 'yes';
        $result = Model::update('testimonials', $data, "`id` = '$id'"); // Update row

        if ($result) {

            $this->makeVersion($id, 'testimonials', 'delete');

            Request::addResponse('func', 'noticeSuccess', 'Removed');
            Request::addResponse('remove', '#item_' . $id);
            Request::endAjax();
        } else {
            Request::returnError('Database error');
        }
    }
}
/* End of file */
