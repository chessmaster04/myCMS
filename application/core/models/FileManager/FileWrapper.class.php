<?
/*

*/
class FileWrapper {
	
	private $_path = null;
	private $_arrayData = null;
	private $_content = null;
	
	public function set ($data) {
		if(is_object($data) && $data instanceof  $this){
			$this->_content = $data->wrap();
		}elseif(is_string($data)){
			if(!file_exists($data))
				throw new FileNotFoundException("$data файл не был найден");
			$this->_path = $data;
		}elseif(is_array($data)){
			$this->_arrayData = $data;
		}else{
			throw new IllegalArgumentException("path должно быть строкой, а пришло: $path");
		}
		return $this;
	}
	
	public function wrap () {
		//Проверки
		if(self::getPath() == null) return null;
		if(is_array(self::getData())){
			extract(self::getData());//Преобразование массива в переменные со значениями
		}
		if(isset($controllerName)){//если было передано имя контроллера то создаём переменную с именем thisController, с помощью которой устаноавливается связь контроллера и view
			$rc = new ReflectionClass($controllerName);
			$thisController = $rc->newInstance();
		}
		$content = self::getContent();
		ob_start();
		include(self::getPath());
		return ob_get_clean();
	}		
	
	
	private function getPath () {
		return $this->_path;
	}
	
	private function getData () {
		return $this->_arrayData;
	}
	
	private function getContent () {
		return $this->_content;
	}
}
?>