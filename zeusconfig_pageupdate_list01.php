<?php

	define("HOST", "sql7.freesqldatabase.com"); // E' il server a cui ti vuoi connettere.
	define("USER", "sql7257357"); // E' l'utente con cui ti collegherai al DB.
	define("PASSWORD", "CmztYDupy7"); // Password di accesso al DB.
	define("DATABASE", "sql7257357"); // Nome del database.

$id = $_GET["id"];
$set = $_GET["set"];

$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);

	$query = "UPDATE `licenze_zeus` SET `auth`= ".$set." WHERE `ID` = ".$id;
	$result = mysqli_query($mysqli,$query);
	if(!$result2){	die('Errore nella Disattivazione della Licenza: ' . mysql_error());	}
	else $response = "La Licenza Associata all'Account è stata Correttamente Modificata";
	
mysqli_close($mysqli);	

?>