<?php

class PanelController extends Controller
{
    use Validator;

    /**
     * Properties for size of crop img block.
     *
     * @var int
     */
    public int $cropBlockWidth = 400;
    public int $cropBlockHeight = 400;

    protected $layout = 'layout_panel';

    public function indexAction()
    {
        Model::import('panel/orders');
        Model::import('panel/team');


        if (User::checkRole('master')) {
            
            $this->view->orders = OrdersModel::getAll(" AND `user_id` = '" . User::get('id') . "' ORDER BY `selectedDate`, `selectedTime` ASC");
            $this->setView('master');
        }
       
        if (User::checkRole('moder')) {
            $date_from = get('date_from');
            $date_to = get('date_to');
            $shop_id = get('shop_id');
            $master_id = get('master_id');

            $filter = "";
            if ($date_from || $date_to) {
                if ($date_from ) {
                    $filter .= " AND `time` > '" . strtotime($date_from) . "'";
                }
                
                if ($date_from ) {
                    $filter .= " AND `time` < '" . strtotime($date_to) . "'";
                }
            }
            $this->view->user = $user = TeamModel::getUser(User::get('id'));
            $userByShops = TeamModel::getUsersByShopsWhere(" `shop_id` IN ('" . ($shop_id ?: implode("', '", $user->shop_ids)) . "')");
            
            if ($userByShops)
                $this->view->users_list = TeamModel::getActive(" AND `role` = 'master' AND `id` != '" . User::get('id') . "'" . ( $userByShops ? " and `id` IN ('" . implode("', '", array_column($userByShops, 'user_id')) . "')" : ""), 'id', 'DESC', Pagination::$start, Pagination::$end);
            else 
                $this->view->users_list = [];
            
            $this->view->orders = OrdersModel::getAll(" {$filter} AND `id` != '" . User::get('id') . "' AND `user_id` IN ('" . ($master_id ?: implode("', '", array_column($this->view->users_list, 'id'))) . "') AND `shop_id` IN ('" . ($shop_id ?: implode("', '", $user->shop_ids)) . "') ORDER BY `selectedDate`, `selectedTime` ASC");
            $this->setView('moder');
        }
       
        if (User::checkRole('admin')) {
            $date_from = get('date_from');
            $date_to = get('date_to');
            $shop_id = get('shop_id');
            $master_id = get('master_id');

            $filter = "";
            if ($date_from || $date_to) {
                if ($date_from ) {
                    $filter .= " AND `time` > '" . strtotime($date_from) . "'";
                }
                
                if ($date_from ) {
                    $filter .= " AND `time` < '" . strtotime($date_to) . "'";
                }
            }
            
                $this->view->users_list = TeamModel::getActive(" AND `role` = 'master' AND `id` != '" . User::get('id') . "'", 'id', 'DESC', Pagination::$start, Pagination::$end);
           
            
            $this->view->orders = OrdersModel::getAll(" {$filter} AND `id` != '" . User::get('id') . "'  ORDER BY `selectedDate`, `selectedTime` ASC");
            $this->setView('moder');
        }


        Request::setTitle('Dashboard');
    }

    

    public function scadaAction()
    {
        
        $this->view->scada = PanelModel::getData();


        Request::setTitle('SCADA');
    }

    /* --- Login --- */

    public function loginAction()
    {
        $this->view->cms_image  = SettingsModel::get('cms_image');

        if ($this->startValidation() || $this->startValidation('get')) {
            $email = $this->validatePost('email',       'Email',    'required|trim|email');
            $pass  = $this->validatePost('password',    'Password', 'required|trim|min_length[6]|max_length[32]');

            // Auto-login
            if (get('e') && get('p')) {
                $email = get('e');
                $pass = get('p');
            }

            $user = PageModel::getUserByEmail($email);

            if ($user && $user->deleted == 'yes') {
                $this->addError('password', 'User was deleted');
            } else if ($user && ($user->password == md5($pass) OR $user->password == $pass) && (in_array($user->role, ['admin', 'moder', 'superadmin', 'master']))) { // Check password

                $token = PageModel::createSession($user->id); // Generate session and add to `users_session`
                User::setTokenCookie($token); // Set session in cookies(token)

                $redirectUri = getSession('redirect_uri') ?: false;
                unset($_SESSION['redirect_uri']);

                redirectAny($redirectUri ?: url(''));
            } else
                $this->addError('password', 'Invalid email and/or password. Please check your data and try again');
        }

        if ($this->isErrors())
            $this->view->errors = $this->getErrors();

        $this->setLayout('layout_panel_login');
        Request::setTitle('Login');
    }

    public function scanerAction()
    {
        Model::import('panel/shops');
        Model::import('panel/team');

        // Фильтры
        $date_from = get('date_from') ?: date('Y-m-01');
        $date_to = get('date_to') ?: date('Y-m-d');
        $shop_id = get('shop_id');
        $user_id = get('user_id');

        // Получаем магазины для фильтра
        $this->view->shops = ShopsModel::getAll();

        // Получаем пользователей для фильтра
        $this->view->users = TeamModel::getActive(" AND `role` IN ('master', 'admin', 'moder')");

        // Статистика на сегодня
        $this->view->todayPresent = PanelModel::getTodayPresent();
        
        // Общая статистика
        $this->view->totalWorkDays = PanelModel::getTotalWorkDays($date_from, $date_to);
        $this->view->totalHours = PanelModel::getTotalHours($date_from, $date_to);
        $this->view->avgHours = PanelModel::getAverageHours($date_from, $date_to);

        // Сводная статистика по работникам
        $this->view->summaryStats = PanelModel::getSummaryStats($date_from, $date_to, $shop_id, $user_id);

        // Детальные записи
        $this->view->attendanceRecords = PanelModel::getDetailedRecords($date_from, $date_to, $shop_id, $user_id);

        Request::setTitle('Статистика відвідуваності');
    }

    public function scanAction()
    {
        Request::ajaxPart();

        $barcode = post('barcode');
        $shop_id = post('shop_id', 'int');

        if (!$barcode) {
            Request::returnError('Штрих-код не вказано');
        }

        Model::import('panel/attendance');
        Model::import('panel/team');

        // Находим пользователя по штрих-коду
        $user = TeamModel::getUserByBarcode($barcode);

        if (!$user) {
            Request::returnError('Працівника з таким штрих-кодом не знайдено');
        }

        // Записываем посещение
        $result = PanelModel::recordScan($user->id, $shop_id);

        if ($result['success']) {
            Request::addResponse('success', true);
            Request::addResponse('data', [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->firstname . ' ' . $user->lastname,
                    'position' => $user->job_title,
                    'shop' => $result['shop_name']
                ],
                'type' => $result['type'],
                'time' => date('H:i:s')
            ]);
        } else {
            Request::returnError($result['error']);
        }

        Request::endAjax();
    }

    public function user_detailsAction()
    {
        Request::ajaxPart();

        $user_id = intval(Request::getUri(0));
        $date_from = get('date_from') ?: date('Y-m-01');
        $date_to = get('date_to') ?: date('Y-m-d');

        Model::import('panel/attendance');
        Model::import('panel/team');

        $this->view->user = TeamModel::getUser($user_id);
        $this->view->userStats = PanelModel::getUserStats($user_id, $date_from, $date_to);
        $this->view->monthlyData = PanelModel::getUserMonthlyData($user_id, $date_from, $date_to);

        Request::addResponse('html', '#userDetailsContent', $this->getView());
    }

    public function exportAction()
    {
        $date_from = get('date_from') ?: date('Y-m-01');
        $date_to = get('date_to') ?: date('Y-m-d');
        $shop_id = get('shop_id');
        $user_id = get('user_id');

        Model::import('panel/attendance');
        $data = PanelModel::getExportData($date_from, $date_to, $shop_id, $user_id);

        // Створюємо Excel файл
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="attendance_' . date('Y-m-d') . '.xls"');
        header('Cache-Control: max-age=0');

        echo '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
        echo '<head><meta charset="UTF-8"></head>';
        echo '<body>';
        echo '<table border="1">';
        echo '<tr>
            <th>Дата</th>
            <th>Працівник</th>
            <th>Барбершоп</th>
            <th>Прихід</th>
            <th>Вихід</th>
            <th>Відпрацьовано годин</th>
            <th>Статус</th>
        </tr>';

        foreach ($data as $row) {
            echo '<tr>';
            echo '<td>' . date('d.m.Y', strtotime($row->date)) . '</td>';
            echo '<td>' . $row->firstname . ' ' . $row->lastname . '</td>';
            echo '<td>' . ($row->shop_name ?: '-') . '</td>';
            echo '<td>' . ($row->check_in ? date('H:i', strtotime($row->check_in)) : '-') . '</td>';
            echo '<td>' . ($row->check_out ? date('H:i', strtotime($row->check_out)) : '-') . '</td>';
            echo '<td>' . ($row->hours_worked ?: '-') . '</td>';
            echo '<td>' . $this->getStatusText($row->status) . '</td>';
            echo '</tr>';
        }

        echo '</table>';
        echo '</body>';
        echo '</html>';
        exit;
    }

    private function getStatusText($status)
    {
        $statuses = [
            'present' => 'Присутній',
            'late' => 'Запізнення',
            'absent' => 'Відсутній',
            'day_off' => 'Вихідний'
        ];
        return $statuses[$status] ?? $status;
    }

    public function logoutAction()
    {
        PageModel::closeSession(User::getTokenCookie());
        User::set(null);
        User::setTokenCookie(null);

        redirectAny(url(''));
    }

    public function restore_passwordAction()
    {
        if ($this->startValidation()) {
            Request::ajaxPart();
            $this->validatePost('email',   'Email',    'required|trim|email');

            if ($this->isValid()) {
                $user = PageModel::getUserByEmail(post('email'));
                if (!$user)
                    Request::returnError('This email does not exist');

                //generate hash and update user row
                $this->view->email = $user->email;
                $this->view->hash = md5($user->email . time());
                Model::update('users', ['restore_token' => $this->view->hash], " `id` = $user->id");

                // Send email to admin
                require_once(_SYSDIR_.'system/lib/phpmailer/class.phpmailer.php');
                $mail = new PHPMailer;

                // Mail to client/consultant
                $mail->IsHTML(true);
                $mail->SetFrom(Request::getParam('noreply_mail'), Request::getParam('noreply_name'));
                $mail->AddAddress($user->email);


                $mail->Subject = 'Restore Password';
                $mail->Body = $this->getView('modules/panel/views/email_templates/restore_password.php');
                $mail->AltBody = 'Note: Our emails are a lot nicer with HTML enabled!';
                $mail->Send();

                Request::addResponse('html', '#restore_form', '<h3 class="title"><span>An email has been sent to the address you provided. Please check your inbox and junk mail folder.</span></h3>');
            } else {
                if (Request::isAjax())
                    Request::returnErrors($this->validationErrors);
            }
        }

        if ($this->isErrors())
            $this->view->errors = $this->getErrors();


        $this->setLayout('layout_panel_login');
        Request::setTitle('Restore Password');
    }

    public function restore_processAction()
    {
        $email = get('email');
        $hash = get('hash');
        $user = PageModel::getUserByEmail($email);

        //check hash
        if ($user->restore_token !== $hash)
            $this->view->errors = 'Hash is invalid';

        if ($this->startValidation()) {
            Request::ajaxPart();
            $this->validatePost('password',      'Password',          'required|trim|password');
            $this->validatePost('password2',     'Confirm Password',  'required|trim|password');

            if (post('password') !== post('password2'))
                $this->addError('password', 'Passwords should match');

            if ($this->view->errors)
                $this->addError('hash', 'Hash is invalid');

            if ($this->isValid()) {
                Model::update('users', ['password' => md5(post('password')), 'restore_token' => ''], "`email` = '$user->email'"); // Update row

                Request::addResponse('html', '#restore_form', '<h3 class="title"><span>Password updated successfully</span></h3>');
            } else {
                if (Request::isAjax())
                    Request::returnErrors($this->validationErrors);
            }
        }

        $this->setLayout('layout_panel_login');
        Request::setTitle('Restore Password');
    }

    /**
     * Upload image for admin panel
     */

    public function select_imageAction()
    {
        Request::ajaxPart();

        $this->view->path      = post('path',      true, 'tmp'); // path where image will be saved, default: 'tmp'
        $this->view->field     = post('field',     true, '#image'); // field where to put image name after uploading
        $this->view->preview   = post('preview',   true, '#preview_image'); // field where to put image name after uploading
        $this->view->width     = post('width');
        $this->view->height    = post('height');
        $this->view->multiple  = post('multiple');
        $this->view->elem_type = post('elem_type');
        $this->view->images    = Model::fetchAll(Model::select('last_uploaded_images', " 1 ORDER BY `id` DESC LIMIT 30"));

        Request::addResponse('html', '#popup', $this->getView());
    }

    public function remove_select_imageAction()
    {
        Request::ajaxPart();
        $id = intval(Request::getUri(0));
        $image = Model::fetch(Model::select("last_uploaded_images", " `id` = $id"));

        if (!$image) return;

        Model::delete('last_uploaded_images', " `id` = $id");

        Storage::remove('data/last_uploaded_images/' . $image->image);
        Storage::remove('data/last_uploaded_images/mini_' . $image->image);

        $this->view->path    = post('path',     true, 'tmp'); // path where image will be saved, default: 'tmp'
        $this->view->field   = post('field',    true, '#image'); // field where to put image name after uploading
        $this->view->preview = post('preview',  true, '#preview_image'); // field where to put image name after uploading
        $this->view->width   = post('width');
        $this->view->height  = post('height');
        $this->view->images  = Model::fetchAll(Model::select('last_uploaded_images', " 1 ORDER BY `id` DESC LIMIT 10"));

        Request::addResponse('html', '#popup', $this->getView('modules/panel/views/select_image.php'));
    }

    public function upload_image_cropAction()
    {
        Request::ajaxPart();

        $this->view->path      = $path      = post('path',     true, 'tmp'); // path where image will be saved, default: 'tmp'
        $this->view->field     = $field     = post('field',    true, '#image'); // field where to put image name after uploading
        $this->view->preview   = $preview   = post('preview',  true, '#preview_image'); // field where to put image name after uploading
        $this->view->lastUploadedPath   = $lastUploadedPath = 'last_uploaded_images';
        $this->view->select_image       = $select_image = post('select_image');
        $this->view->image_from         = $type = post('type');

        if (empty($_FILES) && !$type) {
            Request::endAjax();
        }

        // display preview image in admin panel - minified, not full image
        if (!empty($_FILES) && $type !== 'image_from_last') {
            $imgInfo = null;
            foreach ($_FILES as $file) {
                try {
                    $imgInfo = Storage::upload($file);
                } catch (exception $e) {
                    Request::returnError($e->getMessage());
                }
            }
        }

        if ($type === 'image_from_last') {
            // If images selected from early uploaded
            $this->view->imagename = $newImageName = post('name') ?: randomHash();

            $newImagePath = 'data/' . $lastUploadedPath . '/' . $newImageName;
        } else {
            $this->view->imagename = $newImageName = $imgInfo['new_name'];
            $newImagePath = 'data/' . $path . '/' . $newImageName;
        }

        try {
            $entity = new Image(_SYSDIR_ . $newImagePath);
        } catch (Exception $exception) {
            Request::returnError("Image error: {$exception->getMessage()}");
            Request::endAjax();
        }

        $this->view->format = $entity->getExtension();

        // Thumbnail of uploaded image
        if ($select_image && $type !== 'image_from_last' && !empty($_FILES)) {
            Model::insert('last_uploaded_images', ['image' => $newImageName]);

            $newImagePath = 'data/' . $lastUploadedPath . '/' . $newImageName;
            $newMiniFilePath = _SYSDIR_ . 'data/' . $lastUploadedPath .  '/mini_' . $newImageName;

            //move image
            if (Storage::copy('data/tmp/' . $newImageName, $newImagePath)) {
                //create mini
                $entity->resize(86, 60, $newMiniFilePath);
            }
        }

        // Image min size control
        $this->sizeControl($entity, post('width', 'int', 0), post('height', 'int', 0));

        [
            $this->view->width,
            $this->view->height,
            $this->view->CROP_BLOCK_W,
            $this->view->CROP_BLOCK_H
        ] = $this->getCoefficientCropBox($entity, post('width'), post('height'));

        Request::addResponse('val', $field, $newImageName);
        Request::addResponse('html', $preview, '<img src="' . _SITEDIR_ . $newImagePath . '?t=' . time() . '" alt="">');

        Request::addResponse('html', '#popup', $this->getView());
    }

    public function sizeControl($entity, $width, $height)
    {
        if ($width > $entity->getWidth() || $height > $entity->getHeight()) {
            Request::returnError('Image is too small (min width = ' . $width . ', min height = ' . $height . '; current width = ' . $entity->getWidth() . ', current height = ' . $entity->getHeight() . ')');
            Request::endAjax();
        }
    }

    private function getCoefficientCropBox($entity, $width, $height): array
    {
        $imgWidth = $entity->getWidth();
        $imgHeight = $entity->getHeight();

        // Crop Const(min resizing)
        [$CROP_BLOCK_W, $CROP_BLOCK_H] = cropImageRatio($this->cropBlockWidth, $this->cropBlockHeight, $imgWidth, $imgHeight);

        // Coefficient of image to crop box
        $hh = $imgHeight / $CROP_BLOCK_H;
        $ww = $imgWidth / $CROP_BLOCK_W;

        // Start x,y
        $this->view->default_x = 0;
        $this->view->default_y = 0;

        if ($width && $height) {
            $this->view->ratio = $width / $height;
        } else {
            $this->view->ratio = false; // Turn off aspectRatio

            $width = $CROP_BLOCK_W;
            $height = $CROP_BLOCK_H;

            if ($width < $CROP_BLOCK_W) {
                $this->view->default_x = (($imgWidth / $ww - $width) / 2);
            }

            if ($height < $CROP_BLOCK_H) {
                $this->view->default_y = (($imgHeight / $hh - $height) / 2);
            }

            if ($width > $CROP_BLOCK_W) {
                $this->view->default_x = (($imgWidth - $width) / 2);
            }

            if ($height > $CROP_BLOCK_H) {
                $this->view->default_y = (($imgHeight - $height) / 2);
            }
        }

        return [$width, $height, $CROP_BLOCK_W, $CROP_BLOCK_H];
    }

    /**
     * create image with webp format
     * @param $newImageName
     * @param $fileFormat
     * @param $path
     */
//    public function createWebp($newImageName, $fileFormat, $path)
//    {
//        $fileInfo = pathinfo($newImageName);
//
//        if ($fileFormat == 'jpg')
//            $imageCreateFrom = 'imagecreatefromjpeg';
//        else if (array_key_exists($fileFormat, File::$allowedImageFormats))
//            $imageCreateFrom = 'imagecreatefrom' . $fileFormat;
//
//        $current_image = $imageCreateFrom(_SYSDIR_ . 'data/' . $path . '/' . $newImageName); //sys dir
//
//        list($imgWidth, $imgHeight) = getimagesize(_SYSDIR_ . 'data/' . $path . '/' . $newImageName);
//
//        // Create new image
//        $new = imageCreateTrueColor($imgWidth, $imgHeight);
//
//        // Alpha channel
//        if ($fileFormat == 'png' or $fileFormat == 'gif') {
//            // integer representation of the color black (rgb: 0,0,0)
//            $background = imagecolorallocate($new, 0, 0, 0);
//            // removing the black from the placeholder
//            imagecolortransparent($new, $background);
//
//            // turning off alpha blending (to ensure alpha channel information
//            // is preserved, rather than removed (blending with the rest of the image in the form of black))
//            imagealphablending($new, false);
//
//            // turning on alpha channel information saving (to ensure the full range of transparency is preserved)
//            imagesavealpha($new, true);
//        }
//
//        // Copy and resize part of an image with resampling
//        imagecopy($new, $current_image, 0, 0, 0, 0, $imgWidth, $imgHeight);
//
//
//        imagewebp($new, _SYSDIR_ . 'data/tmp/' . $fileInfo['filename'] . '.webp'); // Output image to file
//        imageDestroy($current_image); // Destroy an image
//    }

    public function cropAction()
    {
        ini_set('memory_limit', '-1');

        Request::ajaxPart();

        $name      = post('name');
        $path      = post('path');
        $field     = post('field'); // field
        $preview   = post('preview'); // preview
        $quality   = post('quality');
        $newFormat = post('format');

        $image = new Image(_SYSDIR_ . 'data/' . $path . '/' . $name);

        [$x1, $y1, $w, $h] = $this->calculateCropCoordinates($_POST['x1'], $_POST['y1'], $_POST['w'], $_POST['h'], $image);

        $newName = randomHash();
        $newFilename = 'crop_' . $newName . '.' . $image->getExtension(); // Cropped image name
        $newPath = _SYSDIR_ . 'data/tmp/' . $newFilename;
        $image->crop($x1, $y1, $w, $h, $quality, $newPath);

        if ($image->getExtension() !== $newFormat) {
            $image = new Image($newPath);
            $image->convertTo($newFormat, true);

            $newFilename = $image->getName() . '.' . $newFormat;
        }

        //Remove non croped image from tmp
        if ($path !== 'last_uploaded_images') {
            Storage::remove('data/' . $path . '/' . $name);
        }

        Request::addResponse('val', $field, $newFilename);
        Request::addResponse('html', $preview, '<img src="' . _SITEDIR_ . 'data/tmp/' . $newFilename . '?t=' . time() . '" alt="">');
        Request::addResponse('func', 'closePopup');
        Request::endAjax();
    }

    /**
     * Method calculates the coordinates for cropping the image.
     *
     * @param float $x
     * @param float $y
     * @param float $w
     * @param float $h
     * @param Image $image
     * @return float[]|int[]
     */
    private function calculateCropCoordinates(float $x, float $y, float $w, float $h, Image $image): array
    {
        $imgWidth  = $image->getWidth();
        $imgHeight = $image->getHeight();

        // Crop Const(min resizing)
        [$CROP_BLOCK_W, $CROP_BLOCK_H] = cropImageRatio($this->cropBlockWidth, $this->cropBlockHeight, $imgWidth, $imgHeight);

        // Coefficient of image to crop box
        $hh = $imgHeight / $CROP_BLOCK_H;
        $ww = $imgWidth / $CROP_BLOCK_W;

        return [
            $x * $ww, // X coordinate of left top corner
            $y * $hh, // Y coordinate of left top corner
            $w * $ww, // Width of cropped part
            $h * $hh,  // Height of cropped part
        ];
    }

    private function prepare_image($field, $newImageName, $image_id, $type = 'panel')
    {
        if ($type === 'panel') {
            $image = '<div id="image_block_' . $image_id . '">';
            $image .= '<img id="' . $image_id . '" src="' . _SITEDIR_ . 'data/tmp/' . $newImageName . '?t=' . time() . '" alt="" height="50px" class="ml-2">';
            $image .= '<input type="hidden" id="hidden_' . $image_id . '" name="' . $field . '" value="' . $newImageName . '">';
            $image .= '<span class="img_del" onclick="removeFieldImage(\'' . $image_id . '\')"><span class="fa fa-times-circle-o"></span></span>';
            $image .= '</div>';
        } else {
            $image = '<div class="uploaded-file" id="image_block_' . $image_id . '">';
            $image .= '<img id="' . $image_id . '" src="' . _SITEDIR_ . 'data/tmp/' . $newImageName . '?t=' . time() . '" alt="">';
            $image .= '<input type="hidden" id="hidden_' . $image_id . '" name="' . $field . '" value="' . $newImageName . '">';
            $image .= '<span class="btn-remove" onclick="removeFieldImage(\'' . $image_id . '\')"></span>';
            $image .= '</div>';
        }

        return $image;
    }

    // To upload image without crop
    public function upload_imageAction()
    {
        ini_set('memory_limit', '-1');
        Request::ajaxPart(); // if not Ajax part load

        $name = post('name'); // image name, if not set - will be randomly
        $path = post('path', true, 'tmp'); // path where image will be saved, default: 'tmp'
        $field = post('field', true, '#image'); // field where to put image name after uploading
        $preview = post('preview', true, '#preview_image'); // field where to put image name after uploading

        if (!$name) $name = randomHash();

        $data['path'] = 'data/' . $path . '/';
        $data['new_name'] = $name;
        $data['new_format'] = 'png';

        $imgInfo = null;
        foreach ($_FILES as $file) {
            $imgInfo = Storage::upload($file, 'image');

            if ($imgInfo['error'] == 8)
                Request::returnError('Too big file (max size 8mb)');
            else if ($imgInfo['error'] == 10) {
                $formatString = implode(', ',array_keys(Image::$allowedFormats));
                Request::returnError('Incorrect image format. Image files must be ' . $formatString . ' format');
            }
            break;
        }

        $imageName = $imgInfo['new_name'] . '.' . $imgInfo['new_format']; // new name & format

        Request::addResponse('val', $field, $imageName);
        Request::addResponse('html', $preview, '<img src="' . _SITEDIR_ . 'data/tmp/' . $imageName . '?t=' . time() . '" alt="">');
    }

    /**
     * Upload video
     */
    public function uploadVideoAction()
    {
        Request::ajaxPart(); // if not Ajax part load

        $name    = post('name', true); // file name, if not set - will be randomly
        $path    = post('path', true, 'tmp'); // path where file will be saved, default: 'tmp'
        $field   = post('field', true, '#image'); // field where to put file name after uploading
        $preview = post('preview', true, '#preview_file'); // field where to put file name after uploading

        $result = null;
        foreach ($_FILES as $file) {
            $result = Storage::upload($file, 'video');
            break;
        }

        Request::addResponse('val', $field, $result['new_name']);
        Request::addResponse('html', $preview, $result['name']);
    }

    /**
     * Upload file
     */
    public function uploadAction()
    {
        Request::ajaxPart(); // if not Ajax part load

        $name    = post('name', true); // file name, if not set - will be randomly
        $path    = post('path', true, 'tmp'); // path where file will be saved, default: 'tmp'
        $field   = post('field', true, '#image'); // field where to put file name after uploading
        $preview = post('preview', true, '#preview_file'); // field where to put file name after uploading

        $result = null;
        foreach ($_FILES as $file) {
            $result = Storage::upload($file, 'file');
            break;
        }

        Request::addResponse('val', $field, $result['new_name']);
        Request::addResponse('html', $preview, $result['name']);
    }

    /* --- Logs --- */

    public function logsAction()
    {
        if ($this->startValidation()) {
            $act = Request::getUri(0);

            switch ($act) {
                case 'email_logs':
                    Model::delete('email_logs', "`id` > 0");
                    break;

                case 'user_logs':
                    Model::delete('actions_logs', "`id` > 0");
                    break;

                default:
                    Model::delete('logs', "`id` > 0");
            }

            redirectAny(url('panel/logs'));
        }

        $this->view->list = Model::select('logs', "1 ORDER BY `id` DESC LIMIT 40");
        $this->view->list_email = Model::select('email_logs', "1 ORDER BY `id` DESC LIMIT 40");
        $this->view->list_user = PanelModel::getUserLogs();
        Request::setTitle('Logs');
    }

    /* --- Export DB --- */

    public function dbAction()
    {
        $queryTables = Model::query('SHOW TABLES');

        while ($row = Model::fetch($queryTables, 'row'))
            $tablesArray[] = $row[0];

        // remove big tables
        if ($rk = array_search('postcodelatlng', $tablesArray))
            unset($tablesArray[$rk]);

        foreach ($tablesArray as $table) {
            $result = Model::query('SELECT * FROM ' . $table);
            $fieldsAmount = $result->field_count;
            $rows_num = Model::affected_rows();
            $tableCode = Model::fetch(Model::query('SHOW CREATE TABLE ' . $table), 'row');

            $content = (!isset($content) ? '' : $content) . "\n " . $tableCode[1] . ";\n\n";

            for ($i = 0, $st_counter = 0; $i < $fieldsAmount; $i++, $st_counter = 0) {
                while ($row = Model::fetch($result, 'row')) { // when started (and every after 100 command cycle):
                    if ($st_counter % 100 == 0 || $st_counter == 0)
                        $content .= "\nINSERT INTO `" . $table . "` VALUES";

                    $content .= "\n(";
                    for ($j = 0; $j < $fieldsAmount; $j++) {
//                        $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
//                        $row[$j] = filter($row[$j]);
                        if (is_null($row[$j]))
                            $content .= 'NULL';
                        else if (is_numeric($row[$j]))
                            $content .= $row[$j];
                        else if (isset($row[$j]))
                            $content .= "'" . filter($row[$j]) . "'";
                        else
                            $content .= "''";

                        if ($j < ($fieldsAmount - 1))
                            $content .= ', ';
                    }
                    $content .= ")";

                    // close every 100 lines or at the end
                    if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num)
                        $content .= ";";
                    else
                        $content .= ",";

                    $st_counter = $st_counter + 1;
                }
            }
            $content .= "\n\n";
        }

        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: Binary');
        header(sprintf('Content-disposition: attachment; filename="%s.sql"', DB_NAME));
        echo $content;
        exit;
    }

    /* --- Export Data --- */


    private function createDataZip() {

        $rootPath = realpath(_SYSDIR_ . 'data/');

        $filename = "data.zip";
        $zipFilepath = _SYSDIR_ . "data/_dump/$filename";
        $zipFilepathRelative = _SITEDIR_ . "data/_dump/$filename";

        $zip = new ZipArchive();

        if (!file_exists(_SYSDIR_ . 'data/_dump'))
            mkdir( _SYSDIR_ . 'data/_dump');

        if ($zip->open("$zipFilepath", ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE)
            Request::returnError('Zip Error');

        /** @var SplFileInfo[] $files */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($rootPath),
            RecursiveIteratorIterator::LEAVES_ONLY
        );
        foreach ($files as $file)
        {
            if (!$file->isDir())
            {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($rootPath) + 1);
                if (!preg_match('/^_dump/', $relativePath) && !preg_match('/^tmp/', $relativePath))
                    $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();
        return $zipFilepathRelative;
    }

    public function dataAction()
    {
        Request::ajaxPart();
        $filepath = $this->createDataZip();

        Request::addResponse('func', 'downloadFile', $filepath);
        Request::endAjax();
    }

    /* --- Modules --- */

    public function modulesAction()
    {
        $this->view->list = Model::select('modules', "1 ORDER BY `id` DESC");
        Request::setTitle('Modules');
    }

    public function modules_editAction()
    {
        Request::ajaxPart();

        $id = Request::getUri(0);
        $this->view->edit = Model::fetch(Model::select("modules", " `id` = '$id' LIMIT 1"));

        if (!$this->view->edit)
            redirect(url('panel/modules'));

        if ($this->startValidation()) {
            $this->validatePost('version', 'Version', 'trim|min[0]');

            if ($this->isValid()) {
                $result = Model::update(
                    'modules',
                    ['version' => intval(post('version', 'int')), 'visible' => post('visible')],
                    "`id` = '$id'"
                ); // Update row

                if ($result) {
                    Request::addResponse('func', 'closePopup();');
                    Request::addResponse('func', 'noticeSuccess', 'Saved');
                }
            } else {
                if (Request::isAjax())
                    Request::returnErrors($this->validationErrors);
            }
        }

        Request::addResponse('html', '#popup', $this->getView());
    }

    public function sort_vacanciesAction()
    {
        Request::ajaxPart();

        $field = post('field');

        Model::import('panel/vacancies');
        $this->view->vacancies = VacanciesModel::getSortedByField($field);

        Request::addResponse('html', '#vacancies_result', $this->getView('modules/panel/views/vacancies_list.php'));

    }

    /**
     * Method for upload Favicon ico
     * @return void
     * @throws Exception
     */
    public function upload_icoAction()
    {
        Request::ajaxPart(); // if not Ajax part load

        $field   = post('field', true, '#image'); // field where to put file name after uploading
        $preview = post('preview', true, '#preview_image'); // field where to put file name after uploading

        $result = null;
        foreach ($_FILES as $file) {
            if (pathinfo($file['name'], PATHINFO_EXTENSION) !== 'ico') {
                Request::returnError("Favicon must be in ICO format.");
            }
            $result = Storage::upload($file, 'File');
            break;
        }

        Request::addResponse('val', $field, $result['new_name']);
        Request::addResponse('html', $preview, '<img src="' . _SITEDIR_ . Storage::tmpPath() .  $result['new_name'] . '?t=' . time() . '" alt="">');
    }

}
/* End of file */
