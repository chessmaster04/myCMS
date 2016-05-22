<?
/*
Реестр
Registry::set("key","value"); //true/false
Registry::get("key"); //value/null
Registry::remove("key"); //true/false
Registry::has("key"); //true/false
*/
class Registry{
	protected static $data = array();
	
	public static function set($key,$value){
		$key = strip_tags(trim($key));
		$value = strip_tags(trim($value));
		if($key!=""&&$value!=""){
			self::$data[$key]=$value;
			return true;
		} else {
			return false;
		}
	}
	public static function get($key){
		if(!array_key_exists($key,self::$data))
			throw new SettingNotFoundException("Ошибка! Отсутствует необходимая настройка: ".$key);
		$key = strip_tags(trim($key));
		if($key!="")
			return isset(self::$data[$key])?self::$data[$key]:null;
		else 
			return null;
	}
	final public static function remove($key){
		$key = strip_tags(trim($key));
		if($key!=""){
			if(array_key_exists($key,self::$data)){
				unset(self::$data[$key]);
				return true;
			}
		} else {
			return false;
		}
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