<?php

/**
 *
 * @author BulgakowS <bulgakows@gmail.com>
 * 
 */

class SendMail {

    private $_params = array(
        'email' => '',
        'from_name' => '',
        'from_mail' => '',
        'subject' => '',
        'message' => '',
        'files' => array(),
        'charset' => 'utf-8',
        'content_type' => 'plain',
        'time_limit' => 30
    );
    private $_error = true;
    private $_error_text = '<br><span style="color:#F00;">';

    public function __call($name, $param) {
        if (!isset($this->_params[$name])) {
            $this->_error_text .= 'Некорректный параметр! ' . $name . '()<br>';
            $this->_error = false;
        } else if (count($param) > 1) {
            $this->_error_text .= 'Ожидается 1 параметр в ' . $name . '()!<br>';
            $this->_error = false;
        } else {
            $this->_params[$name] = isset($param[0]) ? $param[0] : '';
        }

        return $this;
    }

    private function _error_email() {
        if (empty($this->_params['email'])) {
            $this->_error = false;
            $this->_error_text .= 'Не указан параметр: email()<br>';
        }

        if (empty($this->_params['from_mail'])) {
            $this->_error = false;
            $this->_error_text .= 'Не указан параметр: from_mail()<br>';
        }

        $this->_error_text .= '</span>';

        return $this->_error;
    }

    public function send() {
        if ($this->_error_email() === false)
            echo $this->_error_text;
        else
            return $this->_send();
    }

    private function _send() {
        $from_name = '=?' . $this->_params['charset'] . '?B?' . base64_encode($this->_params['from_name']) . '?=';
        $subject = '=?' . $this->_params['charset'] . '?B?' . base64_encode($this->_params['subject']) . '?=';

        $header = "From: " . $from_name . " <" . $this->_params['from_mail'] . ">\r\n";
        $header .= "Reply-To: " . $this->_params['from_mail'] . "\r\n";
        $header .= "MIME-Version: 1.0\r\n";

        // Если есть прикреплённые файлы
        if (!empty($this->_params['files'])) {
            if (!is_array($this->_params['files']))
                $this->_params['files'] = array($this->_params['files']);

            $bound = md5(uniqid(time())); // Разделитель

            $header .= "Content-Type: multipart/mixed; boundary=\"" . $bound . "\"\r\n";
            $header .= "This is a multi-part message in MIME format.\r\n";

            $message = "--" . $bound . "\r\n";
            $message .= "Content-Type: text/" . $this->_params['content_type'] . "; charset=" . $this->_params['charset'] . "\r\n";
            $message .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";

            $message .= $this->_params['message'] . "\r\n\r\n";

            $finfo = finfo_open(FILEINFO_MIME_TYPE);

            foreach ($this->_params['files'] as $file_name) {
                $name = preg_replace('~.*([^/|\\\]+)$~U', '$1', $file_name);
                $name = iconv('cp1251', 'UTF-8', $name);
                $name = "=?" . $this->_params['charset'] . "?B?" . base64_encode($name) . "?=";

                $message .= "--" . $bound . "\r\n";
                $message .= "Content-Type: " . finfo_file($finfo, $file_name) . "; name=" . $name . "\r\n";
                $message .= "Content-Transfer-Encoding: base64\r\n";
                $message .= "Content-Disposition: attachment; filename=\"" . $name . "\"; size=" . filesize($file_name) . ";\r\n\r\n";
                $message .= chunk_split(base64_encode(file_get_contents($file_name))) . "\r\n";
            }

            $message .= $bound . "--";
        } else { // Если нет файлов
            $header .= "Content-type: text/" . $this->_params['content_type'] . "; charset=" . $this->_params['charset'] . "\r\n";
            $message = $this->_params['message'];
        }


//        set_time_limit($this->_params['time_limit']);
        
        $res = false;
        
        // Отправка сообщения  
        if (is_array($this->_params['email'])) {
            foreach ($this->_params['email'] as $email)
                $res = @mail($email, $subject, $message, $header);
        } else {
            $res = @mail($this->_params['email'], $subject, $message, $header);
        }
        return $res;
    }
    
}

?>
