<?
class HomeController extends PageController{
	
	function __construct(){
		//ЭТО НЕ ИЗМЕНЯТЬ 
		parent::__construct();//надо для предопределения например файлов CSS и JS		
		$this->pageData["controllerName"] = __CLASS__;//надо для предоставления возможности обращения к данному контроллеру со страницы
	}
	
	/*
	 * Теставая функция, которую можно удалить
	 */
	function getTest(){
		return "связь view и ".__CLASS__." налажена";
	}
}
?>