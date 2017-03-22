
<?php
include 'libraries/functions.php';

if (!isset($_REQUEST)) { 
  return; 
} 
//Строка для подтверждения адреса сервера из настроек Callback API 
$confirmation_token = 'ccd762e8'; 

//Ключ доступа сообщества 
$group_token = '0af2d08e1ae155f15fa5029db5c9aec1b8470a5aeecf803ad184ab8f1bd07159d047c212cd19b609cdb16'; 
$user_token = '885ccfaf7b19360f038350e419a0e488d208a45ad07be217e99b56b5ce69587b91d2791c86dcb2b8434a1';
//Получаем и декодируем уведомление 
$data = json_decode(file_get_contents('php://input')); 

//Создаем объекты для работы с апи
$apigroup = new vkAPI($group_token);
$apiuser = new UserMethods($user_token);

//Подключаемся к бд
$db = Database_Mysql::create('localhost', 'cw44342_botvk', '12345qwe')
    ->setCharset('utf8')
    ->setDatabaseName('cw44342_botvk');

//Проверяем, что находится в поле "type" 
switch ($data->type) { 
  //Если это уведомление для подтверждения адреса сервера...
  case 'confirmation':
    //...отправляем строку для подтверждения адреса 
    echo $confirmation_token; 
    break; 

//Если это уведомление о новом сообщении... 
  case 'message_new': 
    //...получаем id его автора 
    $user_id = $data->object->user_id; 
    //затем с помощью users.get получаем данные об авторе 
    $user_info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$user_id}&v=5.0")); 
//и извлекаем из ответа его имя 
    $user_name = $user_info->response[0]->first_name; 
    $message = mb_strtolower(json_decode($apigroup->APIMethod('messages.get','&count=1'))->response[1]->body);
	
	//работа с картинками
/*   	$img_src = "@".dirname(__FILE__)."/s.jpg";
	$post_params = array(
		"file1" => $img_src,
	); 
	$apigroup -> UploadImageToAlbum($post_params); */
	$send_params = array( 
		  'user_id' => $user_id, 
		  'v' => '5.0'
    );  
	$lastmessage = json_decode($apigroup->APIMethod('messages.get','count=1'))->response[1]->body;
	//Схемы ответов
		include 'answers.php';

//Возвращаем "ok" серверу Callback API 
    echo('ok');
break; 
}
mysqli_close($mysqli);