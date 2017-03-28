<?php
/**
 * Created by PhpStorm.
 * User: Nikita
 * Date: 19.03.2017
 * Time: 12:16
 */
switch ($lastmessage)
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
    default :
        if (strrpos($lastmessage,"поясни за")!== false)
        {
            $search_phr = mb_strimwidth($lastmessage,strrpos($lastmessage,"поясни за")+10,strlen($lastmessage)-9);
            $search_phr = "%$search_phr%";
            $query = $db->query('SELECT article_id,description FROM articles WHERE description LIKE "?s" ',$search_phr);
            $row = $query->fetch_assoc();
            $article_id = $row["article_id"];
            $description = $row["description"];
            $query = $db->query("SELECT photoid_vk FROM attachments INNER JOIN attach_relations ON attach_relations.article_id = ?i WHERE attachments.attachment_id = attach_relations.attachment_id",$article_id);
            $attachment_id = $query->getOne();
            $send_params["message"] = $description;
            $send_params["attachment"] = $attachment_id;
            $apigroup->APIMethod('messages.send',$send_params);
        }
        else
        {
            $message = 'какого чёрта ты мне пишешь?';
            $send_params["message"] = $message;
            $apigroup->APIMethod('messages.send',$send_params);
        }
}