<?php
//print_r ($_REQUEST);

$errors =[];
//валідація даних дописати
if (empty($_REQUEST['zain'])) {
    $errors[] = 'Веедіть організаційну форму';
}
if (empty($_REQUEST['oper'])) {
    $errors[] = 'Введіть кількість документів';
}
if (empty($_REQUEST['name'])) {
    $errors[] = 'Введіть Ім*я';
}
if (empty($_REQUEST['email'])) {
    $errors[] = 'Введіть електронну пошту';
} else if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'неправильний email';
}
if (empty($_REQUEST['phone'])) {
    $errors[] = 'Ведіть phone';
   define("REGEXP_PHONE_UA",""/^\+380\d{3}\d{2}\d{2}\d{2}$/"");
   $string = "+380971234567";
   var_dump(filter_var($string, FILTER_VALIDATE_REGEXP,array("options"=>array("regexp"=>REGEXP_PHONE_UA))));
   $errors[] = 'неправильний phone';
}
if (empty($_REQUEST['mens'])) {
    $errors[] = 'Введіть кількість працівників';
}
if (empty($_REQUEST['system'])) {
    $errors[] = 'Введіть систему оподаткування';
}
if (empty($_REQUEST['pdv'])) {
    $errors[] = 'Вкажіть чи є ви платником ПДВ';
}
if (empty($_REQUEST['vidd'])) {
    $errors[] = 'Введіть вид діяльності';
}
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
   $subject = 'Запит розрахунку ціни';

   $zain        = htmlspecialchars(stripslashes($data["zain"]));
   $oper        = htmlspecialchars(stripslashes($data["oper"]));
   $name       = htmlspecialchars(stripslashes($data["name"]));
   $email       = htmlspecialchars(stripslashes($data["email"]));
   $phone       = htmlspecialchars(stripslashes($data["phone"]));
   $mens       = htmlspecialchars(stripslashes($data["mens"]));
   $system      = htmlspecialchars(stripslashes($data["system"]));
   $pdv       = htmlspecialchars(stripslashes($data["pdv"]));
   $vidd       = htmlspecialchars(stripslashes($data["vidd"]));

   $message = "Новий запит розрахунку ціни.<br /><br />";
   $message .= "Форма: <b>{$zain}</b><br />";
   $message .= "Електронка: <b>{$email}</b><br />";
   $message .= "К-ть Документів: <b>{$oper}</b><br />";
   $message .= "Кількість працівників: <b>{$mens}</b><br />";
   $message .= "Ім'я: <b>{$name}</b><br />";
   $message .= "Телефон: <b>{$phone}</b><br />";
   $message .= "Система оподаткування: <b>{$system}</b><br />";
   $message .= "Платник чи неплатник ПДВ: <b>{$pdv}</b><br />";
   $message .= "Вид діяльності: <b>{$vidd}</b><br />";

   $header = "From:{$from} \r\n";
   $header .= "MIME-Version: 1.0\r\n";
   $header .= "Content-type: text/html; charset=UTF-8\r\n";

   $result = mail($to, $subject, $message, $header);
   return $result;
}