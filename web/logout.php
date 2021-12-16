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

 $pom = $_SESSION["SENDER"];/*Kopírování cesty stránky, na které došlo k odhlášení se*/
 $url = "";/*Součást cesty pro přesměrování*/

 if ($_SERVER['HTTP_HOST']==="localhost"){ $url = "/release";}/*Pokud je server localhost -> přidat do cesty složku release*/

 if(($pom === $url."/galery.php")
 ||( $pom === $url."/upload_image.php" )||
 ( $pom === $url."/editor.php")){/*Pokud přichází člověk ze kteréhokoli souboru popuze pro adminy, ukládá view.php do $pom*/
   $pom = $url."/index.php";
 }

  $_SESSION["logged_in"]=false;/*Odhlásit človéka*/

  header("Location: https://".$_SERVER['HTTP_HOST'].$pom);/*Okamžité přesměrování na stránku uloženou v $pom*/

?>
