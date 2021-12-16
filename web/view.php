<?php
/*
 * Úvodní stránka uživatelského rozhraní knowledgebase (LINPL) + zobrazení jednotlivých článků
 * Projekt: LINPL
 * Vytvořil: Janek
 */
 if(!isSet($_SERVER['HTTPS'])){ /*Kontrolova, zda je připojení HTTPS*/
   header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
 }
 session_start();/*Připojování k session*/

$_SESSION["SENDER"] = $_SERVER['PHP_SELF'];

require_once('db/db.php');/*Připojení k databázi*/
$conn = DB_CONNECT();

$row=null;

if (array_key_exists("id_contribution", $_GET)){/*Pokud je dotazováno na stránku metodou GET a id_contribution existuje*/
  $sql = "SELECT `name`, `text`, anotace FROM `knowledgebase` WHERE `id_contribution` = '".$_GET["id_contribution"].
  "' AND `published` = 1";/*Vybere jméno, text a anotaci příspěvku, jehož id je posláno skrze GET*/
  $resoult = $conn->query($sql);
  $row = $resoult->fetch_assoc();
}

echo "<!doctype html>
<html>
  <head>
    <meta charset='UTF-8'>
    <meta name='description' content='Instalace a podpora linuxu'>
    <meta name='keywords' content='PC, Linux, support'>
    <meta name='author' content='Jan Slovák'>
    <link rel='stylesheet' href='styles/style.css'>	<title>";

if (is_array($row)) {/*Pokud $row obsahuje článek*/
  echo $row['name']."</title>	</head>	<body>
  <span class='contribution'><span class='menu'><span class='a'><h1>".$row['name']."</h1></span>
  <span><h3>".$row['anotace']."</h3></span><span><a href='view.php'>
  <img class='image' src='icons/cross.svg'></a></span>";
  if_logged();
  echo"</span>";
  echo htmlspecialchars_decode($row["text"],ENT_QUOTES);

}else {/*Pokud $row článek neobsahuje*/
  echo "Naše články o linuxu</title>  	</head>  	<body>";
  echo "<span class='contribution menu'><span class='a'><h1>Naše články o linuxu</h1></span>
  <span><a href='index.php'><h1>Hlavní stránka</h1></a></span>
  <h6 id='administration'><a href='editor.php' style='text-decoration:none;'>administration</a></h6>";
  if_logged();
  echo  "</span>";
  $pom = 142;/*vzdálenost prvního článku od začátku stránky*/
  $sql = "SELECT `name`, `anotace`, `id_contribution` FROM `knowledgebase` WHERE `published` = 1";/*Nahraj všëchny publikované články*/
  $resoult = $conn->query($sql);
  while($row = $resoult->fetch_assoc()){/*Pokud mohu z $resoult dá smazat řádek a zapsat ho do $row*/
    echo "<a style='color:black' href='view.php?id_contribution=";
    echo $row['id_contribution'];
    echo "'><span style='top:".$pom."px' class='contribution menu'><span class='a'><h3>";
    echo $row["name"];
    echo ": ";
    echo "</h3></span><span><h3>".$row['anotace']."</h3></span></span></a>";
    $pom = $pom+114;/*Vzdálenost druhého+ článku od začátku stránky*/

  }
}
function if_logged(){
  if (array_key_exists("logged_in", $_SESSION)) {/*Pokud je v rámci session klíč logged_in*/
    if($_SESSION["logged_in"] === true){/*Pokud je "logged_in" roven true*/
      echo '<h6 id="logout" ><a href="logout.php" style="text-decoration:none;">log out</a></h6>';
    }
  }
}
?>
