<?php

	define("HOST", "89.46.111.72"); // E' il server a cui ti vuoi connettere.
	define("USER", "Sql1248767"); // E' l'utente con cui ti collegherai al DB.
	define("PASSWORD", "85u82a637p"); // Password di accesso al DB.
	define("DATABASE", "Sql1248767_1"); // Nome del database.
	
$content = file_get_contents("php://input");
$update = json_decode($content, true);

if(!$update)
{
  exit;
}
$message = isset($update['message']) ? $update['message'] : "";
$messageId = isset($message['message_id']) ? $message['message_id'] : "";
$chatId = isset($message['chat']['id']) ? $message['chat']['id'] : "";
$firstname = isset($message['chat']['first_name']) ? $message['chat']['first_name'] : "";
$lastname = isset($message['chat']['last_name']) ? $message['chat']['last_name'] : "";
$username = isset($message['chat']['username']) ? $message['chat']['username'] : "";
$date = isset($message['date']) ? $message['date'] : "";
$text = isset($message['text']) ? $message['text'] : "";
$text = trim($text);
$text = strtolower($text);
$string_exploded = explode(":",$text);	//Delete_License:1
$response = '';

	if (strpos ($text, "/start") === 0 )
	{
		if ($chatId == -1001296319190)
		{
			$response = $response = "Ciao $firstname, Benvenuto nel Pannello di Controllo Licenze di Zeus © v3.2\n\nIn questo gruppo saranno inviate tutte le licenze che verranno generate ed attivate nei vari client MT4.\n Utilizzando il comando <b>/Delete_License<b> seguito da \":\" (ID Licenza) sarai in grado di disattivare da remoto la copia di Zeus © per quel Client.\nUtilizzando il comando */Activate_License* seguito da \":\" (ID Licenza) sarai invece in grado di riattivarla.\n\nTutti i diritti sono riservati. ©\n";
		}
			else
			{
				$response = $response = "Ciao $firstname, con questo Bot sarai in grado di ricevere le notifiche della MetaTrader 4 direttamente sul tuo account Telegram.\n\nIl codice di questa Chat è: $chatId\nInserisci questo codice nei parametri del tuo Expert Advisor e riceverai tutte le notifiche in questa chat.\n\nQuesto Bot è di proprietà di Andrea Zaffignani ed è compatibile solo con i suoi Expert Advisor.\nTutti i diritti sono riservati. ©\n";
			}
	}
		else if ($string_exploded[0] == "/delete_license" && $chatId == -1001296319190)
		{	
			$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
				$query1 = "SELECT `name`,`number` FROM `licenze_zeus` WHERE `ID`= ".$string_exploded[1];
				$result1 = mysqli_query($mysqli, $query1);

			if (mysqli_num_rows($result1) > 0) 
			{
				while($row = mysqli_fetch_assoc($result1)) 
				{
					$dbname = $row["name"];
					$dbaccount = $row["number"];
				}
			
				$query2 = "UPDATE `licenze_zeus` SET `auth`= 0 WHERE `ID` = ".$string_exploded[1];
				$result2 = mysqli_query($mysqli,$query2);
					if(!$result2){	die('Errore nella Disattivazione della Licenza: ' . mysql_error());	}
					else $response = "La Licenza Associata all'Account ".$dbaccount." di ".$dbname." è stata Disattivata Correttamente";
				mysqli_close($mysqli);	
			}
			else $response = "L'ID inserito non corrisponde a nessuna Licenza Registrata";
		}
			else if ($string_exploded[0] == "/activate_license" && $chatId == -1001296319190)
			{
			$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
				$query1 = "SELECT `name`,`number` FROM `licenze_zeus` WHERE `ID`= ".$string_exploded[1];
				$result1 = mysqli_query($mysqli, $query1);

			if (mysqli_num_rows($result1) > 0) 
			{
				while($row = mysqli_fetch_assoc($result1)) 
				{
					$dbname = $row["name"];
					$dbaccount = $row["number"];
				}
			
				$query2 = "UPDATE `licenze_zeus` SET `auth`= 1 WHERE `ID` = ".$string_exploded[1];
				$result2 = mysqli_query($mysqli,$query2);
					if(!$result2){	die('Errore nella Riattivazione della Licenza: ' . mysql_error());	}
					else $response = "La Licenza Associata all'Account ".$dbaccount." di ".$dbname." è stata Ripristinata Correttamente";
				mysqli_close($mysqli);	
			}
			else $response = "L'ID inserito non corrisponde a nessuna Licenza Registrata";
			}
				else
				{
					$response = "Comando Non Abilitato!\r\nContattare il Gestore del Servizio @andreazaff";
				}


header("Content-Type: application/json");
$parameters = array('chat_id' => $chatId, "text" => $response);
$parameters["method"] = "sendMessage";
echo json_encode($parameters);
