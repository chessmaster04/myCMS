<?php
class FrontController {
	
	protected $_controller, $_body;
	static $_instance;

	public static function getInstance () {
		if(!(self::$_instance instanceof self)) 
			self::$_instance = new self();
		return self::$_instance;
	}
	private function __construct () {
		if(!class_exists("Router"))
			throw new ClassNotFoundException("Ошибка!  Отсутствует класс Router ");
		$router = new Router();
		$this->_controller = $router->getController();
	}
	public function route () {
		/*проверки*/
		if(!class_exists($this->_controller))
			throw new ClassNotFoundException("Ошибка!  Отсутствует необходимый контроллер ".$this->getController().".");
		/* Запускаем нужный контролер */
		$nameController = $this->getController();
		$this->setBody(
			(new $nameController)
				->renderPage()
				->getBody()
		);
		return $this;
	}
	public function getController () {
		return $this->_controller;
	}
	public function getBody () {
		echo $this->_body;
	}
	public function setBody ($body) {
		$this->_body = $body;
	}
}	