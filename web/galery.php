<?php
/*
 * seznam obrázků
 * Projekt: LINPL
 * Vytvořil: Janek
 */
 if(!isSet($_SERVER['HTTPS'])){ /*Kontrolova, zda je připojení HTTPS*/
   header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
 }
 session_start();/*Připojování k session*/
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
 }

 ?><html>

 	<head>

 		<title>Galerie</title>
     <meta charset="UTF-8">
     <meta name="description" content="Instalace a podpora linuxu">
     <meta name="keywords" content="PC, Linux, support">
     <meta name="author" content="Jan Slovák">

  	 <link rel="stylesheet" href="styles/style.css">

 	</head>

 	<body>
    <span class="contribution menu">
 <a href="editor.php"><img class="upload_image" height='100px' src="icons/editor.svg"></a>
 <a href="upload_image.php"><img class="upload_image" height='100px' src="icons/add_picture.svg"></a>

 <h6 id="logout" ><a href="logout.php" style="text-decoration:none;">log out</a></h6>

 <?php

 foreach (glob("images/*.*") as $soubor) {/*Pro každý soubor ze složky images*/
     echo "<a href='".$soubor."'><img height='100px' style='margin-left:20px' src='".$soubor."' alt='".$soubor."'></a>";
 }
 ?></span>
</body>
</html>
