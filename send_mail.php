<?php

//$admin_mail = 'studio@champin12.com';
$admin_mail = 'bulgakows@gmail.com';

$post = $_POST;
$docs = array();


switch ( $post['type'] ) {
    case 'call_form':
        $name = $post['name'];
        $phone = $post['phone'];

        $subject = 'Champin - Заказ звонка!';
        $message = "<h2>Пользователь $name, тел.: $phone, просит перезвонить ему.</h2>";
        
        $res = send_mail($admin_mail, $subject, $message);
        
        echo json_encode($res);
        
        break;
    case 'tarif_form':
        $name = $post['name'];
        $email = $post['email'];
        $page = $post['phone'];
        $tarif = $post['tarif'];
        
        $subject_user = 'Champin - Заказ';
        $message_admin = "<h2>Пользователь $name, email: $email, оставил заявку на тариф $tarif.</h2>";
        
        $message_user = "<h2>Приветствуем, $name!</h2>
                <p>Мы получили вашу заявку и свяжемся с вами в течение 15 минут, 
                а пока вы ожидаете звонка, предлагаем ознакомиться с нашим коммерческим предложением.</p>
                <br /><br />--<br />Продуктивного дня. Champin Do It";
        
        $res = send_mail($admin_mail, $subject_user, $message_admin, $email, $subject_user, $message_user);
        echo json_encode($res);
        
        
        break;
    case 'pages_form':
        $name = $post['name'];
        $email = $post['email'];
        $page = $post['page'];
        
        $subject_admin = 'Champin - Заказ';
        $message_admin = "<h2>Пользователь $name, email: $email, оставил заявку на $page.</h2>";
        
        $subject_user = 'Champin - подтверждение заявки!';
        $message_user = "<h2>Приветствуем, $name!</h2>
                <p>Мы получили вашу заявку и свяжемся с вами в течение 15 минут, 
                а пока вы ожидаете звонка, предлагаем ознакомиться с нашим коммерческим предложением.</p>
                <br /><br />--<br />Продуктивного дня. Champin Do It";
        
        $res = send_mail($admin_mail, $subject_admin, $message_admin, $email, $subject_user, $message_user);
        echo json_encode($res);
        
        break;
    case 'portfolio_form':
        $name = $post['name'];
        $email = $post['email'];

        $subject = 'Champin - Запрос на полное портфолио!';
        $message = "<h2>Пользователь $name - $email - запрашивает полное портфолио.</h2>";
        $res = send_mail($admin_mail, $subject, $message);
        
        echo json_encode($res);
        break;
    case 'brif_req':
        $name = $post['name'];
        $email = $post['email'];
        
        $subject = 'Champin - Запрос на бриф!';
        $message = "<h2>Пользователь $name - $email запросил бриф на разработку.</h2>";
        
        $message_user = "<h2>Приветствуем, $name!</h2>
                <p>Мы очень рады, что вы приняли решение заполнить наш <a href=\"http://champin12.com/brif.doc\">бриф</a>.
                   Готовый бриф вы можете отправить в ответном письме,
                   и мы свяжемся с вами для обсуждения деталей.</p>
                <br /><br />--<br />Продуктивного дня. Champin Do It";

        echo json_encode(
            send_mail($admin_mail, $subject, $message, $email, $subject, $message_user)
        );
    
        break;
    case 'brief_form':
        
        if ( $_FILES['file1'] ) {
            $docs['file1'] = saveFile($_FILES['file1']);
        }
        if ( $_FILES['file2'] ) {
            $docs['file2'] = saveFile($_FILES['file2']);
        }
        if ( $_FILES['file3'] ) {
            $docs['file3'] = saveFile($_FILES['file3']);
        }
        
        $subject = 'Champin - Бриф!';
        $message = "<h2>Пользователь ".$post['step4-4']." - ".$post['step4-6']." заполнил бриф на разработку.</h2>";
        $message .= '<table>';
        $message .= '<tr><td>Шаг 1. О компании</td><td></td></tr>';
        $message .= '<tr><td>Название компании</td><td>'.$post['step1-1'].'</td></tr>';
        $message .= '<tr><td>Описание услуг и товаров</td><td>'.$post['step1-2'].'</td></tr>';
        $message .= '<tr><td>География деятельности</td><td>'.$post['step1-3'].'</td></tr>';
        $message .= '<tr><td>Целевая аудитория</td><td>'.$post['step1-4'].'</td></tr>';
        $message .= '<tr><td>Цели создания сайта</td><td>'.$post['step1-5'].'</td></tr>';
        $message .= '<tr><td>Что должен сделать или почувствовать посетитель?</td><td>'.$post['step1-6'].'</td></tr>';
        $message .= '<tr><td>Адрес сайта</td><td>'.$post['step1-7'].'</td></tr>';
        
        $message .= '<tr><td>Шаг 2. Дизайн</td><td></td></tr>';
        $message .= '<tr><td>Фирменный стиль</td><td>';
        $message .= $docs['file1'] ? ('<a href="http://champin12.com'.$docs['file1'].'">'.файл.'</a>'):'';
        $message .= '</td></tr>';
        $message .= '<tr><td>Предпочтительные цвета</td><td>'.$post['step2-2'].'</td></tr>';
        $message .= '<tr><td>Пожелания к дизайну</td><td>';
        if (count($post['step2-3'])) foreach($post['step2-3'] as $s) {
            $message .= $s . ', ';
        }
        $message .= '</td></tr>';
        $message .= '<tr><td>Пожелания своими словами</td><td>'.$post['step2-4'].'</td></tr>';
        $message .= '<tr><td>Примеры</td><td>'.$post['step2-5'].'</td></tr>';
        
        $message .= '<tr><td>Шаг 3. Функционал</td><td></td></tr>';
        $message .= '<tr><td>Техническое задание</td><td>';
        $message .= $docs['file2'] ? ('<a href="http://champin12.com'.$docs['file2'].'">'.файл.'</a>'):'';
        $message .= '</td></tr>';
        $message .= '<tr><td>Структура</td><td>';
        if (count($post['step3-2']))foreach($post['step3-2'] as $s) {
            $message .= $s . ', ';
        }
        $message .= '</td></tr>';
        $message .= '<tr><td>Комментарии к структуре</td><td>'.$post['step3-3'].'</td></tr>';
        $message .= '<tr><td>Сайты с желаемой структурой</td><td>'.$post['step3-4'].'</td></tr>';
        $message .= '<tr><td>Возможность самостоятельного заполнения сайта через систему управления</td><td>'.($post['step3-5'] ? "Да" : 'Нет').'</td></tr>';
        
        $message .= '<tr><td>Шаг 4. Реквизиты заказчика</td><td></td></tr>';
        $message .= '<tr><td>Реквизиты для составления договора</td><td>';
        $message .= $docs['file3'] ? ('<a href="http://champin12.com'.$docs['file3'].'">'.файл.'</a>'):'';
        $message .= '</td></tr>';
        $message .= '<tr><td>Pеквизиты заказчика</td><td>'.$post['step4-2'].'</td></tr>';
        $message .= '<tr><td>Удобен наличный расчет</td><td>'.($post['step4-3'] ? 'Да' : 'Нет').'</td></tr>';
        $message .= '<tr><td>Имя контактного лица</td><td>'.$post['step4-4'].'</td></tr>';
        $message .= '<tr><td>Телефон</td><td>'.$post['step4-5'].'</td></tr>';
        $message .= '<tr><td>E-mail</td><td>'.$post['step4-6'].'</td></tr>';
        $message .= '<tr><td>Когда удобно приехать для обсуждения проекта?</td><td>'.$post['step4-7'].'</td></tr>';
        $message .= '</table>';
                
        $res = send_mail($admin_mail, $subject, $message, $post['step4-6'], $subject, $message);
        
        echo json_encode($res);
        break;   
}


exit;


function send_mail($to, $subject_admin, $text_admin, $to_user = false, $subject_user = false, $text_user = false ){
    $message_admin = "<html><head><title>$subject_admin</title></head><body>$text_admin</body></html>";
    $headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
        'From: noreplay@champin12.com' . "\r\n" .
        'Reply-To: noreplay@champin12.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    $res_admin = mail($to, $subject_admin, $message_admin, $headers);

    if ( $to_user || $subject_user || $text_user ) {
        $message_user = "<html><head><title>$subject_user</title></head><body>$text_user</body></html>";

        $res_user = mail($to_user, $subject_user, $message_user, $headers);
    }
    return array( 'status' => array('admin' => $res_admin, 'user' => $res_user) );
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function saveFile($file) {
    $folder = 'files';
    $dir = __DIR__ . '/'.$folder;
    if ( !is_dir($dir) ) {
        mkdir($dir, 0777, true);
    }
    $info = pathinfo($file['name']);
    $ext = $info['extension']; 
    $str = generateRandomString();
    $newname = $str.".".$ext; 

    $target = '/'.$folder.'/'.$newname;
    if (move_uploaded_file( $file['tmp_name'], __DIR__.$target) ) {
        return $target;
    } else {
        return false;
    }
}
?>
