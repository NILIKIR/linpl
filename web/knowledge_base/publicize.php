<?php
/*
 * modul publikování a skrývání příspěvků
 * Projekt: LINPL
 * Vytvořil: Janek
 */
 require_once('../db/db.php');
 $conn = DB_CONNECT();

 session_start();

 $logged_in=false;
 if(!empty($_SESSION["logged_in"])){/*Pokud je klíč "logged_in" zapsán v session*/
   $logged_in = $_SESSION["logged_in"];
 }
 if (!$logged_in){/*Pokud uživatel není přihlášen*/
   $_SESSION["SENDER"]=$_SERVER['PHP_SELF'];

   if ($_SERVER['HTTP_HOST']==='localhost') {/*Pokud je přistupováno ze serveru localhost*/
     header("Location: https://".$_SERVER['HTTP_HOST']."/release/login.php");
   }else{
     header("Location: https://".$_SERVER['HTTP_HOST']."/login.php");
   }
 } else {/*Pokud uživatel je přihlášen*/
   if (array_key_exists("id_contribution", $_GET)&&array_key_exists("menu", $_GET)){/*Pokud existují klíče id_contribution a menu*/
     $sql = "SELECT published FROM knowledgebase WHERE id_contribution = ".$_GET['id_contribution'];/*Vyber vše o příspěvku*/
     $resoult = $conn->query($sql);
     if($row = $resoult->fetch_assoc()){/*Pokud příspěvek existuje*/
       if ($row["published"]==="1"){ $sql = "UPDATE knowledgebase SET published = '0' where id_contribution=".$_GET['id_contribution'];}
       else {$sql = "UPDATE knowledgebase SET published = '1' where id_contribution=".$_GET['id_contribution'];}/*Pokud je příspěvek publikovaný, stáhni ho a naopak*/
       if($conn->query($sql)){/*Pokud se ti podaří publikovat/stáhnout příspěvek*/
         if ($_SERVER['HTTP_HOST']==="localhost"){ $url = "/release";}
         if ($_GET["menu"]) {
           header("Location: https://".$_SERVER['HTTP_HOST'].$url."/editor.php");
         }else {
           echo $conn->error;
         }
       }
     }

   }
 }?>
