<?
/*
Реестр URL-адреса, содержит части url-строки до запрса get
URLRegistry::add("value"); //true/false
URLRegistry::get("key"); //value/null
URLRegistry::getFirst(); //value/null
URLRegistry::getLast(); //value/null
URLRegistry::has("key"); //true/false
*/
class URLRegistry{
	protected static $data = array();
	
	public static function add($value){
		$value = strip_tags(trim($value));
		if($value!=""){
			array_push(self::$data,$value);
			return true;
		} else {
			return false;
		}
	}
	public static function get($key){
		if(array_key_exists($key,self::$data)){
			$key = strip_tags(trim($key));
			if($key!="")
				return isset(self::$data[$key])?self::$data[$key]:null;
		}
		return null;
	}
	public static function getFirst(){
		if(array_key_exists(0,self::$data)){
			return isset(self::$data[0])?self::$data[0]:null;
		}
		return null;
	}
	public static function getLast(){
		if(array_key_exists(count(self::$data)-1,self::$data)){
			return isset(self::$data[count(self::$data)-1])?self::$data[count(self::$data)-1]:null;
		}
		return null;
	}
	public static function has($key){
		$key = strip_tags(trim($key));
		if($key!=""){
			return isset(self::$data[$key])?true:false;
		} else {
			return false;
		}
	}
}
?>