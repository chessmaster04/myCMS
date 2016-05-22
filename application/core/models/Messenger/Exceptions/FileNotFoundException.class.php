<?
/**
 * Исключение оповещающее об не нахождении файла
 * 
 * @author Трубин Борис Игоревич <mgbit3214@gmail.com>
 * @version 1.0
 */
class FileNotFoundException extends AbstractException{
	
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