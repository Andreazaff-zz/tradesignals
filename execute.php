<?php
	
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

$response = '';
	if (strpos ($text, "/start") === 0 )
	{
		$response = $response = "Ciao $firstname, con questo Bot sarai in grado di ricevere le notifiche della MetaTrader 4 direttamente sul tuo account Telegram.\n\nIl codice di questa Chat è: $chatId\nInserisci questo codice nei parametri del tuo Expert Advisor e riceverai tutte le notifiche in questa chat.\n\nQuesto Bot è di proprietà di Andrea Zaffignani ed è compatibile solo con i suoi Expert Advisor.\nTutti i diritti sono riservati. ©\n";
	}
		else
		{
			$response = "Comando Non Abilitato!\r\nContattare il Gestore del Servizio";
		}

header("Content-Type: application/json");
$parameters = array('chat_id' => $chatId, "text" => $response);
$parameters["method"] = "sendMessage";
echo json_encode($parameters);
