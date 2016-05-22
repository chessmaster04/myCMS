<?
/*
	ИНСТРУКЦИЯ
	$dataEditor = new CheckData($str); //создание
	echo $dataEditor; //вывод $str вариант 1
	echo $dataEditor->getData(); //вывод $str вариант 2
	$dataEditor->clearData(); //очистка от тегов и пробелов, вернёт true, если их обнаружил
	$dataEditor->clearData("exception"); //бросит Exception в случае обнаружения
	
	$dataEditor->checkAsLogin([$method[,$pattern[,$errorMessage]]]);
		//код исключения 1
	$dataEditor->checkAsPass([$method[,$pattern[,$errorMessage]]]);
		//код исключения 2
	$dataEditor->checkAsTel([$method[,$pattern[,$errorMessage]]]);
		//код исключения 3
	$dataEditor->checkAsEmail([$method[,$pattern[,$errorMessage]]]);
		//код исключения 4
	$dataEditor->checkAsDomen([$method[,$pattern[,$errorMessage]]]);
		//код исключения 5
	$dataEditor->checkAsIP([$method[,$pattern[,$errorMessage]]]);
		//код исключения 6
	$dataEditor->checkAsTime([$method[,$pattern[,$errorMessage]]]);
		//код исключения 7
	$dataEditor->checkAs([$method[,$pattern[,$errorMessage]]]);
		//код исключения 0
	
	$dataEditor->clearArray();//очистка массивов
*/
class CheckData{
	private $_data;
	public function __construct($data=""){
		$this->_data = $data;
	}
	//возврат данных
	public function getData(){
		return  $this->_data;
	}
	public function __toString(){
		if(!is_string($this->_data))return print_r($this->_data,1);
		return  $this->_data;
	}
	//очистка данных
	public function clearData($method="return"){
		/*
			метод return вернёт результат отличия
			метод exception бросит в случае отличия Exception
		*/
		if(!empty($this->_data)){
			$this->_data = trim($this->_data);
			$tmp_data = $this->_data;
			$this->_data = strip_tags($this->_data);
			//если очищеные данные не соответсвуют первоначальным данным, тогда false, что говорит о том, что были введены теги
			switch($method){
				case "return":
					return $tmp_data==$this->_data;
					break;
				case "exception":
					if($tmp_data!=$this->_data){throw new Exception("были введены теги");}
					break;
			}
		}else{
			return undefined;
		}
	}
	//очистка массива
	public function clearArray(){
		$arr = $this->getData();
		if(is_array($arr)){
			$newArr = array();
			foreach($arr as $k=>$v){
				$class = __CLASS__;
				$tmpDataEditor = new $class($v);
				if(is_array($tmpDataEditor->getData())){
					$newArr[$k]=$tmpDataEditor->clearArray();
				}else{
					$tmpDataEditor->clearData();
					$newArr[$k]=$tmpDataEditor->getData();
				}
			}
			$arr = $newArr;
			return $newArr;
		}else{
			return undefined;
		}
	}
	//Проверка, являются ли данные логином
	public function checkAsLogin($method="return",$pattern = "/^[а-яА-ЯёЁa-zA-Z][а-яА-ЯёЁa-zA-Z0-9_ -]{2,28}[а-яА-ЯёЁa-zA-Z0-9]$/ui",$errorMessage="Логин введён не по шаблону"){
		return $this->checkDataForm($method,$pattern,$errorMessage,"1");
	}
	//Проверка, являются ли данные паролем
	public function checkAsPass($method="return",$pattern = "/.{6,20}/",$errorMessage="Пароль введён не по шаблону"){
		return $this->checkDataForm($method,$pattern,$errorMessage,"2");
	}
	//Проверка, являются ли данные телефоном
	public function checkAsTel($method="return",$pattern = "/^((8|\+7|\+38)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/i",$errorMessage="Телефон введён не по шаблону"){
		return $this->checkDataForm($method,$pattern,$errorMessage,"3");
	}
	//Проверка, являются ли данные Emailом
	public function checkAsEmail($method="return",$pattern = "/[0-9a-z_]+@[0-9a-z_]+\.[a-z]{2,5}/i",$errorMessage="Email введён не по шаблону"){
		return $this->checkDataForm($method,$pattern,$errorMessage,"4");
	}
	//Проверка, являются ли данные доменным именем
	public function checkAsDomen($method="return",$pattern = "/^([a-zA-Z0-9]([a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$/i",$errorMessage="Домен введён не по шаблону"){
		return $this->checkDataForm($method,$pattern,$errorMessage,"5");
	}
	//Проверка, являются ли данные ip
	public function checkAsIP($method="return",$pattern = "/^(25[0-5]|2[0-4][0-9]|[0-1][0-9]{2}|[0-9]{2}|[0-9])(\.(25[0-5]|2[0-4][0-9]|[0-1][0-9]{2}|[0-9]{2}|[0-9])){3}$/",$errorMessage="IP введён не по шаблону"){
		return $this->checkDataForm($method,$pattern,$errorMessage,"6");
	}
	//Проверка, являются ли данные временной меткой
	public function checkAsTime($method="return",$pattern = "/^\d{0,10}$/",$errorMessage="Временная метка введена не по шаблону"){
		return $this->checkDataForm($method,$pattern,$errorMessage,"7");
	}
	//Проверка любых данных по шаблону
	public function checkAs($method="return",$pattern = "",$errorMessage=""){
		return $this->checkDataForm($method,$pattern,$errorMessage,"0");
	}
	//общая функция для проверки по шадлону данных форм
	private function checkDataForm($method="",$pattern="",$errorMessage="",$code="0"){
		/*
			метод return вернёт результат отличия
			метод exception бросит в случае отличия Exception
		*/
		if(!empty($this->_data)&&!empty($method)&&!empty($pattern)){
			$subject = $this->_data;
			$res = preg_match($pattern,$subject);
			switch($method){
				case "return":
					return $res;
					break;
				case "exception":
					if(!$res)throw new Exception($errorMessage,$code);
					else return $res;
					break;
			}
		}else {
			return undefined;
		}
	}
}
?>