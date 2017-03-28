<?php
//Привет
include 'libraries/functions.php';
class Parsing
{
	public function CurlQuery($site_url)
	{
		$curl = curl_init($site_url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($curl,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36');
		$request = curl_exec($curl);
		curl_close( $curl );
		return $request;
	}
	public function ParseFirstTag($tagname,$site_url)
	{
		$document = phpQuery::newDocument($this->CurlQuery($site_url));
		return $document->find($tagname)->eq(0)->text();
	}
	public function ParseFirst($site_url)
	{
		$db = Database_Mysql::create('localhost', 'cw44342_botvk', '12345qwe')
			->setCharset('utf8')
			->setDatabaseName('cw44342_botvk');
		$document = phpQuery::newDocument($this->CurlQuery($site_url));
		$urls= $document->find("#mw-pages ul li a");
		$arrayofjson = array();
		foreach ($urls as $href)
		{
			//Запоминаем каждую ссылку из массива ссылок на странице
			$url = 'http://wikireality.ru'.pq($href)->attr('href');
			$singlejson = array();
			//Получаем страницу статьи
			$header = $this->ParseFirstTag('#firstHeading',$url);
			$description = $this->ParseFirstTag('#mw-content-text > p',$url);
			//Получаем страницу поиска изображения по запросу
			$search_url = "https://www.google.ru/search?q=".urlencode($header)."&source=lnms&tbm=isch";
			//Получаем ссылку на первое изображение
			$firstimage_url = $this->ParseFirstTag('div#rg_s > div.ivg-i>.rg_meta',$search_url);
			$img_src = mb_strimwidth($firstimage_url, strripos($firstimage_url,'"ou":')+6, strripos($firstimage_url,',"ow"')-strripos($firstimage_url,'"ou":')-7);
			
			//Создаем json одной страницы
			$singlejson['title'] = $header;
			$singlejson['description'] = $description;
			$singlejson['image_url'] = $img_src;
			$arrayofjson[] = $singlejson;
			echo "<img src='$img_src'><br>";
			echo $header;
			echo '<br>';
			echo $description;
			echo '<br><hr>';
		}
		$json = json_encode($arrayofjson);
		$fp = fopen('/home/c/cw44342/botvk/public_html/php/json_parse.txt', "w+"); // Открываем файл в режиме записи
		fwrite($fp, $json); // Запись в файл
		//file_put_contents('/home/c/cw44342/botvk/public_html/php/libraries/json_parse.txt',$json);
	}
}