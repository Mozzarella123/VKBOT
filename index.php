<?php

$client_id = '5930931';
$scope = 'offline,message,groups,photos,wall';
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
