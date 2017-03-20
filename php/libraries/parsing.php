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
	public function ParseFirst()
	{
		$document = phpQuery::newDocument($this->CurlQuery($this->site_url));
		$urls= $document->find("#mw-pages ul li a");
		foreach ($urls as $href)
		{
			$url = pq($href)->attr('href');
			$single = phpQuery::newDocument($this->CurlQuery('http://wikireality.ru'.$url));
			echo $single->find('#firstHeading')->html();
			echo "<br>";
			echo $single->find('#mw-content-text > p')->eq(0)->text();
			echo "<br>";
		}
	}
}