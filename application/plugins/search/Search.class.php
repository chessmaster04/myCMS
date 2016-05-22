<?
/*
Класс для поиска по данным
//данные
$data = array(array("title"=>"dom","text"=>"dot"),array("title"=>"kot","text"=>"mot"));
$searchText = "kot dom";
$keys = array("title");
//создание и инициализация
$search = new Search($data,$searchText,$keys);
//или так
$search = new Search();
$search->setArrayData($data);
$search->setFields($keys);
$search->setKeyString(searchText);
//простая фильрация
$filteredData = $search->getFilteredArray();
//фильтрация с приоритетной расстановкой по полям
$filteredPriority = $search->getPrioritySortedArray();
//достаём диапазон от 0 до 0+2
$limitedData = $search->getLimitedObject($filteredPriority,0,2);
//если передать null то метод возьмёт изначальный массив, который был передан в Search()
$limitedData = $search->getLimitedObject(null,0,2);
//перебираем limitedData, так как он объект
foreach($limitedData as $obj){
	print_r($obj);
}
//фильтруем по options(настройкам)
$filteredByOptions = $search->getArrayFilteredByOptions( $filteredPriority,array("title"=>"dom") );
//если передать null то метод возьмёт изначальный массив, который был передан в Search()
$filteredByOptions = $search->getArrayFilteredByOptions( null,array("title"=>"dom") );

*/
class Search{
	private $_keyWords;//ключивое слово (строка поиска), которые надо найти
	private $_fields;//поля, по которым ищится ключивое слово в массиве данных
	private $_arrayData;
	
	function __construct($arrayData=null,$keyString=null,$fields=null){
		$this->setArrayData($arrayData);
		$this->setFields($fields);
		$this->setKeyString($keyString);
	}
	//ГЕНЕРИРУЕМ КЛЮЧЕВЫЕ СЛОВА
	private function generateKeyWords($keyString){
		//получаем введённые ключевые слова
		$keyWords = explode(' ', mb_strtolower(trim($keyString), 'UTF-8'));
		$count = count($keyWords);
		//чистим ключевые слова от не нужных символов
		array_walk($keyWords,"trimKeyWords");
		//удаляем пустые ключевые слова
		for($i=0;$i<$count;$i++){
			if(empty($keyWords[$i])){//защита от пустых значений, которые дают несколько пробелов подряд
				array_splice($keyWords,$i,1);
				$i--;
				$count--;
			}
		}
		//удаляем ничего не значущие ключи
		$arrFalseKeyWords = array("с","в","у","на","при","для","за","ни","и","но","не","то","о","же","курс","видеокурсы","курсы","видеокурс","видеоурок","видеоуроки","урок","уроки","по","созданию","создание","работа","работе");
		for($i=0;$i<$count;$i++){
			for($j=0;$j<count($arrFalseKeyWords);$j++)
				if($keyWords[$i]==$arrFalseKeyWords[$j]){
					array_splice($keyWords,$i,1);
					$i--;
					$count--;
					break;
				}
		}
		//Вставляем первым ключем полный запрос
		array_unshift($keyWords,$keyString);
		$count++;
		//создаём всевозможные ключевые слова, основываясь на регистре
		for($i=0;$i<$count;$i++){
			//создаём ключевое слово, только в верзнем регистре
			array_push($keyWords,mb_strtoupper($keyWords[$i], 'UTF-8'));
			//создаём ключевое слово, только с заглавной буквой
			array_push($keyWords,ucfirst ($keyWords[$i]));
		}
		//записывае клучевые слова в переменную
		$this->_keyWords = $keyWords;
	}
	//возвращаем отфильтрованные данные по полям
	function getFilteredArray(){
		$data = new ArrayIterator($this->_arrayData);
		$filter = new Filter($data,$this->_keyWords,$this->_fields);
		return iterator_to_array($filter);
	}
	//возвращаем указанный диопазон указанных данных 
	function getLimitedObject($array,$start,$count){
		if($array==null)$array=$this->_arrayData;
		$array = new ArrayIterator($array);
		return new LimitIterator($array,$start,$count);
	}
	//возвращаем отсортированный массив по приоритетам, в качестве приоритетов выступает очерёдность полей
	function getPrioritySortedArray($array=null,$priorityFields=null){
		if($array==null)$array=$this->_arrayData;
		if($priorityFields==null)$priorityFields=$this->_fields;
		return PrioritySort::getSortedArray($array,$priorityFields,$this->_keyWords);
	}
	//фильтруем по данные по options, который содержит массив с ключами и значениями
	function getArrayFilteredByOptions($array,$options=array()){
		if($array==null)$array=$this->_arrayData;
		$tmpArr = array();
		foreach($array as $note){
			foreach($options as $k=>$v){
				if($note[$k]==$v){
					array_push($tmpArr,$note);
					break;
				}
			}
		}
		return $tmpArr;
	}
	//сеттеры
	public function setArrayData($arrayData){$this->_arrayData = $arrayData;}
	public function setFields($fields){$this->_fields = $fields;}
	public function setKeyString($keyString){$this->generateKeyWords($keyString);}
}
function trimKeyWords(&$val,$key){
	$val = trim(trim(trim(trim(trim($val,"."),","),"?"),"'"),"\"");
}
?>