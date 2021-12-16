<?php
/*
 * Úvodní stránka webu Linux pro lidi (LINPL)
 * Projekt: LINPL
 * Vytvořil: Janek
 */

 if(!isSet($_SERVER['HTTPS'])){ /*Kontrolova, zda je připojení HTTPS*/
 	 header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
 }
 session_start();/*Připojování k session*/
 include_once("db/db.php");/*Připojení k databázi*/
 $conn = DB_CONNECT();
 $_SESSION["SENDER"] = $_SERVER['PHP_SELF'];
 $sql = "select id_contribution, name, anotace from knowledgebase where published = 1";/*načte všechny publikované příspěvky*/
 $data = $conn->query($sql);
 $rows = [];
 $pom = 0;

 while ($row = $data->fetch_assoc()) {/*Pokud lze z $data odebrat řádek a zapsat ho do $row*/
		$rows[$pom] = $row; /*Přidává relativní číslování článků*/
		$pom = $pom+1;
 }

 ?>
 <!doctype html>
 <html>

	 <head>

		 <title>Linux pro lidi</title>
     <meta charset="UTF-8">
     <meta name="description" content="Instalace a podpora linuxu">
     <meta name="keywords" content="PC, Linux, support">
     <meta name="author" content="Jan Slovák">

		 <script type="text/javascript" src="scripts/script.js"></script>

		 <link rel="stylesheet" href="styles/style.css">

 	 </head>

	 <body>
		 <span class="half" id="knowledgebase_span">
  		 <h6 id="administration"><a href="editor.php" style="text-decoration:none;">administration</a></h6>
         <?PHP
           if (array_key_exists("logged_in", $_SESSION)) {/*Pokud je v rámci session klíč logged_in*/
             if($_SESSION["logged_in"] === true){/*Pokud je "logged_in" roven true*/
	             echo '<h6 id="logout" ><a href="logout.php" style="text-decoration:none;">log out</a></h6>';
             }
           }
           echo " <h1 id='knowledgebase_title'> S čím jsme se již potkali? </h1>
     			 <div id='knowledgebase_name'><h3>";
					 foreach ($rows as $row) {/*Vypisuje jména všech článků*/
						 echo $row["name"].", ";
					 }
					 echo "</h3>			</div><div id='knowledgebase_anotation'>";

					 foreach ($rows as $row) {/*Vypisuje jména a anotace dohromady*/
						 echo "<a href='view.php?id_contribution=".$row["id_contribution"]."'><h4>".$row["name"]." - ".$row["anotace"]."</h4></a>";
					 }
				 ?>
			 </div>
			 <button type="button" id="to_knowledgebase" onclick="to_knowledge();"><h1> Podrobnosti </h1></button>
		 </span>

		 <span class="half" id="form_span">
			 <div id="pre_form">
				 <h1>Linux pro lidi</h1>
				 <h3>Máte starý počítač, který si neporadí ani s windows?</h3>
				 <h3>Chtěli byste větší svobodu se svým systémem?</h3>
				 <h3>Chcete prostě změnu?</h3>
				 <button class="nalinux" onclick="displayFce();">	<h3>Přejít na linux</h3> </button>
				 <h3>Proč linux?</h3>
				 <h3>Je rychlý, bezpečný, úsporný, s ohledem na soukromí, má snadné ovládání, jednoduché nastavení a vždy dostupnou pomoc. více na <a href="http://www.linux.cz">www.linux.cz</a> </h3>
				 <button class="nalinux" onclick="displayFce();">	<h3>Přejít na linux</h3> </button>
			 </div>
		 	 <button type='button' id='to_form' onclick='displayFce();'><h1> Přejít na linux </h1></button>
   	 </span>
   </body>
 </html>
