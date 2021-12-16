<?php
/*
 * editor databáze příspěvků
 * Projekt: LINPL
 * Vytvořil: Janek
 */
 session_start();
 require_once('../db/db.php');
 $conn = DB_CONNECT();
 $_SESSION["SENDER"]=$_SERVER['PHP_SELF'];
 $_SESSION["SENDER_2"]=$_SERVER['PHP_SELF'];

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
 } else {/*Pokud uživatel je přihlášen*/ {
   if ($_POST['id_contribution']==="-1") {/*Pokud se jedná o nový příspěvek*/
     $sql = "INSERT INTO `knowledgebase`(`id_contribution`, `name`, `text`, `anotace`, `published`) VALUES (NULL,'".mysqli_real_escape_string($conn,$_POST['name'])."','".mysqli_real_escape_string($conn, $_POST['text'])."'
       ,'".mysqli_real_escape_string($conn,$_POST['anotace'])."','1')";/*Vytvoř příspěvek*/
   }else{
     $sql = "UPDATE `knowledgebase` SET `name`='".mysqli_real_escape_string($conn,$_POST['name'])."',`text`='".mysqli_real_escape_string($conn,$_POST['text'])."',`anotace`='".mysqli_real_escape_string($conn,$_POST['anotace'])."'
     ,`published`='1' WHERE `id_contribution`=".mysqli_real_escape_string($conn,$_POST['id_contribution']);/*Uprav příspěvek*/
   }
   if ($conn->query($sql)) {/*POkud se ti podaří uložit*/
     if ($_SERVER['HTTP_HOST']==="localhost"){ $url = "/release";}
       header("Location: https://".$_SERVER['HTTP_HOST'].$url."/view.php?id_contribution=".$conn->insert_id);
   } else {
     echo $conn->error;
   }
 }?>
