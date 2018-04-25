<?php
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
                $reply = "Добро пожаловать в бота!";
                break;
            case 'Погода':
                $reply = "Прогноз погоды";
                break;
            default:
                $reply = "Неизвестная команда";
                break;
        }
        $reply_markup = $telegram->replyKeyboardMarkup([ 'keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false ]);
        $telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => $reply, 'reply_markup' => $reply_markup ]);
    }else{
    	$telegram->sendMessage([ 'chat_id' => $chat_id, 'text' => "Отправьте текстовое сообщение." ]);
    }
?>