<?php
//print_r ($_REQUEST);

$errors =[];

if (empty($_REQUEST['name'])) {
    $errors[] = 'Веедіть Ім*я';
}
if (empty($_REQUEST['email'])) {
    $errors[] = 'Введіть електронну адресу';
}
if (empty($_REQUEST['mobile'])) {
    $errors[] = 'Введіть телефон';
    if (empty($errors)){
        $result = sendMail($_REQUEST);
        if (false === $result) {
        $response = ['status' => 'fail',
                      'messages' => ['Помилка відпрвки повідомлення, зателефонуйте нам']
        ];
        }
        else {
            $response = [
                 'status'   => 'success'
              ];
        }

    } else {
        $response = [
           'status'   => 'fail',
           'messages' => $errors,
        ];
    }

    displayJson($response);

    function displayJson($data, $jsonpCallback = null)
    {
       header('Cache-Control: no-store, no-cache, must-revalidate, private');
       header('Pragma: no-cache');
       header('Content-Type: application/x-javascript; charset=utf-8');

       $json = json_encode($data);
       if (null !== $jsonpCallback) {
           $json = $jsonpCallback . '(' . $json . ');';
       }

       die($json);
    }

    function sendMail($data)
    {

       $to          = 'kur3eme@gmail.com';
       $from        = 'root@localhost';
       $subject = 'Запит Контакту';

        $name        = htmlspecialchars(stripslashes($data["name"]));
        $email        = htmlspecialchars(stripslashes($data["email"]));
        $mobile       = htmlspecialchars(stripslashes($data["mobile"]));

          $message = "Новий запит контакту.<br /><br />";
          $message .= "Ім*я: <b>{$name}</b><br />";
          $message .= "Електронка: <b>{$email}</b><br />";
          $message .= "Телефон: <b>{$mobile}</b><br />";

          $header = "From:{$from} \r\n";
             $header .= "MIME-Version: 1.0\r\n";
             $header .= "Content-type: text/html; charset=UTF-8\r\n";

             $result = mail($to, $subject, $message, $header);
             return $result;
          }