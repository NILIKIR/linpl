<?php
/*
 * modul mazání příspěvků
 * Projekt: LINPL
 * Vytvořil: Janek
 */
 require_once('../db/db.php');
 $conn = DB_CONNECT();
 session_start();
 $_SESSION["SENDER"]=$_SERVER['PHP_SELF'];

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
   if ($_SERVER['HTTP_HOST']==="localhost"){ $url = "/release";}
   $sql = "SELECT id_contribution FROM knowledgebase WHERE id_contribution = ".$_GET['id_contribution'];/*Vyber všechny informace o článku s ID*/
   $resoult = $conn->query($sql);
   if($row = $resoult->fetch_assoc()){/*Pokud výsledek existuje*/
     $sql = "DELETE FROM knowledgebase WHERE id_contribution=".$_GET['id_contribution'];/*Smaž článek*/
     $conn->query($sql);
     header("Location: https://".$_SERVER['HTTP_HOST'].$url."editor.php");/*Přepni zpět do editoru*/
   }
 }?>
