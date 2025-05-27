<?php

class PageController extends Controller
{
    use Validator;

    public function indexAction()
    {
        Model::import('panel/shops');

        $this->view->shops = ShopsModel::getAll("AND `posted` = 'yes'");
    }

    public function skanerAction()
    {
        
    }

    public function appointmentsAction()
    {
    
        Model::import('panel/orders');

        
        $this->view->orders = OrdersModel::getAll(" ORDER BY `selectedDate`, `selectedTime` ASC");
    }

    public function shopsAction()
    {
        Model::import('panel/shops');

        $slug = Request::getUri(0);

        $this->view->shop = ShopsModel::getSlug($slug);

        if (!$this->view->shop || $this->view->shop->posted == 'no')
            redirect(url(''));
    }

    public function barberAction()
    {
        Model::import('panel/team');

        $slug = Request::getUri(0);

        $this->view->barber = TeamModel::getUserWhere(" `slug` = '{$slug}'");

        if (!$this->view->barber || $this->view->barber->posted == 'no')
            redirect(url(''));
    }

    public function zapisAction()
    {
        Model::import('panel/team');
        Model::import('panel/services');
        Model::import('panel/orders');
        Model::import('panel/shops');

        $shop       = get('shop');
        $barber     = get('barber');
        $service    = get('service');

        if (!$barber || !$service)
            redirect(url('')); 
 
        $this->view->shop = ShopsModel::getSlug($shop);
        $this->view->barber = TeamModel::getUserWhere(" `slug` = '{$barber}'");
        $this->view->service = ServicesModel::get($service);
        $this->view->orders = OrdersModel::getAll(" AND `user_id` = '{$this->view->barber->id}' ORDER BY `selectedDate`, `selectedTime` ASC");
    }

    /**
     * access to file(CV) download (do not remove)
     */
    public function file_downloadAction()
    {
        if (!in_array(User::getRole(), ['superadmin', 'admin', 'moder'])) {
            redirectAny(url('404'));
        }

        $path_to_file = _SYSDIR_ . 'data/cvs/' . Request::getUri(0);

        if (file_exists($path_to_file)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);

            header('Content-Type: ' . finfo_file($finfo, $path_to_file));

            $finfo = finfo_open(FILEINFO_MIME_ENCODING);
            header('Content-Transfer-Encoding: ' . finfo_file($finfo, $path_to_file));
            header('Content-disposition: attachment; filename="' . basename($path_to_file) . '"');
            readfile($path_to_file);
        } else {
            error404();
        }
        exit;
    }

    /**
     * Email status (do not remove)
     * @return void
     */
    public function email_statusAction()
    {
        $token = get('token');

        Model::update('email_logs', ['status' => 'read'], "`token` = '$token'");

        $image = imagecreatefrompng('images/panel/px.png');
        header("Content-type: " . image_type_to_mime_type(IMAGETYPE_PNG));
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-cache, must-relative");
        imagegif($image);
        imagedestroy($image);
        exit;
    }

    public function zapis_serviceAction()
    {
        Request::ajaxPart(); // if not Ajax part load

        $selectedTime   = post('selectedTime');
        $selectedDate = post('selectedDate');
        $shop = get('shop'); 
        $barber = get('barber'); 
        $service = get('service'); 
  
        Model::import('panel/team');
        Model::import('panel/services');
        Model::import('panel/shops');

        $this->view->shop = ShopsModel::getSlug($shop);
        $this->view->barber = TeamModel::getUserWhere(" `slug` = '{$barber}'");
        $this->view->service = ServicesModel::get($service);

        if ($this->startValidation()) {
            $this->validatePost('name',             'Name',     'require|trim|min_length[1]');
            $this->validatePost('tel',              'Phone',    'require|trim');
            $this->validatePost('email',            'Email',    'trim|email');
            $this->validatePost('selectedTime',     'Time',     'require|trim|min_length[1]');
            $this->validatePost('selectedDate',     'Date',     'require|trim|min_length[1]');
            $this->validateGet('shop',          'Барбершоп',    'require|trim|min_length[1]');
            $this->validateGet('barber',        'Мастер',       'require|trim|min_length[1]');
            $this->validateGet('service',       'Сервис',       'require|trim|min_length[1]');

            if ($this->isValid()) {
                $data = array(
                    'name'          => post('name'),
                    'tel'           => post('tel'),
                    'email'         => post('email'),
                    'selectedTime'  => $selectedTime,
                    'selectedDate'  => $selectedDate,
                    'shop_id'       => $this->view->shop->id,
                    'user_id'       => $this->view->barber->id,
                    'service_id'    => $this->view->service->id,
                    'time'          => time()
                );

                $result   = Model::insert('orders', $data); // Insert row
                $insertID = Model::insertID();

              
                if (!$result && $insertID) {
                    Request::addResponse('html', '#main_id', $this->getView('modules/page/views/success.php'));
                    Request::endAjax();
                } else {
                    Request::returnError('Database error');
                }
            } else {
                if (Request::isAjax())
                    Request::returnErrors($this->validationErrors);
            }
        }

        Request::endAjax();
    }

    public function uploadAction()
    {
        Request::ajaxPart(); // if not Ajax part load

        $field   = post('field', true, '#image'); // field where to put file name after uploading
        $preview = post('preview', true, '#preview_file'); // field where to put file name after uploading
        $real_name = post('file_real_name', true); // field where to put file name after uploading
        $form_id = post('form_id');

        $result = null;
        foreach ($_FILES as $file) {
            try {
                $result = Storage::upload($file, 'File');
            } catch (Exception $e) {
                Request::returnError($e->getMessage(), $form_id, str_replace('#', '', $field));
            }
            break;
        }

        Request::addResponse('val', $field, $result['new_name']);
        Request::addResponse('val', $real_name, str_replace(' ', '_', $result['name']));
        Request::addResponse('html', $preview, $result['name']);
    }

    /**
     * Autogenerate sitemap
     * @return void
     */
    public function sitemapAction()
    {
        header("Content-type: text/xml");

        Model::import('panel/settings/sitemap');

        $time = SettingsModel::get('sitemap_links_time');
        if (intval($time) + 600 > time()) {
            $tablesLinks = json_decode(read(_SYSDIR_ . 'data/cache/sitemap_links.json'));
        } else {
            // Get all tables
            $allTables = SitemapModel::getAll();

            $tablesLinks = [];
            foreach ($allTables as $table) {
                // Проверяем передавался ли параметр в url
                // Если параметр есть, то достаём его имя и подсатавляем в выборку
                $row = 'id';
                $url = $table->url;
                if (strpos($table->url, '{')) {
                    $urlArray = explode('{', $table->url);
                    $url = $urlArray[0];
                    $row = substr($urlArray[1], 0, -1);
                }

                $allRows = Model::fetchAll(Model::select($table->table, reFilter($table->where), $row));
                $strUrl = $table->base_url . $url;
                foreach ($allRows as $value) {
                    array_push($tablesLinks, $strUrl . $value->$row);
                }
            }

            $customLinks = SettingsModel::get('sitemap_links');

            if ($customLinks) {
                $customLinks = preg_split('/\n|\r\n?/', $customLinks);

                foreach ($customLinks as $link) {
                    array_unshift($tablesLinks, $link);
                }
            }

            write(Storage::mkdir('data/cache/') . 'sitemap_links.json', (json_encode($tablesLinks))); // reFilter
            SettingsModel::set('sitemap_links_time', time());
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
        fwrite($fd, $sitemap);
        fclose($fd);

        echo file_get_contents("sitemap.xml");
        exit;
    }

    /**
     * view uploaded document / uploads module
     */
    public function uploadsAction()
    {
        $slug = Request::getUri(0);

        Model::import('panel/uploads');
        $file  = UploadsModel::getBySlug($slug);

        if (!$file || !$file->file)
            error404();

        $file = $file->file;

        $path_to_file =  _SYSDIR_ . 'data/uploads/' . $file;

        if (file_exists($path_to_file)) {
            $disposition = 'attachment';

            $pathinfo = pathinfo($path_to_file);
            if ($pathinfo['extension'] === 'pdf')
                $disposition = 'inline';

            $finfo = finfo_open(FILEINFO_MIME_TYPE);

            header('Content-Type: ' . finfo_file($finfo, $path_to_file));

            $finfo = finfo_open(FILEINFO_MIME_ENCODING);
            header('Content-Transfer-Encoding: ' . finfo_file($finfo, $path_to_file));
            header('Content-disposition: ' . $disposition . '; filename="' . $slug . '.' . $pathinfo['extension'] . '"');
            @readfile($path_to_file);
        } else {
            error404();
        }
        exit;
    }
}
/* End of file */
