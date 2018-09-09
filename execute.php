<?php

	define("HOST", "localhost"); // E' il server a cui ti vuoi connettere.
	define("USER", "u769934357_copy"); // E' l'utente con cui ti collegherai al DB.
	define("PASSWORD", "xAm-Rg5-TFH-9vF"); // Password di accesso al DB.
	define("DATABASE", "u769934357_user"); // Nome del database.
	
	$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
	
function set_config ($copy, $chat)
{
$url = "http://tradesignals.it/set_config.php?copy=".$copy."&chat=".$chat;
    $ch = curl_init();
    $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
	$result = curl_exec($ch);
	//echo $result;
    curl_close($ch);	
}

function set_start ($boolean)
{
$url = "http://tradesignals.it/set_start.php?ts=".$boolean;
    $ch = curl_init();
    $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
	$result = curl_exec($ch);
	//echo $result;
    curl_close($ch);	
}

function set_paid ($bool)
{
$url = "http://tradesignals.it/set_paid.php?bool=".$bool;
    $ch = curl_init();
    $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
	$result = curl_exec($ch);
	//echo $result;
    curl_close($ch);	
}
	
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
	if (strpos ($text, "/start") === 0 || $text=="ciao")
	{
		$response = "Ciao $firstname, Benvenuto sul Configuratore del Copy di TradeSignals!\r\n\r\nHai a disposizione diversi comandi:\r\n/launch_copy per Attivare l'Investimento Automatico,\r\n/close_copy per Bloccarlo.\r\nNel caso in cui tu non sia ancora Abilitato al Servizio TradeSignals, inserisci /chatid e comunica il codice all'Admin @andreazaff che provvederà subito all'autenticazione!";
	}
		else if ($text == "/chatid")
		{
			$response = "Il Tuo Codice Chat è: ".$chatId;
		}
			else if ($text == "/launch_copy")
			{
				set_config (1, $chatId);
			$response = "L'operazione è andata a Buon Fine!\r\nHai Autorizzato TradeSignals ad aprire investimenti in automatico per tuo conto!";
			}
				else if ($text == "/close_copy")
				{
					set_config (0, $chatId);
				$response = "L'operazione è andata a Buon Fine!\r\nHai Revocato TradeSignals ad aprire investimenti in automatico per tuo conto!";
				}
					else if (($text == "/ts_off") 
								&& 
								(
									($chatId == "121096168") || ($chatId == "106805958")
								)
							)
					{
						set_start (0);
						$response = "Gentile Admin, hai Spento l'Algoritmo di TradeSignals";
					}
						else if (($text == "/ts_on") 
									&&
									(
										($chatId == "121096168") || ($chatId == "106805958")
									)
							)						
						{
							set_start (1);
							$response = "Gentile Admin, hai Acceso l'Algoritmo di TradeSignals";
						}
							else if (($text == "/paid_off") && ($chatId == "121096168"))
							{
								set_paid (0);
								$response = "Gentile Andrea, hai Chiuso il Copy per gli Abbonati";
							}
								else if (($text == "/paid_on") && ($chatId == "121096168"))
								{
									set_paid (1);
									$response = "Gentile Andrea, hai Attivato il Copy per gli Abbonati";
								}
									else
									{
										$response = "Comando Non Abilitato!\r\nContattare il Gestore del Servizio";
									}

header("Content-Type: application/json");
$parameters = array('chat_id' => $chatId, "text" => $response);
$parameters["method"] = "sendMessage";
echo json_encode($parameters);
