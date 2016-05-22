<?
class Error404Controller extends PageController{
	
	function __construct(){
		parent::__construct();
		$this->pageData["controllerName"] = __CLASS__;
	}
	
	function renderHeaders(){
		if(!class_exists("HeadersManager"))
			throw new ClassNotFoundException("Ошибка!  Отсутствует класс HeadersManager ");
		(new HeadersManager)
			->charset()
			->notFound404();
	}
	
	/*
	 * Теставая функция, которую можно удалить
	 */
	function getTest(){
		return "связь view и ".__CLASS__." налажена";
	}
}
?>