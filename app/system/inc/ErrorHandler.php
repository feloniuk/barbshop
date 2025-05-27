<?php
/**
 * ErrorHandler
 */

class ErrorHandler
{
    public function __construct()
    {
        // регистрация ошибок
        set_error_handler(array($this, 'OtherErrorCatcher'));

        // перехват критических ошибок
        register_shutdown_function(array($this, 'FatalErrorCatcher'));

        // создание буфера вывода
        ob_start();
    }

    public function OtherErrorCatcher($errno, $errstr)
    {
        // контроль ошибок:
        // - записать в лог
        return false;
    }

    public function FatalErrorCatcher()
    {
        $error = error_get_last();
        if (isset($error)) {
            if (
                $error['type'] == E_ERROR
                || $error['type'] == E_PARSE
                || $error['type'] == E_COMPILE_ERROR
                || $error['type'] == E_CORE_ERROR
            ) {
                ob_end_clean();    // сбросить буфер, завершить работу буфера

                error_system($error); // Call error displaying

                // контроль критических ошибок:
                // - записать в лог
                // - вернуть заголовок 500
                // - вернуть после заголовка данные для пользователя
            } else {
                ob_end_flush();    // вывод буфера, завершить работу буфера
            }
        } else {
            ob_end_flush();    // вывод буфера, завершить работу буфера
        }
    }
}

/* End of file */