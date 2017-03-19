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
        $parser = new Parsing('http://genword.ru/generators/word/');
        $message = $parser->ParseFirstTag('strong.out-text-1');
        $send_params["message"] = $message;
        $apigroup->APIMethod('messages.send',$send_params);
        break;
    case 'рандом фраза':
        $parser = new Parsing('http://genword.ru/generators/winged/');
        $message = $parser->ParseFirstTag('strong.out-text-1');
        $send_params["message"] = $message;
        $apigroup->APIMethod('messages.send',$send_params);
        break;
    case 'рандом анекдот':
        $parser = new Parsing('https://www.anekdot.ru/random/anekdot/');
        $message = $parser->ParseFirstTag('div.topicbox div.text');
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
        $message = 'какого чёрта ты мне пишешь?';
        $send_params["message"] = $message;
        $apigroup->APIMethod('messages.send',$send_params);
}