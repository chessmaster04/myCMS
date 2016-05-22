<?
/*

*/
class FileActivities {
	
	const DATA = 1; //это данные, которые должны записатся в файл
	const DIR = 2;
	const NAME = 3;
	
	private $_data = null;
	private $_dir = null;
	private $_name = null;

	public function set ($key,$data) {
		if(!is_string($data)) throw new IllegalArgumentException("path должно быть строкой, а пришло: $data");
		switch ($key) {
			CASE self::DATA:
				$this->_data = $data;
				break;
			CASE self::DIR:
				$this->_dir = $data;
				break;
			CASE self::NAME:
				$this->_name = $data;
				break;
		}
		return $this;
	}
	
	//создание файла
	public function createFile () {
		$data = $this->_data;
		$dir = $this->_dir;
		$name = $this->_name;
		if($data!=null&&$dir!=null&&$name!=null){
			if(!FileManager::issetFile())/*ТУТ ОСТАНОВИЛСЯ*/
		}
		return false;
	}
	
}
?>