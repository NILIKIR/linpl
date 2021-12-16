<?php
/*
 * Zápis a odesílání dat
 * Projekt: LINPL
 * Vytvořil: Janek
 */


 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
 use PHPMailer\PHPMailer\SMTP;

 require_once('../db/db.php');
 require_once("is_email.php");

 require_once('../lib/phpMailer/src/Exception.php');
 require_once('../lib/phpMailer/src/PHPMailer.php');
 require_once('../lib/phpMailer/src/SMTP.php');

 $mail = new PHPMailer(true);

 $url = "https://www.recaptcha.net/recaptcha/api/siteverify";
 $secret ="*****";
 $userresponse = $_POST["validation_code"];

 $curl = curl_init();

 $fields = array(
   'secret'=> $secret,
   'response' => $userresponse
 );

$json_string = json_encode($fields);

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, $url);

$data = curl_exec($curl);
curl_close($curl);

if(strpos($data, "true")){

  $type_of_pc =  htmlspecialchars($_POST["type_of_computer"], ENT_QUOTES);
  $age_of_pc =  htmlspecialchars($_POST["age_of_computer"],ENT_QUOTES);
  $contact =   htmlspecialchars($_POST["contact"],ENT_QUOTES);
  $contact_from =  htmlspecialchars($_POST["time_from"],ENT_QUOTES);
  $contact_till =  htmlspecialchars($_POST["time_till"],ENT_QUOTES);
  $adv_info =  htmlspecialchars($_POST["adv_info"],ENT_QUOTES);

  $conn = DB_CONNECT();
  $sql = 'INSERT INTO prelim_order (id, type_of_computer, age_of_computer, contact, adv_info, contact_from, contact_till, date_of_request, state)
  VALUES (NULL, "'.$type_of_pc.'", "'.$age_of_pc.'", "'.$contact.'", " '.$adv_info.'", "'.$contact_from.'", "'.$contact_till.'", NULL, "added_now" )'; /*Zápis možné zakázky do databáze*/

  if ($conn->query($sql))
  { /* if saved to database */
    if (is_email($contact))
    { /* if mail is valid */
      include ("mail.php");
      $mail->CharSet = "UTF-8";
      	//$mail->SMTPDebug = SMTP::DEBUG_SERVER;
      $mail->isSmtp();
      $mail->Host = MAIL_HOST;
      $mail->SMTPAuth = true;
      $mail->Username = MAIL_USERNAME;
      $mail->Password = MAIL_PASSWORD;
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port = 12345;
      $support;

      $sql ='select * from mail_generation where id=1';
      $res = ($conn->query($sql));
      $row = $res->fetch_assoc();
      $mail->setFrom($row['MAIL_FROM_MAIL'], $row['MAIL_FROM_NAME']);


      $mail->isHtml(true);
      $mail->Subject = $row['HEADER'];
      $mail->Body = "<p>Dobrý den, </p><p>děkujeme Vám za zanechání kontaktních informací, naši pracovníci Vás budou v blízké době kontaktovat, aby dohodli podrobnosti.<p></p>za Linux pro Lidi<p></p>Jan Slovák</p>";


      if(	!$mail->addAddress($contact, "")){
        echo "neplatná emailová adresa";
      }

      if($mail->send()) {
        echo "true";
      }
      else{
        echo "nepodařilo se odeslat mail";
      }

      $mail->clearAllRecipients();
      $mail->addAddress("entscz@gmail.com");
      $mail->Body = $url;
      $mail->send();

    }
  }/*end of "if saved to database"*/
   else  {/*if saveing to database was not succesfull*/
    echo "Data nebyla zapsána do databáze
    ";
    echo $conn->error;
  }/*end of "if saveing to database was not succesfull"*/
}else{
  echo "false";
}

?>
