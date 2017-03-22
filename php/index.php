<?php
include 'libraries/functions.php';


$user_token = '885ccfaf7b19360f038350e419a0e488d208a45ad07be217e99b56b5ce69587b91d2791c86dcb2b8434a1';
//Создаем объекты для работы с апи
$apiuser = new UserMethods($user_token);
$apiuser->saveImg('http://minionomaniya.ru/wp-content/uploads/2016/01/%D0%BC%D0%B8%D0%BD%D1%8C%D0%BE%D0%BD%D1%8B-%D0%BF%D1%80%D0%B8%D0%BA%D0%BE%D0%BB%D1%8B-%D0%BA%D0%B0%D1%80%D1%82%D0%B8%D0%BD%D0%BA%D0%B8.jpg','@/home/c/cw44342/botvk/public_html/images/');
$parsing =new Parsing('');
//$str = phpQuery::newDocument($parsing->CurlQuery('https://www.google.ru/search?q=%D0%A4%D0%B8%D0%BC%D0%BE%D0%B7+%D0%B3%D0%BE%D0%BB%D0%BE%D0%B2%D0%BD%D0%BE%D0%B3%D0%BE+%D0%BC%D0%BE%D0%B7%D0%B3%D0%B0&source=lnms&tbm=isch'))->find('div#rg_s > div.ivg-i>.rg_meta')->eq(0);
$db = Database_Mysql::create('localhost', 'cw44342_botvk', '12345qwe')
    ->setCharset('utf8')
    ->setDatabaseName('cw44342_botvk');
//$db->query('');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Пример веб-страницы</title>
  <script type="text/javascript" src="//vk.com/js/api/openapi.js?142"></script>

<!-- VK Widget -->
<div id="vk_community_messages"></div>
<script type="text/javascript">
VK.Widgets.CommunityMessages("vk_community_messages", 142367703, {expanded: "1",tooltipButtonText: "Есть вопрос?"});
</script>
 </head>
 <body>
  <a  href="https://oauth.vk.com/authorize?client_id=<?=$client_id;?>&display=page&redirect_uri=https://oauth.vk.com/blank.html&scope=<?=$scope;?>&response_type=token&v=5.37">Push the button</a>
  <a target="_blank" href="test.php">ЖМИИИ</a>
  <iframe src='https://webchat.botframework.com/embed/vkbot?s=YOUR_SECRET_HERE'></iframe>
 </body>
</html>