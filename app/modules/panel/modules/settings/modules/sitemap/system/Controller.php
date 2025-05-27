<?php
class SitemapController extends Controller
{
    protected $layout = 'layout_panel';

    use Validator;

    public function indexAction()
    {
        $this->view->customLinks = Model::fetch(Model::select('settings', "`name` = 'sitemap_links'", '*'));

        // Generated links
        $links = Model::fetchAll(Model::select('sitemap'));
        $this->view->links = '';
        foreach ($links as $link)
            $this->view->links .= SITE_URL . $link->link . PHP_EOL;

        $this->view->tables = Model::getTables();
        $this->view->list = SitemapModel::getAll();
        Request::setTitle('Site Map');
    }

    public function addAction()
    {
        $this->view->tables = Model::getTables();

        if ($this->startValidation()) {
            $this->validatePost('table',    'Table',        'required|trim|min_length[1]|max_length[200]');
            $this->validatePost('where',    'Condition',    'trim|min_length[1]|max_length[200]');
            $this->validatePost('url',      'Url',          'required|trim|min_length[1]|max_length[200]');
            $this->validatePost('base_url', 'Base url',     'required|trim|min_length[1]|max_length[200]');


            if ($this->isValid()) {
                $data = array(
                    'table' => post('table'),
                    'where' => post('where'),
                    'url'   => post('url'),
                    'base_url' => post('base_url'),
                );

                $result = Model::insert('site_map', $data); // Insert row
                $insertID = Model::insertID();

                if (!$result && $insertID) {
                    Request::addResponse('redirect', false, url('panel', 'settings', 'sitemap', 'index', $insertID));
                } else {
                    Request::returnError('Database error');
                }

            } else {
                if (Request::isAjax())
                    Request::returnErrors($this->validationErrors);
            }
        }

        Request::setTitle('Add Site Map');
    }

    public function editAction()
    {
        $id = intval(Request::getUri(0));
        $this->view->item = SitemapModel::get($id);

        if (!$this->view->item)
            redirect(url('panel/settings/sitemap'));

        if ($this->startValidation()) {
            $this->validatePost('table',    'Table',      'required|trim|min_length[1]|max_length[200]');
            $this->validatePost('where',    'Condition',  'trim|min_length[1]|max_length[200]');
            $this->validatePost('url',      'Url',        'required|trim|min_length[1]|max_length[200]');

            if ($this->isValid()) {
                $data = array(
                    'table'      => post('table'),
                    'where'      => post('where'),
                    'url'        => post('url'),
                );

                $result = Model::update('site_map', $data, "`id` = '$id'"); // Update row

                if ($result) {
                    Request::addResponse('redirect', false, url('panel', 'settings', 'sitemap', 'index'));
                } else {
                    Request::returnError('Database error');
                }
            } else {
                if (Request::isAjax())
                    Request::returnErrors($this->validationErrors);
            }
        }

        Request::setTitle('Edit Site Map');
    }

    public function saveAction()
    {
        if ($this->startValidation()) {
            $links = $this->validatePost('links',    'Links',      'trim|min_length[1]|max_length[6000]');

            if ($this->isValid()) {
                // Get all tables
                $allTables = SitemapModel::getAll();

                $tablesLinks = [];
                foreach ($allTables as $table) {
                    // Проверяем передавался ли параметр в url
                    // Если параметр есть, то достаём его имя и подсатавляем в выборку
                    $row = 'id';
                    $url = $table->url ;
                    if (strpos($table->url, '{')) {
                        $urlArray = explode('{', $table->url);
                        $url = $urlArray[0];
                        $row = substr($urlArray[1],0,-1);
                    }

                    $allRows = Model::fetchAll(Model::select($table->table, reFilter($table->where), $row));
                    $strUrl = $table->base_url . $url;
                    foreach ($allRows as $value)
                        array_push($tablesLinks,  $strUrl . $value->$row);
                }


                // Add links if they exist
                if ($links) {
                    SettingsModel::set('sitemap_links', $links);

                    $links = explode('\r\n', $links);
                    foreach ($links as $link)
                       array_unshift($tablesLinks, $link);
                }


                // Write data to sitemap.xml
                $fd = fopen(_BASEPATH_ . "sitemap.xml", 'w') or die("Some error, we cant create file!");

                $sitemap = '<?xml version="1.0" encoding="UTF-8"?>'
                    . '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">' . PHP_EOL;

                $sitemap .= '<url>'
                    . '<loc>' . SITE_URL . '</loc>'
                    . '<lastmod>' . date("Y-m-d", time()) . '</lastmod>'
                    . '<priority>0.9</priority>'
                    . '</url>' . PHP_EOL;

                foreach ($tablesLinks as $item) {
                    $sitemap .= PHP_EOL . '<url>'
                        . '<loc>' . $item . '</loc>'
                        . '<lastmod>' . date("Y-m-d", time()) . '</lastmod>'
                        . '<priority>0.9</priority>'
                        . '</url>' . PHP_EOL;
                }

                $sitemap .= PHP_EOL . '</urlset>';
                fwrite($fd, $sitemap); // todo: use write(_BASEPATH_ . 'sitemap.xml', $sitemap);
                fclose($fd);

                Request::addResponse('func', 'noticeSuccess', 'Sitemap generated');
                Request::endAjax();
            } else {
                if (Request::isAjax())
                    Request::returnErrors($this->validationErrors);
            }
        }

        Request::setTitle('Save');
    }

    public function deleteAction()
    {
        $id = (Request::getUri(0));
        $item = SitemapModel::get($id);

        if (!$item)
            redirect(url('panel/settings/sitemap'));

        $data['deleted'] = 'yes';
        $result = Model::update('site_map', $data, "`id` = '$id'"); // Update row

        if ($result) {
//            $this->session->set_flashdata('success', 'User created successfully.');
//            Request::addResponse('redirect', false, url('panel', 'sectors', 'edit', $insertID));
        } else {
            Request::returnError('Database error');
        }

        redirect(url('panel/settings/sitemap'));
    }

}
/* End of file */