<?php
//Подключаем библиотеки
include 'libraries/functions.php';
/* $mysqli = new mysqli('localhost', 'cw44342_botvk', '12345qwe','cw44342_botvk');
$res = $mysqli->query("SELECT MAX(id) FROM vocabulary");
$row = $res->fetch_assoc(); */
//Да 
$client_id = '5930931';
$scope = 'offline,message,groups,photos,wall';
$token = '885ccfaf7b19360f038350e419a0e488d208a45ad07be217e99b56b5ce69587b91d2791c86dcb2b8434a1';
/* $token = 'b12ead4cb12ead4cb12cf0ccc1b174d2ffbb12eb12ead4ce9e2be7bba61211c34fd9993'; 
 */
$api = new UserMethods($token);
$request = json_decode($api->APIMethod('photos.getUploadServer','album_id=243751267&group_id=142367703&v=5.62'))->response->upload_url;
$img_src = "@".dirname(__FILE__)."/s.jpg";
$post_params = array(
	"file1" => $img_src,
);
/*$api->UploadImageToAlbum($post_params,243751267,142367703);*/
//$parsing =new Parsing('');
//$parsing->ParseFirst("http://wikireality.ru/w/index.php?title=%D0%9A%D0%B0%D1%82%D0%B5%D0%B3%D0%BE%D1%80%D0%B8%D1%8F:%D0%9C%D0%B5%D0%BC%D1%8B&pagefrom=%D0%A3%D0%BF%D0%BE%D1%80%D0%BE%D1%82%D1%8B%D0%B9#mw-pages");
