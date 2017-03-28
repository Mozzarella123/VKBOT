<?php
class vkAPI 
{
	private $access_token;

	public function __construct($access_token)
	{
		$this->access_token = $access_token;
	}
	/**
	 *
	 * @param $name string Имя метода
	 * @param $params array or string Передаваемые параметры
	 * @return string Ответ на запрос
	 */
	public function APIMethod($name,$params)
	{
		$query ="https://api.vk.com/method/$name?access_token=$this->access_token";
		//Если массив, то преобразуем
		if ( is_array($params))
		{
			$query .= '&'.http_build_query($params);
		}
		else
		{
			$query .= '&'.$params;
		}
		return file_get_contents($query);
	}
	public function POSTQuery($url,$post_params)
	{
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_SAFE_UPLOAD, false);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $post_params);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data; charset=UTF-8'));
		$out = json_decode(curl_exec($curl));
		curl_close( $curl );
		return $out;
	}

}
class UserMethods extends vkAPI
{
	public function saveImg($image_url,$image_path) {
		$upload_dir = $image_path;
		$name = 'image.jpg';
		$file = file_get_contents($image_url);
		$openedfile = fopen($upload_dir.$name, "w");
		fwrite($openedfile, $file);
		fclose($openedfile);
		return $upload_dir.$name;
	}
	public function UploadImageToAlbum($images_array,$album_id,$group_id,$caption="")
	{
		//Получаем url для загрузки
		$upload_url = json_decode($this->APIMethod('photos.getUploadServer',"album_id=$album_id&group_id=$group_id&v=5.62"))->response->upload_url;
		//Отправляем POST запрос
		$result = $this->POSTQuery($upload_url,$images_array);
		//Получаем параметры для сохранения
		$imgparams = array(
			"group_id" => "142367703",
			"server" => $result->server,
			"photos_list" => stripslashes($result->photos_list),
			"aid" => $result->aid,
			"hash" => $result->hash,
			"caption" => $caption
		);
		//Сохраняем на сервер
		$this->APIMethod('photos.save',$imgparams);
	}
}