<?php
/**
 * PhpMailer
 */
require_once(_SYSDIR_ . 'system/lib/phpmailer/class.phpmailer.php');

class Mail extends PHPMailer
{
    protected static $token; // Using for pixel-image in emails
    public static $body;

    public function initDefault($subject = '', $body = '')
    {
        if (SMTP_MODE == 'enabled') {
            $this->SMTPDebug = 0; // Enable verbose debug output /2
            $this->isSMTP();
            $this->SMTPSecure = 'tls';

            $this->Host = SMTP_HOST;
            $this->Port = SMTP_PORT;
            if (SMTP_USERNAME != '') {
                $this->SMTPAuth  = true;
                $this->Username  = SMTP_USERNAME;
                $this->Password  =  SMTP_PASSWORD;
            }
        }

        self::$token = randomHash();
        self::$body = $body;

        $this->ContentType  = 'text/html';
        $this->CharSet      = 'utf8';
        //$this->Encoding     = 'base64';

        $this->IsHTML(true);
        $this->SetFrom(Request::getParam('noreply_mail'), reFilter(Request::getParam('noreply_name')));

        $this->Subject  = $subject;
        $this->Body     = self::getTemplate();
        $this->AltBody  = 'Note: Our emails are a lot nicer with HTML enabled!';
    }

    public function addAddress($address, $name = '')
    {
        $arr = explode(',', $address);
        foreach ($arr as $item)
            parent::addAddress(trim($item), $name);

        parent::addAddress($address, $name);

        // Send copy of email to tester
        if (Request::getParam('test_mode') == 'yes') {
            $testers = explode(',', Request::getParam('test_mode_email'));
            foreach ($testers as $te)
                parent::addCC(trim($te), 'Test Copy');
        }
    }

    public static function getTemplate()
    {
        ob_start("viewParser");
        include(_SYSDIR_ . 'system/email_layout/email.php');
        ob_end_flush();

        return processTemplate(Request::getParam('buffer'));
    }

    public static function getToken()
    {
        return self::$token;
    }

    public static function getBody()
    {
        return self::$body;
    }

    public function sendEmail($entity = false, $entityId = false)
    {
        $status = $this->Send();

        if ($status)
            self::log($this->to[0][0], self::getToken(), $entity, $entityId);
        else
            self::log($this->to[0][0], self::getToken(), $entity, $entityId, 'failed');

        return $status;
    }

    public static function log($email, $token, $entity = false, $entityId = false, $status = 'sent')
    {
        if ($entity && $entityId)
            $entity = $entity . '#' . $entityId;

        $data = [
            'email'     => $email,
            'entity'    => $entity,
            'token'     => $token,
            'status'    => $status,
            'time'      => time()
        ];

        $result = Model::insert('email_logs', $data);
        $insertId = Model::insertID();

        if (!$result && $insertId)
            return true;

        return false;
    }
}
/* End of file */