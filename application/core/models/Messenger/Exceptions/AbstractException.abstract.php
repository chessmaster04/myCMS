<?
/**
 * AbstractException
 *
 * Класс содержит основные свойства и методы, которые наследуются другими класами.
 * 
 * @author Трубин Борис Игоревич <mgbit3214@gmail.com>
 * @version 1.0
 * 
 * @method void __construct()
 * @method String getText()
 */
abstract class AbstractException extends Exception implements InterfaceException {
	
	/**
	 * Свойство класса
	 * 
	 * @var String сообщение
	 */
	protected $mgs;
	
	/**
	 * конструктор класса
	 * 
	 * @param String $msg
	 * @param String $className
	 */
	function __construct($msg,$className){
		$this->mgs .= "Исключение: ".$className."\nТекст сообщения: $msg \nНа строке: ".$this->getLine()."\nВ файле: ".$this->getFile()."\nВремя: ".date("d/m/Y H:i:s");
	}
	
	/**
	 * Геттер сообщения
	 * 
	 * @return String $mgs
	 */
	function getText(){
		return $this->mgs;
	}
}
?>