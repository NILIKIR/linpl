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
 require_once('db/db.php');
 $_SESSION["SENDER"]=$_SERVER['PHP_SELF'];
 $_SESSION["SENDER_2"]=$_SERVER['PHP_SELF'];
 $conn = DB_CONNECT();

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

   echo "<!doctype html>  <html> 	<head>
        <meta charset='UTF-8'>
        <meta name='description' content='Instalace a podpora linuxu'>
        <meta name='keywords' content='PC, Linux, support'>
        <meta name='author' content='Jan Slovák'>
        <link rel='stylesheet' href='styles/style.css'>
        <title>";

   if (array_key_exists("id_contribution", $_GET)){/*Pokud je dotazováno na stránku metodou GET a id_contribution existuje*/
     if ($_GET["id_contribution"]!="-1")/*Pokud id_contribution nemá hodnotu přiřazenou novému příspěvku*/
     {
       $sql = "SELECT `name`, `text`,`anotace` FROM `knowledgebase` WHERE `id_contribution` = '".
       $_GET["id_contribution"]."'";/*Vybere jméno, anotaci a text příspěvku*/
       $resoult = $conn->query($sql);
       $row = $resoult->fetch_assoc();
       if ($row===NULL){/*Pokud příspěvek neexistuje*/

           if ($_SERVER['HTTP_HOST']==="localhost"){ $url = "/release";}
           header("Location: https://".$_SERVER['HTTP_HOST'].$url."/knowledge_base/editor.php");

       }
     }else{/*Pokud příspěvek existuje*/
       $row = array(
         'name' => "Nový příspěvek",
         'text' => "Moc krásný nový příspěvek",
         'anotace' => "Moc krásný nový příspěvek"
       );
     }
     echo $row['name']."</title>
     <script src='https://cdn.tiny.cloud/1/5puz6sz1rckg45k39l8smm9ad2xgahd3fbgk1autrjtgvstw/tinymce/5/tinymce.min.js' referrerpolicy='origin'></script>
     <script>
       tinymce.init({
         selector: '#text',
         plugins: 'image imagetools lists advlist autolink autoresize charmap emoticons fullscreen hr link print table visualblocks visualchars wordcount',
         toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
           'bullist numlist outdent indent | link image | print media fullscreen | ' +
           'forecolor backcolor | help | charmap emoticons hr link print table view wordcount',
         menubar: 'favs file edit view insert format tools help fullscreen visualblocks visualchars table tabledelete | tableprops tablerowprops tablecellprops | tableinsertrowbefore tableinsertrowafter tabledeleterow | tableinsertcolbefore tableinsertcolafter tabledeletecol'
       })
     </script>

   </head>

   <body>";
   echo "<form action='save.php' method='post'><span class='contribution menu'>
   <span><h3>
     <label name = 'name' id='name_value'>Název příspěvku: </label>
     <input type='text' name='name' id='name' value='".$row['name']."'>
   </h3></span>
   <span><h3>
     <label name = 'anotace' id='anotace_value'>Anotace příspěvku:</label>
     <input style='width:300px' type='text' name='anotace' id='name' value='".$row['anotace']."'>
   </h3></span>
   <span><a href='editor.php'><img class='image' height='65px' src='../icons/menu.svg'></a></span></span>

   <span style='top:128px' class='contribution'>
     <textarea name='text' id='text'>".$row['text']."</textarea>
     <button type='submit' name='button'>Uložit příspěvek</button>
     <input style='display:none' type='text' name='id_contribution' value='".$_GET['id_contribution']."'>
     <a href='upload_image.php' target='_blank'><button type='button' name='button'>Nahrát obrázek</button></a>
     <a href='galery.php' target='_blank'><button type='button' name='button'>Najít nahraný obrázek</button></a>
   </form></span>";

   }else {
     echo "Naše články o linuxu</title>
     </head><body>";
     $sql = "SELECT `name`, `anotace`, `id_contribution`, `published` FROM `knowledgebase`"; /*Vybere všechny články z databáze*/
     echo "<span class='contribution menu'>
             <h6 id='logout' ><a href='logout.php' style='text-decoration:none;'>log out</a></h6>
             <span class='a'><h3>Naše články o linuxu</h3></span>
             <span><a href='view.php'><h3>Uživatelská část webu</a></h3></span>
             <span><a href='editor.php?id_contribution=-1'><h3>Nový článek</h3></a></span>
             <span><a href='galery.php'><h3>Galerie obrázků</h3></a></span>
             <span><a href='index.php'><h3>Hlavní stránka</h3></a></span>
           </span>";
     $pom = 142;/*vzdálenost prvního článku od začátku stránky*/
     $resoult = $conn->query($sql);
     while($row = $resoult->fetch_assoc()){/*Pokud mohu z $resoult dá smazat řádek a zapsat ho do $row*/
       echo "<span style='top:".$pom."px;";
       if ($row["published"]==="1"){ echo "background-color: lightgreen;";}
       echo "' class='contribution menu'>
         <span class='a'><a href='view.php?id_contribution=".$row['id_contribution']."'>
           <h3>".$row['name']."</h3></a></span>
           <span class='b'><span><h3>Článek číslo: ".$row['id_contribution']." </h3></span>
           <span><b class='odkazy'>
             <h3> <a href='editor.php?id_contribution=".$row['id_contribution']."'> EDITOVAT </a></h3></b></span>
             <span><b class='odkazy'><h3><a href='knowledge_base/publicize.php?id_contribution=".$row['id_contribution']."&menu=true'> ";
       if ($row["published"]==="1"){/*Pokud je článek publikován*/
         echo "STÁHNOUT";
       }else{/*Pokud článek publikován není*/
         echo "PUBLIKOVAT";
       }
       echo "</a></h3></b> </span>
             <span><b class='odkazy'><h3> <a href='delete.php?id_contribution=".$row['id_contribution']."'> SMAZAT </a></h3></b></span></span></span> ";
       $pom = $pom+114;/*Vzdálenost druhého+ článku od začátku stránky*/

     }
     echo "</form>";
   }
 }
?>
