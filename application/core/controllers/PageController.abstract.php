<?
abstract class PageController{
	protected $pageData;
	protected $fileRender;
	protected $pagePath;//место находжения файла страницы, учитывая, что изначальная точка нахождения - это директория "views/"
	protected $body = null;
	
	public function __construct(){
		//проверки
		if(!class_exists("FileRender"))
			throw new ClassNotFoundException("Ошибка!  Отсутствует класс FileRender ");
		if(!class_exists("JSONParser"))
			throw new ClassNotFoundException("Ошибка!  Отсутствует класс JSONParser ");
		
		$this->fileRender = new FileRender();
		//Достаём информацию из XML файлов
		$mainOptions = new JSONParser("main.json");
		$currentPageOptions = new JSONParser(URLRegistry::getFirst().".json");
		
		$this->pagePath = $currentPageOptions->path==null?$mainOptions->path:$currentPageOptions->path;
		
		$this->pageData["title"] = $currentPageOptions->title==null?$mainOptions->title:$currentPageOptions->title;
		$this->pageData["metaDesc"] = $currentPageOptions->metaDesc==null?$mainOptions->metaDesc:$currentPageOptions->metaDesc;
		$this->pageData["metaKey"] = $currentPageOptions->metaKey==null?$mainOptions->metaKey:$currentPageOptions->metaKey;
		
		//Генерируем файлы CSS и JS		
			//1) добовляем css и js файлы во множество (это массив, который не имеет одинаковых записей)
		$array0 = is_array($mainOptions->libFiles)?$mainOptions->libFiles:array();
		$array1 = is_array($currentPageOptions->CSSAndJSFiles)?$currentPageOptions->CSSAndJSFiles:array();
		$array2 = is_array($mainOptions->CSSAndJSFiles)?$mainOptions->CSSAndJSFiles:array();
		$arrayWithPath = array_unique(array_merge($array0,$array1,$array2));		
			//2) оборачиваем названия путей файлов в теги <script> и <link> для подключения на сайт
		$this->pageData["CSSFiles"] = $this->fileRender->getwrappedCSSOrJSInTegs($arrayWithPath);		
	}
	
	public function renderPage () {
		$this->renderHeaders();
		//$this->renderHead();
		$this->renderBody();
		return $this;
	}
	
	/*Генерирует заголовки страницы, можно переопределять в классах наследниках*/
	protected function renderHeaders () {
		if(!class_exists("HeadersManager"))
			throw new ClassNotFoundException("Ошибка!  Отсутствует класс HeadersManager ");
		(new HeadersManager)
			->charset();
	}
	
	/*protected function renderHead () {
		
	}*/
	
	/*Генерирует тело страницы, не надо переопределять*/
	protected function renderBody () {
		$fileName = $this->pagePath;
		$this->body = 
		(new FileWrapper())
			->set(Registry::get("dirViews").Registry::get("indexFile"))
			->set($this->pageData)
			->set((new FileWrapper())
				->set(Registry::get("dirViews").$fileName.Registry::get("fileExtension"))
				->set($this->pageData))
			->wrap();
	}
	
	public function getBody () {
		return $this->body;
	}
}
?>