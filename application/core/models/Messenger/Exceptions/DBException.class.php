<?
/**
 * Исключение оповещающее об ошибке связанным с базой данных
 * 
 * @author Трубин Борис Игоревич <mgbit3214@gmail.com>
 * @version 1.0
 */
class DBException extends AbstractException{
	
	/**
	 * конструктор класса
	 * 
	 * @param String $msg
	 */
	function __construct($msg){
		parent::__construct($msg,__CLASS__);
	}
}
?>