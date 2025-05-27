<?php
class Content_pagesController extends Controller
{
    protected $layout = 'layout_panel';

    use Validator, RecordVersion;

    public function indexAction()
    {
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

        Request::setTitle('Content Pages');
    }

    public function viewAction()
    {
        $module = get('module', true, false);
        $pages = Content_pagesModel::getPages($module);
        $names = Content_pagesModel::getPagesNames($module);

        foreach ($pages as $page) {
            foreach ($names as $name) {
                if ($page->page == $name->page)
                    $page->page_name = $name->content;
            }
        }

        $this->view->list = $pages;

        Request::setTitle('Content Pages');
    }

    public function editAction()
    {
        $module = get('module', true, false);
        $page   = get('page',   true, false);

        $this->view->list = Content_pagesModel::getBlocks($module, $page);

        $this->view->page_name      = $this->checkViewFields($module, $page, 'page_name', 'page_name');
        $this->view->meta_title     = $this->checkViewFields($module, $page, 'meta_title', 'meta');
        $this->view->meta_keywords  = $this->checkViewFields($module, $page, 'meta_keywords', 'meta');
        $this->view->meta_desc      = $this->checkViewFields($module, $page, 'meta_desc', 'meta');

        if (!$this->view->list) {
            redirect(url('panel/content_pages'));
        }

        if ($this->startValidation()) {
            $this->validatePost('meta_title', 'Meta Title', 'trim|min_length[0]|max_length[200]');
            $this->validatePost('meta_keywords', 'Meta Keywords', 'trim|min_length[0]|max_length[200]');
            $this->validatePost('meta_desc', 'Meta Description', 'trim|min_length[0]|max_length[200]');
            $this->validatePost('page_name', 'Page Name', 'trim|min_length[0]|max_length[200]');

            foreach ($this->view->list as $item) {
                $alias = defaultValue($item->alias, $item->name) . ' Block Name';
                $content = defaultValue($item->alias, $item->name) . ' Content';
                $this->validatePost(($item->name . '--alias'), $alias, 'trim|min_length[0]|max_length[150]');
                $this->validatePost($item->name, $content, 'required|trim|min_length[0]');
            }

            if ($this->isValid()) {
                $result = false;
                $list = array_merge($this->view->list, [$this->view->page_name, $this->view->meta_title, $this->view->meta_keywords, $this->view->meta_desc]);
                $this->makeVersions($list, 'content_pages_tree', 'edit');

                foreach ($this->view->list as $item) {
                    $data = [
                        'alias'   => post($item->name . '--alias'),
                        'content' => post($item->name)
                    ];

                    if (post($item->name . '--video_type')) {
                        $data['video_type'] = post($item->name . '--video_type');
                    }

                    if ($item->type === 'image' && $item->content !== $data['content'] && $data['content']) {
                        Storage::copy('data/tmp/' . $data['content'], 'data/images/' . $data['content']);
                        $data['content'] = _SITEDIR_ . 'data/images/' . $data['content'];
                        $data['content'] = $this->removeDevDirectoryFromPath($data['content']);
                    }

                    if (($item->type === 'picture' || $item->type === 'image')
                        && stripos($data['content'], '/app/data/images/') === false
                        && $item->content !== $data['content'] && !empty($data['content'])) {

                        if ($item->type === 'picture' && Storage::move("data/tmp/" . $data['content'], 'data/images/' . $data['content'])) {
                            Storage::remove('data/setting/' . pathinfo($item->content)['filename'] . '.webp');

                            $im = new Image('app/data/images/' . $data['content']);
                            $im->convertTo('webp');
                        }

                        $data['content'] = _SITEDIR_ . 'data/images/' . $data['content'];
                        $data['content'] = $this->removeDevDirectoryFromPath($data['content']);
                    }

                    if ($item->type === 'video' && $item->content !== $data['content'] && $item->video_type !== 'youtube') {
                        Storage::copy('data/tmp/' . $data['content'], 'data/videos/' . $data['content']);
                        $data['content'] = _SITEDIR_ . 'data/videos/' . $data['content'];
                        $data['content'] = $this->removeDevDirectoryFromPath($data['content']);
                    }

                    if ($item->type === 'file' && $item->content !== $data['content']) {
                        Storage::copy('data/tmp/' . $data['content'], 'data/files/' . $data['content']);
                        $data['content'] = _SITEDIR_ . 'data/files/' . $data['content'];
                        $data['content'] = $this->removeDevDirectoryFromPath($data['content']);
                    }

                    if (($item->type === 'picture' || $item->type === 'image') && stripos($data['content'], '/app/data/images/') === false && $item->content !== $data['content'] && !empty($data['content'])) {
                        $data['content'] = '/app/data/images/' . $data['content'];
                    }

                    $result = Model::update('content_pages_tree', $data, "`id` = '$item->id'");
                }

                Model::update('content_pages_tree', ['content' => post('page_name')], "`module` = '$module' AND `page` = '$page' AND `name` = 'page_name'");
                Model::update('content_pages_tree', ['content' => post('meta_title')], "`module` = '$module' AND `page` = '$page' AND `name` = 'meta_title'");
                Model::update('content_pages_tree', ['content' => post('meta_keywords')], "`module` = '$module' AND `page` = '$page' AND `name` = 'meta_keywords'");
                Model::update('content_pages_tree', ['content' => post('meta_desc')], "`module` = '$module' AND `page` = '$page' AND `name` = 'meta_desc'");

                if ($result) {
                    Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'edit', 'entity' => 'content_elements#' . $module .'/' . $page, 'time' => time()]);
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

        Request::setTitle('Edit Content Block');
    }

    /**
     * @param $module
     * @param $page
     * @param $fieldName
     * @param $fieldType
     * @return array|object
     */
    private function checkViewFields($module, $page, $fieldName, $fieldType)
    {
        $fieldValue = Content_pagesModel::getBlock($module, $page, $fieldName);
        if (!$fieldValue) {
            Model::insert('content_pages_tree', ['module' => $module, 'page' => $page, 'name' => $fieldName, 'type' => $fieldType, 'time' => time()]);
        } else {
            return $fieldValue;
        }
    }

    /**
     * @param $source
     * @param $destination
     * @return void
     */
    private function copyAndRemoveImage($source, $destination)
    {
        if (Storage::copy($source, $destination)) {
            $this->moveFile($source, 'images');
            Storage::remove($destination);
        } else {
            print_data(error_get_last());
        }
    }

    /**
     * @param $path
     * @return array|mixed|string|string[]
     */
    private function removeDevDirectoryFromPath($path)
    {
        $pos = strpos($path, _DIR_ . 'app/');
        if ($pos !== false) {
            $path = substr_replace($path, '/app/', $pos, strlen(_DIR_ . 'app/'));
        }
        return $path;
    }

    public function deleteAction()
    {
        $id = get('id');
        $block = Content_pagesModel::get($id);

        if (!$block)
            redirect(url('panel/content_pages/edit?module=' . get('module') . '&page=' . get('page')));

        $result = Model::delete('content_pages_tree', " `id` = '$id'");

        if ($result) {
            Model::insert('actions_logs', ['user_id' => User::get('id'), 'action' => 'delete', 'entity' => 'content_elements#' . $id, 'time' => time()]);
        } else
            Request::returnError('Database error');

        redirect(url('panel/content_pages/edit?module=' . get('module') . '&page=' . get('page')));
    }
}
/* End of file */