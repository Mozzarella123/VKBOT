<?php
/**
 * Created by PhpStorm.
 * User: Nikita
 * Date: 19.03.2017
 * Time: 12:16
 */
switch ($message)
{
    case 'рандом слово':
        $parser = new Parsing();
        $message = $parser->ParseFirstTag('strong.out-text-1','http://genword.ru/generators/word/');
        $send_params["message"] = $message;
        $apigroup->APIMethod('messages.send',$send_params);
        break;
    case 'рандом фраза':
        $parser = new Parsing();
        $message = $parser->ParseFirstTag('strong.out-text-1','http://genword.ru/generators/winged/');
        $send_params["message"] = $message;
        $apigroup->APIMethod('messages.send',$send_params);
        break;
    case 'рандом анекдот':
        $parser = new Parsing();
        $message = $parser->ParseFirstTag('div.topicbox div.text','https://www.anekdot.ru/random/anekdot/');
        $send_params["message"] = $message;
        $apigroup->APIMethod('messages.send',$send_params);
        break;
    case 'привет': $message = 'не пиши мне больше';
        $send_params["message"] = $message;
        $apigroup->APIMethod('messages.send',$send_params);
        break;
    case 'help':
        $message = "
				Введи \"рандом слово\", чтобы я прислал случайное слово
				Введи \"рандом фраза\", чтобы я прислал случайную фразу
				Введи \"рандом андекдот\", без них никуда!!!
				";
        $send_params["message"] = $message;
        $apigroup->APIMethod('messages.send',$send_params);
        break;
    case '+1':
        $result = $db->query("SELECT attachments.photoid_vk FROM attachments,articles WHERE articles.attachment_id=attachments.attachment_id;");
        $description = $db->query("SELECT description FROM articles WHERE article_id=1");
        $message = $description->getOne();
        $send_params["message"] = $message;
        $send_params["attachment"] = $result->getOne();
        $apigroup->APIMethod('messages.send',$send_params);
        break;

    default :
        $message = 'какого чёрта ты мне пишешь?';
        $send_params["message"] = $message;
        $apigroup->APIMethod('messages.send',$send_params);
}