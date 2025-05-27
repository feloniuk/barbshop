<?php
class RedirectsController extends Controller
{
    protected $layout = 'layout_panel';

    use Validator;

    public function indexAction()
    {
        $this->view->list = RedirectsModel::getAll();

        Request::setTitle('Redirects');
    }

    public function archiveAction()
    {
        $this->view->list = RedirectsModel::getArchived();

        Request::setTitle('Archive Redirects');
    }

    public function addAction()
    {
        if ($this->startValidation()) {
            $this->validatePost('uri_from',       'Uri from',        'required|trim|min_length[1]|max_length[255]');
            $this->validatePost('uri_to',         'Uri to',          'required|trim|min_length[1]|max_length[255]');

            if ($this->isValid()) {
                $data = array(
                    'uri_from'   => removeSiteName(post('uri_from')),
                    'uri_to'     => removeSiteName(post('uri_to')),
                    'time'       => time(),
                );

                $result   = Model::insert('redirects', $data); // Insert row
                $insertID = Model::insertID();

                if (!$result && $insertID) {
                    Request::addResponse('redirect', false, url('panel', 'redirects', 'edit', $insertID));
                } else {
                    Request::returnError('Database error');
                }
            } else {
                if (Request::isAjax())
                    Request::returnErrors($this->validationErrors);
            }
        }

        Request::setTitle('Add Redirect');
    }

    public function editAction()
    {
        $id = intval(Request::getUri(0));
        $this->view->testimonial = RedirectsModel::get($id);

        if (!$this->view->testimonial)
            redirect(url('panel/redirects'));

        if ($this->startValidation()) {
            $this->validatePost('uri_from',       'Uri from',        'required|trim|min_length[1]|max_length[255]');
            $this->validatePost('uri_to',         'Uri to',          'required|trim|min_length[1]|max_length[255]');

            if ($this->isValid()) {
                $data = array(
                    'uri_from'   => removeSiteName(post('uri_from')),
                    'uri_to'     => removeSiteName(post('uri_to')),
                );

                $result = Model::update('redirects', $data, "`id` = '$id'"); // Update row
                if ($result) {
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

        Request::setTitle('Edit Redirect');
    }

    public function resumeAction()
    {
        $id = (Request::getUri(0));
        $user = RedirectsModel::get($id);

        if (!$user)
            redirect(url('panel/redirects/archive'));

        $result = Model::update('redirects', ['deleted' => 'no'], "`id` = '$id'"); // Update row

        if ($result) {
            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'restore', 'entity' => 'redirect#' . $id, 'time' => time()]);
        } else {
            Request::returnError('Database error');
        }

        redirect(url('panel/redirects/archive'));

    }

    public function deleteAction()
    {
        $id = (Request::getUri(0));
        $user = RedirectsModel::get($id);

        if (!$user)
            redirect(url('panel/redirects'));

        $data['deleted'] = 'yes';
        $result = Model::update('redirects', $data, "`id` = '$id'"); // Update row

        if ($result) {
//            $this->session->set_flashdata('success', 'Testimonial created successfully.');
//            Request::addResponse('redirect', false, url('panel', 'redirects', 'edit', $insertID));
        } else {
            Request::returnError('Database error');
        }

        redirect(url('panel/redirects'));
    }
}
/* End of file */