<?
/*

*/
class URLManager {
	private $url;
	private $parts = array();
	function __construct($url){
		$this->url = strip_tags(trim($url));
		//убираем всё после знака вопроса
		$tmp = strpos($this->url,"?")?strstr($this->url,"?",true):$this->url;
		//убираем всё после точки
		$tmp = strpos($tmp,".")?strstr($tmp,".",true):$tmp;
		//разбиваем на части
		foreach(explode("/",$tmp) as $part){
			if(!empty($part)){
				array_push($this->parts,$part);
			}
		}
		
	}
	function getParts(){
		return $this->parts;
	}
	function getFirst(){
		return $this->parts[0];
	}
	function getLast(){
		return $this->parts[count($this->parts)-1];
	}
}
?>