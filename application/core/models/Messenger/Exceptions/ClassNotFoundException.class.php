<?
/**
 * Исключение оповещающее о ненахождении класса
 * 
 * @author Трубин Борис Игоревич <mgbit3214@gmail.com>
 * @version 1.0
 */
class ClassNotFoundException extends AbstractException{
	
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