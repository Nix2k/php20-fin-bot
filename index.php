<?php
	function getTemp()
	{
		$appid='499d5cded32e442061029f50618471ac';
		$city=$_GET["Yaroslavl"];
		$reqStr="http://api.openweathermap.org/data/2.5/weather?q=$city&appid=$appid&lang=ru";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $reqStr);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$jsonData=curl_exec($ch);
		curl_close($ch);
		$data=json_decode($jsonData);
		$temp=round($data->main->temp-273.15,1);
		$pressure=round($data->main->pressure*0.75006375541921);
		$humidity=$data->main->humidity;
		$weather=$data->weather[0]->description;
		$wIco=$data->weather[0]->icon;
		return("Температура воздуха: $temp<br>
				Атмосферное давление: $pressure<br>
				Влажность воздуха: $humidity
				Погодные условия: <img src='http://openweathermap.org/img/w/".$wIco.".png'> <i><?= $weather?></i>");
	}   

	include('vendor/autoload.php'); //Подключаем библиотеку
	use Telegram\Bot\Api; 

	$telegram = new Api('484376552:AAFFtd6Ch8QP_WRZS8xumHmkYxtg2EeZcVE'); //Устанавливаем токен, полученный у BotFather
	$result = $telegram -> getWebhookUpdates(); //Передаем в переменную $result полную информацию о сообщении пользователя
	
	$text = $result["message"]["text"]; //Текст сообщения
	$chat_id = $result["message"]["chat"]["id"]; //Уникальный идентификатор пользователя
	$name = $result["message"]["from"]["username"]; //Юзернейм пользователя
	$keyboard = [["Погода"]]; //Клавиатура

	if($text){
		switch ($text) {
			case '/start':
				$reply = "Добро пожаловать!";
				break;
			case 'Погода':
				$reply = getTemp();
				break;
			default:
				$reply = "Неизвестная команда";
				break;
		}
		$reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'parse_mode' => 'HTML', 'resize_keyboard' => true, 'one_time_keyboard' => false ]);
		$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
	}else{
		$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => "Отправьте текстовое сообщение." ]);
	}
?>