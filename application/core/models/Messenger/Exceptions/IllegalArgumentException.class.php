<?
/**
 * Исключение оповещающее об ошибке связанной с не валидным аргументов
 * 
 * @author Трубин Борис Игоревич <mgbit3214@gmail.com>
 * @version 1.0
 */
class IllegalArgumentException extends AbstractException{
	
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