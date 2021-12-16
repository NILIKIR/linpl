<?php
/*
 * Stránka pro nahrávání obrázků do Linux knowledge base
 * Projekt: LINPL
 * Vytvořil: Michal
 */
 if(!isSet($_SERVER['HTTPS'])){ /*Kontrolova, zda je připojení HTTPS*/
 header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
   }
 session_start();/*Připojování k session*/
 /* relativní cesta ke složce, do které se mají obrázky uložit */
 define('IMAGE_LOCATION', 'images');
 /* povolené přípony souborů */
 define('ALLOWED_EXTENSIONS', ['png', 'gif', 'jpg', 'jpeg', 'jpe', 'jif', 'jfif', 'jfi', 'bmp', 'webp', 'tif', 'tiff']);

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

 ?>
 <!doctype html>
 <html>

  <head>

    <title>Nahrání obrázku</title>
     <meta charset="UTF-8">
     <meta name="description" content="Instalace a podpora linuxu">
     <meta name="keywords" content="PC, Linux, support">
     <meta name="author" content="Jan Slovák">

     <link rel="stylesheet" href="styles/style.css">


  </head>

  <body>
    <span>	<form method='POST' enctype='multipart/form-data'><div class="contribution menu"><div> <?php

 if(isSet($_FILES['imageFile']) && strlen(trim($_FILES['imageFile']['name']))>0){/*Pokud existuje obrázek a má jméno*/

   $imageName = $_FILES['imageFile']['name'];
   $imageLocation = IMAGE_LOCATION.'/'.$imageName;

   $dotPos = strpos($imageName, '.');

   if(!$dotPos || $dotPos==strlen($imageName)-1){/*Pokud soubor nemá příponu*/
     // file does not have an extension
     $error = "Neplatný název souboru!";
   } else {/*Pokud soubor má příponu*/

     $extension = substr($imageName, $dotPos+1);

     if(!in_array($extension, ALLOWED_EXTENSIONS)){
       // file extension is not between allowed extensions
       $error = "Neplatný typ souboru!";
     } else if(file_exists($imageLocation)){
       // file exists
       $error = 'Obrázek se stejným názvem již existuje!';
     } else if(getimagesize($_FILES['imageFile']['tmp_name'])!==false){

       // save the file
       $uploaded = move_uploaded_file($_FILES['imageFile']['tmp_name'], $imageLocation);

       if(!$uploaded){
         // server failed to save the file
         $error = 'Soubor nelze uložit (chyba serveru).';
       }

     } else {
       // file is not a valid image (getimagesize failed)
       $error = 'Nahraný soubor není platný obrázek!';
     }

   }

 } else {
   // no file is chosen
   $error = 'Prosím vyberte obrázek!';
 }

		if($_SERVER['REQUEST_METHOD']==='POST'){

			if(isSet($error)){
				echo $error;
			} else {
				echo '<a href="'.$imageLocation.'">'.$imageLocation.'</a>';
			}

		}

		?>

		<form method="POST" enctype="multipart/form-data">

    </div><div>
      <label for="upload"><img  class="upload_image" height="100px" src="icons/choose_picture.svg"></label>
      <input hidden  id="upload" accept="image/*" type="file" name="imageFile"></input></div>

      <div id="file-chosen">No file chosen
      </div><div><p> Platné přípony obrázků jsou:</p><p>png, gif, jpg, jpeg, jpe, jif, </p><p>jfif, jfi, bmp, webp, tif, tiff</p>
      </div><div><input class="upload_image" type='image' height="100px" src="icons/sent.svg" type="submit"></input>
      </div><div>  <a href="galery.php"><img class="upload_image" height="100px" src="icons/show_pictures.svg"></a>
    	</div><div> <a href="editor.php"><img class="upload_image" height='100px' src="icons/editor.svg"></a></div></div>

      <h6 id="logout" ><a href="logout.php" style="text-decoration:none;">log out</a></h6>
		</form>


    <script type="text/javascript">
       const upload = document.getElementById('upload');

       const fileChosen = document.getElementById('file-chosen');

       upload.addEventListener('change', function(){
       fileChosen.textContent = this.files[0].name
     })
    </script>
  </span>
	</body>

</html>
