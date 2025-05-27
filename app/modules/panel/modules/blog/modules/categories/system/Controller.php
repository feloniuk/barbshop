<?php
class CategoriesController extends Controller
{
    protected $layout = 'layout_panel';

    use Validator, RecordVersion;

    public function indexAction()
    {
        $this->view->list = CategoriesModel::getAll();

        Request::setTitle('Categories');
    }

    public function addAction()
    {
        if ($this->startValidation()) {
            $this->validatePost('name',    'Name',         'required|trim|min_length[1]|max_length[200]');

            if ($this->isValid()) {
                $data = array(
                    'name'      => post('name'),
                );

                $result   = Model::insert('blog_categories', $data); // Insert row
                $insertID = Model::insertID();

                if (!$result && $insertID) {
                    $this->makeVersion($insertID, 'blog_categories', 'add');

                    Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'add', 'entity' => 'blog_categories#' . $insertID, 'time' => time()]);

//                    $this->session->set_flashdata('success', 'User created successfully.');
                    Request::addResponse('redirect', false, url('panel', 'blog', 'categories', 'edit', $insertID));
                } else {
                    Request::returnError('Database error');
                }
            } else {
                if (Request::isAjax())
                    Request::returnErrors($this->validationErrors);
            }
        }

        Request::setTitle('Add Category');
    }

    public function editAction()
    {
        $id = intval(Request::getUri(0));
        $this->view->edit = CategoriesModel::get($id);

        if (!$this->view->edit)
            redirect(url('panel/sectors'));

        if ($this->startValidation()) {
            $this->validatePost('name',    'Name',         'required|trim|min_length[1]|max_length[200]');

            if ($this->isValid()) {
                $data = array(
                    'name'      => post('name'),
                );

                $result = Model::update('blog_categories', $data, "`id` = '$id'"); // Update row

                if ($result) {
                    $this->makeVersion($id, 'blog_categories', 'edit');

                    Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'edit', 'entity' => 'blog_categories#' . $id, 'time' => time()]);

//                    Request::addResponse('redirect', false, url('panel', 'blog', 'club_categories', 'edit', $id));
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

        Request::setTitle('Edit Category');
    }

    public function deleteAction()
    {
        Request::ajaxPart();

        $id = intval(Request::getUri(0));
        $user = CategoriesModel::get($id);

        if (!$user)
            Request::returnError('Category error');

        $data['deleted'] = 'yes';
        $result = Model::update('blog_categories', $data, "`id` = '$id'"); // Update row

        if ($result) {
            $this->makeVersion($id, 'blog_categories', 'delete');

            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'delete', 'entity' => 'blog_categories#' . $id, 'time' => time()]);

            Request::addResponse('func', 'noticeSuccess', 'Removed');
            Request::addResponse('remove', '#item_' . $id);
            Request::endAjax();
        } else {
            Request::returnError('Database error');
        }
    }
}
/* End of file */
