<?
/*

*/
class URLManager {
	private $url;
	private $parts = array();
	function __construct($url){
		$this->url = strip_tags(trim($url));
		//������� �� ����� ����� �������
		$tmp = strpos($this->url,"?")?strstr($this->url,"?",true):$this->url;
		//������� �� ����� �����
		$tmp = strpos($tmp,".")?strstr($tmp,".",true):$tmp;
		//��������� �� �����
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