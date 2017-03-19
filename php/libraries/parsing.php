<?php
//Привет
include 'simple_html_dom.php';
class Parsing
{
	private $site_url;
	private $html;
	public function __construct($site_url)
	{
		$this->site_url = $site_url;
		$this->html = file_get_html($site_url);
	}
	public function ParseFirstTag($tagname)
	{
		$single = $this->html->find($tagname, 0); 
		$res = $single->plaintext;
		$this->html->clear();
		unset($this->html); 
		return $res;
	}
}
?>