<?php
/*
 * Připojení k databázi
 * Popis: funkce pro připojení k databázi, konfigurace načtená ze souboru
 * Vytvořil: Michal
 */
 if(!isSet($_SERVER['HTTPS'])){
 	header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
 }

function DB_CONNECT() {

	$conn = new mysqli("*****", "*****", "*****", "*****");

	if($conn->connect_error) die($conn->connect_error);

	return $conn;

}

?>
