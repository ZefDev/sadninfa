<?php
if (array_key_exists('messageFF', $_REQUEST)) {
   $to = 'sad.ninfa@mail.ru';//zvonki.dpc@mail.ru
   // echo $_POST['nameFF'];
   //echo $_POST['phoneFF'];
   //echo $_POST['messageFF'];
   $subject = 'Заполнена контактная форма с '.$_SERVER['HTTP_REFERER'];
   $subject = "=?utf-8?b?". base64_encode($subject) ."?=";
   $message = "\nИмя: ".$_REQUEST['nameFF']."\nТелефон: ".$_REQUEST['phoneFF']." \nСообщение: ".$_REQUEST['messageFF'];
   $headers = 'Content-type: text/plain; charset="utf-8"';
   $headers .= "MIME-Version: 1.0\r\n";
   $headers .= "Date: ". date('D, d M Y h:i:s O') ."\r\n";
   mail($to, $subject, $message, $headers);
  
}
?>