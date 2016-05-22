<?
/*
Вспомогательный класс Search
*/
class Filter extends FilterIterator{
	
	private $_keyWords;//ключивое слово (строка поиска), которые надо найти
	private $_fields;//поля, по которым ищится ключивое слово в массиве данных
	//КОНСТРУКТОР
	function __construct($array,$keyString=null,$fields=null){
		parent::__construct($array);
		$this->init($keyString,$fields);
	}
	//ОБЯЗАТЕЛЬНЫЙ МЕТОД ДЛЯ СТАВНЕНИЯ
	public function accept(){
		$keyWords = $this->_keyWords;
		$keys = $this->_fields;
		$array = parent::current();
		for($j=0;$j<count($keyWords);$j++){//перебираем все ключевые поля
			for($z=0;$z<count($keys);$z++){
				$key = false;
				//ищим сходство	
				if(strstr($array[$keys[$z]],$keyWords[$j]))
					return true;
			}
		}
		return false;
	}
	//ИНИЦИАЛИЗАЦИЯ
	private function init($keyString,$fields){
		$this->setKeyString($keyString);
		$this->setFields($fields);
	}
	
	public function setKeyString($keyString){
		$this->_keyWords = $keyString;
	}
	public function setFields($fields){
		if(!is_array($fields))throw new Exception("Поля, по которым надо свершать поиск не являются массивом");
		$this->_fields = $fields;
	}
	
	
	public function getAllKeyWordsArray(){
		return $this->_keyWords;
	}
}

?>