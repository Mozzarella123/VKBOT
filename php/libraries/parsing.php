<?php
//Привет
include 'simple_html_dom.php';
include 'phpQuery-onefile.php';
class Parsing
{
	private $site_url;
	private $html;
	public function __construct($site_url)
	{
		$this->site_url = $site_url;
		$this->html = file_get_html($site_url);
	}
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
	public function ParseFirstTag($tagname)
	{
		$single = $this->html->find($tagname, 0);
		$res = $single->plaintext;
		$this->html->clear();
		unset($this->html);
		return $res;
	}
	public function ParseFirst($site_url)
	{
		$document = phpQuery::newDocument($this->CurlQuery($site_url));
		$urls= $document->find("#mw-pages ul li a");
		foreach ($urls as $href)
		{
			$url = pq($href)->attr('href');
			$single = phpQuery::newDocument($this->CurlQuery('http://wikireality.ru'.$url));
			$header = $single->find('#firstHeading')->text();
			$description = $single->find('#mw-content-text > p')->eq(0)->text();
			$img_url = "https://www.google.ru/search?q=".urlencode($header)."&source=lnms&tbm=isch";
			$abs_url = phpQuery::newDocument($this->CurlQuery($img_url))->find('div#rg_s > div.ivg-i>.rg_meta')->eq(0);
			$img_src = mb_strimwidth($abs_url, strripos($abs_url,'"ou":')+6, strripos($abs_url,',"ow"')-strripos($abs_url,'"ou":')-7);
			echo "<img src='$img_src'><br>";
			echo $img_url.'<br>';
			echo $header;
			echo '<br>';
			echo $description;
			echo '<br><hr>';
		}
	}
}