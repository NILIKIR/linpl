<?php
/*
 * editor databáze příspěvků
 * Projekt: LINPL
 * Vytvořil: Janek
 */
 if(!isSet($_SERVER['HTTPS'])){ /*Kontrolova, zda je připojení HTTPS*/
 	 header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
 }
 session_start();/*Připojování k session*/

 if (empty($_POST)) {/*Pokud je na stránku přistupování jinak, než pomocí POST protokolu*/
   $poprve = true;
 }else{
   if($_POST["LOGIN"]==="01s3H"){/*Pokud je prvek LOGIN ve formuláři roven "01s3h"*/
     $_SESSION["logged_in"]=true;
     header("Location: https://".$_SERVER['HTTP_HOST'].$_SESSION["SENDER"]);
   }else{
     $poprve = false;
   }
 }


   echo "</title>
   <meta charset='UTF-8'>
   <meta name='description' content='Instalace a podpora linuxu'>
   <meta name='keywords' content='PC, Linux, support'>
   <meta name='author' content='Jan Slovák'>
   <link rel='stylesheet' href='styles/style.css'>

  </head>

  <body><span style='right:0;left:0;margin:auto; width:918px;' class='contribution'>
  <form action='login.php' style='width:918px;display:inline-flex; justify-content: space-between;' method='post'><p>";
  if (!$poprve) {
    echo "Zadali jste heslo špatně, zkuste to znovu";
  }else{
    echo"Zadejte heslo";
  }
  echo "</p><input name='LOGIN'><button type='submit' name='button'>ODESLAT</button></form>";
?>
