<?
/*
//ИНСТРУКЦИЯ
	1 Создание нового json-файла
$jsonParser = new JSONParser("dir/test.json"); - обязательно надо указывать дирректорию и имя файла
$jsonParser->save($arr); - создаём json файл

	1 Чтение или перезапись json-файла
$jsonParser = new JSONParser("test.json"); - директорию указывать не надо
$arr = $jsonParser->getArray(); - получаем массив с данными, которые можно изменять
$arr["c"]["e"] = 23; - вот так изменяем данные массива
$jsonParser->property; - обращаемся к любой переменно массива
$jsonParser->save($arr); - записываем их обратно
*/
class JSONParser extends FileManager {
	
	public $jsonAsArray  = null;
	private $path = null;
	
	public function __construct($fileOrPath){
		if(self::getTypeOfFile($fileOrPath)==FileTypes::TYPE_JSON){
			$this->path = $fileOrPath;
			if(self::issetFile($fileOrPath)){
				$path = self::getPathOfFile($fileOrPath);
				$this->path = $path;
				$this->jsonAsArray = json_decode(file_get_contents($path),true,512);
			}
		}
	}
	
	public function save($array){
		if($this->path!=null&&is_array($array)){
			file_put_contents($this->path,json_encode($array));
			return true;
		} else {
			return false;
		}
	}
	
	public function getArray(){
		if($this->jsonAsArray!=null)
			return $this->jsonAsArray;
		else 
			return null;
	}
	
	public function __get($property){
		if($this->jsonAsArray!=null){
			if(isset($this->jsonAsArray[$property])){
				$tmp = $this->jsonAsArray[$property];
				return $tmp;
			}
			return false;
		}
		return null;
	}
}
?>