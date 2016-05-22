<?
/*
//ИНСТРУКЦИЯ
	//использование без отправки на эмейл и без try..catch
Messenger::getInstance()
	->sendInFileWithErrors(new FileNotFoundMessage("Что-то произошло!"));
	
	//С использованием try..catch
try{
	...KOD...
} catch (Exception $e){
	Messenger::getInstance()
		->sendInFileWithErrors($e)
		->sendEmail($e)
		->getTextOfErrorForUsers();
}
*/
/**
 * Messenger оповещает в случае исключительной ситуации.
 * 
 * Данный класс оповещает в случае исключительной ситуации по средством добовления текста ошибки в файл с ошибками и отправкой ошибки на электронную почту администратора.
 * 
 * @author Трубин Борис Игоревич <mgbit3214@gmail.com>
 * @version 1.0
 * 
 * @method Messenger public static getInstance()
 * @method void private __construct()
 * @method Messenger public sendInFileWithErrors(InterfaceException $obj)
 * @method Messenger public sendEmail(InterfaceException $obj)
 * @method Messenger public getTextOfErrorForUsers()
 */
class Messenger {
	
	/**
	 * Свойства класса
	 * 
	 * @var String $fileWithErrors имя файла с ошибками
	 * @var Messenger $_instance содежит сам класс
	 */
	protected $fileWithErrors;
	static $_instance;
	
	/**
	 * Метод возвращает класс
	 * 
	 * @return Messenger
	 */
	public static function getInstance() {
		if(!(self::$_instance instanceof self)) 
			self::$_instance = new self();
		return self::$_instance;
	}
	
	/**
	 * Метод конструктор
	 */
	private function __construct(){
		//тут определяем имя файла с ошибками
		if(Registry::has("fileWithErrors"))
			$this->fileWithErrors = Registry::get("fileWithErrors");
		else
			$this->fileWithErrors = "errors.log";
	}
	
	/**
	 * Метод отправляет информацию об ошибке в файл с ошибками
	 * 
	 * @param InterfaceException $obj
	 * @return Messenger
	 */
	public function sendInFileWithErrors(InterfaceException $obj){
		if($obj instanceof InterfaceException){
			file_put_contents($this->fileWithErrors,"Произошло то, что не должно было произойти"."\n".$obj->getText()."\n\n",FILE_APPEND);
		}
		return $this;
	}
	
	/**
	 * Метод отправляет информацию об ошибке на эмейл
	 * 
	 * @param InterfaceException $obj
	 * @return Messenger
	 */
	public function sendEmail(InterfaceException $obj){
		if($obj instanceof InterfaceException){
			$headers = "Content-type: text/html; charset=utf-8 \r\n";
			$emailAdress = Registry::get("adminEmailAdress");
			$message = $obj->getText();
			$subject = "";
			mail($emailAdress, $subject, $message, $headers);
		}
		return $this;
	}
	
	/**
	 * Метод пишет сообщение об ошибке на экран
	 * 
	 * @return Messenger
	 */
	public function getTextOfErrorForUsers(){
		echo "При работе сайта возникла ошибка, просим прощения за неудобства, мы уже работаем над этим!";
		return $this;
	}
}
?>