<?
class Router{
	
	const E404CONTRILLER = "Error404Controller";//изменять не нужно
	private $controller;
	
	function __construct(){
		if(class_exists("URLManager")){
			$URLM = new URLManager($_SERVER['REQUEST_URI']);
		}else{
			throw new ClassNotFoundException("Ошибка! Отсутствует необходимая модель 'URLManager'!");
		}
		$page = $URLM->getFirst();
		//ОПРЕДИЛЯЕМ СТРАНИЦУ
		$page = empty($page)?Registry::get("defaultPage"):$page;
		//Делаем первый символ заглавным, что бы соответствовать имени контроллера
		$requestedController = ucfirst($page)."Controller";
		//Определяем контроллер
		if(class_exists("FileManager")){
			$fm = new FileManager();
		}else{
			throw new ClassNotFoundException("Ошибка! Отсутствует необходимая модель 'FileManager'!");
		}
		if($fm->issetFile($requestedController.FileTypes::TYPE_CLASS)){
			$this->controller = $requestedController;
		} elseif($fm->issetFile(self::E404CONTRILLER.FileTypes::TYPE_CLASS)) {
			$this->controller = self::E404CONTRILLER;
			$page = Registry::get("fileNameError404");
		} else {
			throw new ClassNotFoundException("Ошибка! Отсутствует контроллер ".self::E404CONTRILLER."!");
		}
		//Загружаем части адресной строки в реестр для адресной строки
		URLRegistry::add($page);
		$parts = $URLM->getParts();
		for($i=1;$i<count($parts);$i++){
			URLRegistry::add($parts[$i]);
		}
	}
	function getController(){
		return $this->controller;
	}
}
?>