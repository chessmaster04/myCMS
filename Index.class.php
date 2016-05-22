<?
class Index {
	
	//ПЕРЕМЕННЫЕ И КОНСТАНТЫ
	private $_arrayDirs = array();
	private $_extensionsOfClasses = array(
		".class.php",
		".trait.php",
		".interface.php",
		".abstract.php"
	);
	const ROOTDIR = ""; //не менять
	const SETTINGSPATH = "application/settings.ini";
	const DEFAULTFILEWITHERRORS = "errors.log";
	
	
	
	public function __construct () {
		//Инициируем автозагрузку классов не зависимо от директории
		self::initAllDirs("."); //заносим все директории в массив
		spl_autoload_register(array($this,'loadClass')); //делаем loadClass загружаемым тогда, когда требуется подключить класс
		
	}
	
	//Эта функция запускается
	public function start () {
		try{
			self::initRegistry(); //заносим настройки в реестр
			self::main(); //запускаем сайт
		} catch (Exception $e) {
			file_put_contents($this->fileWithErrors,"Было поймано исключение в функцие exceptionHandling"."\n\n",FILE_APPEND);
			echo "Сайт не может запустится из-за серьёзных ошибок, мы уже работаем над этим!";
		}
	}
	
	//Эта функция грузит сайт
	public function main () {
		try{
			/*проверки*/
			if(!class_exists("FrontController"))
				throw new ClassNotFoundException("Отсутствует главный контроллер FrontController.");

			FrontController::getInstance()
				->route()
				->getBody(); //Вывод данных
			
			/*STARTTEST*/
			/*ENDTEST*/
			
		} catch (Exception $e){
			//обработка ошибки
			Messenger::getInstance()
				->sendInFileWithErrors($e)
				->sendEmail($e)
				->getTextOfErrorForUsers();
		}
	}
	
	//Эта функция подгружает нужный класс
	private function loadClass ($className) {
		$arrayDirs = $this->_arrayDirs;
		for($i=0;$i<count($arrayDirs);$i++){
			foreach($this->_extensionsOfClasses as $extensionFile){
				$file = self::ROOTDIR.$arrayDirs[$i].$className.$extensionFile;
				if(file_exists($file)){
					include_once($file);
					break 2;
				}
			}
		}
	}
	
	//Эта функция заносит все директории в массив
	private function initAllDirs ($dir) {
		$catalog = scandir($dir);
		foreach($catalog as $item){
			if($item=="."||$item=="..")continue;
			$item = $dir=="."?$item:$dir."/".$item;
			if(is_dir($item)){
				array_push($this->_arrayDirs,$item."/");
				self::initAllDirs($item);
			}
		}
	}
	
	//Эта функция заносит настройки в реестр
	private function initRegistry () {
		$_SETTINGS = parse_ini_file(self::SETTINGSPATH);
		foreach($_SETTINGS as $k=>$v){
			Registry::set($k,$v);
		}
	}	
}
//Запускаем класс
(new Index())->start();
?>