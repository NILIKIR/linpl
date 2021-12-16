<?php
/*
 * modul mazání příspěvků
 * Projekt: LINPL
 * Vytvořil: Janek
 */
 if(!isSet($_SERVER['HTTPS'])){ /*Kontrolova, zda je připojení HTTPS*/
   header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
 }
 session_start();/*Připojování k session*/

 require_once('db/db.php');/*Připojení k databázi*/
 $conn = DB_CONNECT();

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
   $sql = "SELECT * FROM knowledgebase WHERE id_contribution = ".$_GET['id_contribution'];/*Vyber vše o příspěvku s daným ID*/
   $resoult = $conn->query($sql);
   if($row = $resoult->fetch_assoc()){/*Pokud příspěvek existuje*/
     echo "<!doctype html>
     <html>
     	 <head>
     		 <title>Naše články o linuxu</title>
           <meta charset='UTF-8'>
           <meta name='description' content='Instalace a podpora linuxu'>
           <meta name='keywords' content='PC, Linux, support'>
           <meta name='author' content='Jan Slovák'>
           <link rel='stylesheet' href='styles/style.css'>
         </head>

       <body>";
     echo "' class='contribution menu'><span class='a'><h3>Skutečně chcete smazat článek číslo: "
     .$row['id_contribution']."?</h3></span>
     <span  class='b' id='delete'><span><h3><a href='".$_SESSION['SENDER_2']."'> ZPĚT </a></h3></span>";
     echo "<spab><h3><a href='delete_real.php?id_contribution=".$row['id_contribution']."'> SMAZAT </a> </h3></span></span></span>";
   }
 }?>
