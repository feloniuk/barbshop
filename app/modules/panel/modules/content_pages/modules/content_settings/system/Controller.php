<?php
class Content_settingsController extends Controller
{
    protected $layout = 'layout_panel';

    use Validator;

    public function indexAction()
    {
        $this->view->list = Content_settingsModel::getAll();

        Request::setTitle('Settings');
    }

    public function archiveAction()
    {
        $this->view->list = Content_settingsModel::getArchived();

        Request::setTitle('Archive Settings');
    }

    public function resumeAction()
    {
        Request::ajaxPart();

        if ($this->startValidation()) {

            $this->validatePost('id','ID', 'required|trim');

            if ($this->isValid()) {

                $result = Model::update('custom_modules', ['deleted' => 'no'], "`id` = '". post('id') . "'"); // Update row

                if ($result) {
                    // Log
                    Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'resume', 'entity' => 'custom_modules#' . post('id'), 'time' => time()]);

//                    Request::addResponse('redirect', false, url('panel', 'content_settings', 'content_settings', 'archive'));
                    Request::addResponse('func', 'noticeSuccess', 'Removed');
                    Request::addResponse('remove', '#item_' . post('id'));
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

    }

    public function addAction()
    {

        if ($this->startValidation()) {

            $this->validatePost('name',             'Name',           'required|trim|min_length[1]|max_length[200]');

            if ($this->isValid()) {
                $data = array(
                    'name'     => post('name'),
                );

                $result   = Model::insert('custom_modules', $data); // Insert row
                $insertID = Model::insertID();

                if (!$result && $insertID) {
                    Request::addResponse('redirect', false, url('panel', 'content_pages', 'content_settings', 'edit', $insertID));
                } else {
                    Request::returnError('Database error');
                }
            } else {
                if (Request::isAjax()) {
                    Request::returnErrors($this->validationErrors);
                }
            }
        }

        Request::setTitle('Add Testimonial');
    }

    public function editAction()
    {
        $id = intval(Request::getUri(0));
        $this->view->testimonial = Content_settingsModel::get($id);

        if (!$this->view->testimonial)
            redirect(url('panel/content_pages/content_settings'));

        $settings_pages = Model::fetchAll(Model::select('modules_pages', " `cm_id` = '" . $id . "'"));

        $settings_pages_arr = [];
        if ($settings_pages) {
            foreach ($settings_pages as $k => $item) {
                $settings_pages_arr[] = $item->page_modules . '-' . $item->page_name;
            }
        }

        $this->view->settings_saved = $settings_pages_arr;

        $routesArray = Route::getList();

        $pages = Content_pagesModel::getPagesAll();

        $newArray = [];
        foreach ($pages as $page) {
            if ($page->module == 'page' && $page->page == 'index') {
                $page->pattern = '';
            } else if ($page->module != 'page' && $page->page == 'index') {
                $page->pattern = $page->module;
            } else {
                $page->pattern = $page->module . '/' . $page->page;
            }
            $page->page_name = Content_pagesModel::getPageName($page->module, $page->page)->content ?: '';
            foreach ($routesArray as $route) {
                if ($route['action'] == $page->page && $route['controller'] == $page->module) {
                    if (strpos($route['pattern'], '/([a-z0-9\+\-\.\,_%]{1,250})')) { //todo mb check array `items` in $route ??
                        $patternArray = explode('/([a-z0-9\+\-\.\,_%]{1,250})', $route['pattern']);

                        if ($patternArray[0])
                            $route['pattern'] = $patternArray[0] . '/{slug}';
                    }
                    $page->pattern = str_replace(['^', '?$~si', '~'], '', $route['pattern']);
                }
            }

            $page->pattern = str_replace('_', '-', $page->pattern);
            $newArray[$page->module][] = $page;
        }

        $this->view->list = $newArray;

        if ($this->startValidation()) {
            // Senior Error
            if (User::checkRole('senior'))
                $this->addError('permission', 'Permission error');
            $this->validatePost('csrf_token', 'CSRF',              'csrf');
            $this->validatePost('name',                      'Name',           'required|trim|min_length[1]|max_length[200]');
            $this->validatePost('image',                     'Image',          'trim|min_length[0]|max_length[100]');

            if ($this->isValid()) {

                $data = array(
                    'name'       => post('name'),
                );

                $result = Model::update('custom_modules', $data, "`id` = '$id'"); // Update row

                if ($result) {
                    // Log
                    Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'edit', 'entity' => 'custom_modules#' . $id, 'time' => time()]);

                    // Remove and after insert branches
                    Content_settingsModel::removePages($id);
                    if (is_array(post('pages')) && count(post('pages')) > 0) {
                        foreach (post('pages') as $page) {
                            $arr = explode('-', $page);
                            Model::insert('modules_pages', array(
                                'cm_id' => $id,
                                'page_modules' => $arr[0],
                                'page_name'    => $arr[1]
                            ));
                        }
                    }

//                    Request::addResponse('redirect', false, url('panel', 'content_settings', 'edit', $id));
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

        Request::setTitle('Edit Testimonial');
    }

    public function deleteAction()
    {
        Request::ajaxPart();

        $id = (Request::getUri(0));
        $user = Content_settingsModel::get($id);

        if (!$user)
            redirect(url('panel/content_pages/content_settings'));

        $data['deleted'] = 'yes';
        $result = Model::update('custom_modules', $data, "`id` = '$id'"); // Update row
        Content_settingsModel::removePages($id);

        if ($result) {
            // Log
            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'delete', 'entity' => 'custom_modules#' . $id, 'time' => time()]);

            Request::addResponse('func', 'noticeSuccess', 'Removed');
            Request::addResponse('remove', '#item_' . $id);
        } else {
            Request::returnError('Database error');
        }

        Request::endAjax();
//        redirect(url('panel/content_pages/content_settings'));
    }
}
/* End of file */