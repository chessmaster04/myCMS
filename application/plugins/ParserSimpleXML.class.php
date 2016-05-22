<?
/*
ИНСТРУКЦИЯ
$modelP = ParserSimpleXML::getInstance();
$data = array(
	"title"=>"werhwerh",
	"text"=>"wrwegh",
	"keys"=>
		array(
			array(
				"1",
				"2"
			),
			"2"
		)
	);
$resultBool = $modelP->setData("test.xml",$data);//Записываем данные в файл
$resultObj = $modelP->getDataObj("test.xml");//получаем данные в виде объекта
$resultArray = $modelP->getDataArray("test.xml");//получаем данные в виде массива

$resultObj = $modelP->getSpecificDataObj("test.xml",array("title"));//вернёт данные в виде объекта изходя из выборки
$resultArray = $modelP->getSpecificDataArray("test.xml",array("title"));//вернёт данные в виде массива изходя из выборки
*/
class ParserSimpleXML{
	const DATADIR = "xmlDB";
	
	private static $_instance;
	private $_db;
	
	private function __construct(){
		//создание дирректории
		if(!is_dir(self::DATADIR)){
			mkdir(self::DATADIR);
		}
	}
	private function __clone(){
		
	}
	public static function getInstance(){
		if (null === self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	//записывает данные в файл
	public function setData($fileNameXML,$arrData){
		ob_start();
		echo "<?xml version='1.0' encoding='utf-8' ?>\n";
		echo "<catalog>\n";
		echo self::arrayToTags($arrData);
		echo "</catalog>\n";
		file_put_contents(self::DATADIR."/".$fileNameXML,ob_get_clean());
		return true;
	}
	//вернёт данные в виде массива
	public function getDataArray($fileNameXML,$obj=null){
		$obj = $obj==null?self::getDataObj($fileNameXML):$obj;
		$tmpArr = array();
		$i=0;
		foreach($obj as $key=>$val){
			if($key=="block")
				$key = $i++;
			$tmpArr[$key] = count($val)==0?(string)$val:self::getDataArray($fileNameXML,$val);
		}
		return $tmpArr;
	}
	//вернёт данные в виде объекта
	public function getDataObj($fileNameXML){
		$sxml = simplexml_load_file(self::DATADIR."/".$fileNameXML);
		return $sxml;
	}
	//вернёт данные в виде объекта изходя из выборки
	public function getSpecificDataObj($fileNameXML,$arrColums=array(),$arrCondition=array()){
		array_push($arrColums,"block");
		$allData = self::getDataObj($fileNameXML);
		$tmpObj = new stdClass();
		$j=0;
		foreach($allData as $val){
			//осуществляем выборку по условию
			foreach($val as $k1=>$v1){
				foreach($arrCondition as $k2=>$v2){
					if($k1==$k2&&$v1!=$v2)
						continue 3;
				}
			}
			//осуществляем выборку по полю и заносим данные
			foreach($val as $k1=>$v1){
				for($i=0;$i<count($arrColums);$i++){
					if($arrColums[$i]==$k1){
						$tmpObj->$j->$k1 = $v1;
						
					}
				}
			}
			$j++;
		}
		return $tmpObj;
	}
	//вернёт данные в виде массива изходя из выборки
	public function getSpecificDataArray($fileNameXML,$arrColums=array(),$arrCondition=array()){
		return self::getDataArray(null,self::getSpecificDataObj($fileNameXML,$arrColums,$arrCondition));
	}
	/*********************************************/
	private function arrayToTags($arrData,$i=1){
		for($j=0;$j<$i;$j++)
			$tabs .= "\t";
		foreach($arrData as $key=>$val){
			if(is_numeric($key))
				$key = "block";
			if(is_array($val)){
				$data .= "$tabs<$key>\n".self::arrayToTags($val,++$i)."$tabs</$key>\n";
			}else
				$data .= "$tabs<$key>$val</$key>\n";
		}
		return $data;
	}
}
?>