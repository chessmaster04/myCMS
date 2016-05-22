<?
class FileRender extends FileManager {
	
	//читаем файл построчно и возвращаем массив со строками
	/*public function readFileByLineAndGetAsArray($path){
		if(!empty($path)&&file_exists($path)){
			$tmpArray = array();
			$f = new SplFileObject($path);
			foreach($f as $line){
				array_push($tmpArray,$line);
			}
			return $tmpArray;
		}
		return null;
	}*/
	
	//передаём массив со строками, в которых записаны названия файлов, с помощью функции readFileByLineAndGetAsArray и обрамляем их в теги <script> и <link> для подключения на сайт
	public function getwrappedCSSOrJSInTegs($arrayData){
		if(is_array($arrayData)){
			$result = "";
			foreach($arrayData as $file){
				if(strrpos($file,"http")===0){
					$path = $file;
				} else {
					$file = strip_tags(trim($file));
					$path = self::getPathOfFile($file);
					if(file_exists($path)==false)continue;
					$path = "/".$path;
				}
				if(!empty($path)){
					$type = self::getTypeOfFile($path);
					switch($type){
						CASE FileTypes::TYPE_CSS:
							$result .= "<link rel='stylesheet' href='$path'>";
							break;
						CASE FileTypes::TYPE_JS:
							$result .= "<script src='$path'></script>";
							break;
					}
				}
			}
			return $result;
		}
		return null;
	}
	
	//функция для загрузки страницы в текстовую переменную, с помощью которой можно будет сгенерировать страницу
	public function render($file,$data=array()) {
		if(is_array($data))//проверка на массив
			extract($data);
		if(isset($controllerName)){//если было передано имя контроллера то создаём переменную с именем thisController, с помощью которой устаноавливается связь контроллера и view
			$rc = new ReflectionClass($controllerName);
			$thisController = $rc->newInstance();
		}
		/* $file - текущее представление */
		//проверка
		if(empty($file)||!file_exists($file))
			throw new FileNotFoundException("Ошибка! Запрашиваемого файла $file не найдено!");
		//загрузка файла
		ob_start();
		include($file);
		return ob_get_clean();
	}
	
	public function createController($nameOfFile){
		$nameOfController = ucfirst($nameOfFile)."Controller";
		$data = <<<DATA
<?
class $nameOfController extends PageController{
	
	function __construct(){
		//ЭТО НЕ ИЗМЕНЯТЬ 
		parent::__construct();//надо для предопределения например файлов CSS и JS		
		\$this->pageData["controllerName"] = __CLASS__;//надо для предоставления возможности обращения к данному контроллеру со страницы
	}
	
	//этот метод можно переопределять
	/*protected function renderHeaders(){
		
	}*/
	
	//этот метод можно переопределять
	/*protected function renderBody(){
		
	}*/
	
	/*
	 * Теставая функция, которую можно удалить
	 */
	function getTest(){
		return "связь view и ".__CLASS__." налажена";
	}
}
?>
DATA;
		file_put_contents(Registry::get("dirControllers")."$nameOfController.class.php",$data);
	}
	
	public function createFileOfPage($nameOfFile,$dir){
		$data = <<<DATA
Hello!
<?
echo \$thisController->getTest();
?>
DATA;
		file_put_contents(Registry::get("dirViews").$dir."$nameOfFile.php",$data);
	}
}
?>