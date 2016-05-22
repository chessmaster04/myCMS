<?
class ControlpageController extends PageController{
	
	private $adminAccountManager;
	
	function __construct(){
		
		session_start();
		
		//ЭТО НЕ ИЗМЕНЯТЬ 
		parent::__construct();//надо для предопределения например файлов CSS и JS		
		$this->pageData["controllerName"] = __CLASS__;//надо для предоставления возможности обращения к данному контроллеру со страницы
		if(!class_exists("AdminAccountManager"))
			throw new ClassNotFoundException("Ошибка!  Отсутствует класс AdminAccountManager ");
		
		$this->adminAccountManager = new AdminAccountManager();
		
		//Парсерим настройки для админки в реестр
		$_SETTINGS = parse_ini_file('application/views/controlpage/settings.ini');
		foreach($_SETTINGS as $k=>$v){
			Registry::set($k,$v);
		}
	}
	
	/*
	 * Теставая функция, которую можно удалить
	 */
	function getTest(){
		return "связь view и ".__CLASS__." налажена";
	}
	
	//стандартная функция для рендирования страницы
	protected function renderHeaders(){
		if(!class_exists("HeadersManager"))
			throw new ClassNotFoundException("Ошибка!  Отсутствует класс HeadersManager ");
		(new HeadersManager)
			->charset()
			->noCache();
	}
	
	//переопределяем стандартную функция для загрузки страницы
	protected function renderBody(){
		$this->body = 
		(new FileWrapper())
			->set(Registry::get("dirViews")."controlpage/index.php")
			->set($this->pageData)
			->set((new FileWrapper())
				->set(Registry::get("dirViews")."controlpage/".self::initPage())
				->set($this->pageData)
				)
			->wrap();
	}
	
	//определяем какую страницу загружать в controlpage/index.php
	private function initPage () {
		//определяем страницу (раздел controlpage)
		if(URLRegistry::get(1)==null)
			header("Location: /controlpage/signin");
		$page = URLRegistry::get(1);
		
		global $textError;
		switch ($page) {
			CASE "exit" :
				if(self::isLogedIn()){
					self::logOut();
					header("Location: /controlpage");
				}
			CASE "signin": //раздел регистрации
				//если мы не зарегестрированы
				if(!$this->isSignedIn()){
					//если пришел POST, то регистрируем
					if($_SERVER["REQUEST_METHOD"]=="POST"){
						if(!self::signIn()){
							$textError = "<strong>Ошибка регистрации!</strong> Возможно вы ввели не правильно ключ.";
						} else {
							header("Location: /controlpage/login");
						}
					}
					$file = "signin.inc.php";
					break;
				}
			CASE "login" :
				if(!self::isLogedIn()){
					if($_SERVER["REQUEST_METHOD"]=="POST"){
						if(!$this->logIn()){
							$textError = "<strong>Ошибка входа!</strong> Возможно вы ввели не правильно данные.";
						} else {
							header("Location: /controlpage/office");
						}
					}
					$file = "login.inc.php";
					break;
				}
			CASE "office" : //Панель управления страницами
				if(self::isLogedIn()){
					$file = "office.inc.php";
					break;
				}
			CASE "addPage" : 
				if(self::isLogedIn()){
					if($_SERVER["REQUEST_METHOD"]=="POST"){
						if(!$this->addPage()){
							$textError = "<strong>Ошибка!</strong> Страница не смогла создаться."; 
						} else {
							$textSuccess = "Успех! Страница создана.";
							header("Location: /controlpage/office?textSuccess=$textSuccess");
						}
					}
					$file = "addpage.inc.php";
					break;
				}
			CASE "pageSettings" :
				if(self::isLogedIn()){
					if($_SERVER["REQUEST_METHOD"]=="POST"){
						if(!$this->changeSettingsOfFile()){
							$textError = "<strong>Ошибка!</strong> Настройки не были применены."; 
						} else {
							$textSuccess = "Успех! Настройки страницы обновлены.";
							header("Location: /controlpage/office?textSuccess=$textSuccess");
						}
					}
					$file = "pagesettings.inc.php";
					break;
				}
			CASE "delPage" : 
				if(self::isLogedIn()){
					if($_SERVER["REQUEST_METHOD"]=="GET"){
						if($this->delPage()){
							$textSuccess = "Успех! Страница удалена.";
							header("Location: /controlpage/office?textSuccess=$textSuccess");
						} else {
							header("Location: /controlpage/office");
						}
					}
				}
			CASE "pageCoding" :
				if(self::isLogedIn()){
					if(isset($_GET["page"])){
						$_GET["page"] = strip_tags(trim($_GET["page"]));
						if(FileManager::issetFile($_GET["page"])){
							if($_SERVER["REQUEST_METHOD"]=="POST"){
								if(!$this->updateCodeOfPage($_GET["page"])){
									$textError = "<strong>Ошибка!</strong> Код страницы не обновлён."; 
								} else {
									$textSuccess = "Успех! Код страницы обновлён.";
									header("Location: /controlpage/pageCoding?page=".$_GET["page"]."&&textSuccess=$textSuccess");
								}
							}
							$file = "pagecoding.inc.php";
							break;
						}
					}
				}
			CASE "defaultSettings" : 
				if(self::isLogedIn()){
					if($_SERVER["REQUEST_METHOD"]=="POST"){
						if(!$this->changeDefaultSettings()){
							$textError = "<strong>Ошибка!</strong> Настройки не были применены."; 
						} else {
							$textSuccess = "Успех! Настройки страницы обновлены.";
							header("Location: /controlpage/office?textSuccess=$textSuccess");
						}
					}
					$file = "defaultSettings.inc.php";
					break;
				}
			CASE "mainCode" :
				if(self::isLogedIn()){
					if($_SERVER["REQUEST_METHOD"]=="POST"){
						if(!$this->updateMainCode()){
							$textError = "<strong>Ошибка!</strong> Настройки не были применены."; 
						} else {
							$textSuccess = "Успех! Настройки страницы обновлены.";
							header("Location: /controlpage/mainCode?textSuccess=$textSuccess");
						}
					}
					$file = "panelOfMainCode.inc.php";
					break;
				}
			CASE "includes" :
				if(self::isLogedIn()){
					if($_SERVER["REQUEST_METHOD"]=="POST"){
						if(!$this->addLibsToMainFile()){
							$textError = "<strong>Ошибка!</strong> Библиотеки не были подключены."; 
						} else {
							$textSuccess = "Успех! Нужные библиотеки были подключены.";
							header("Location: /controlpage/includes?textSuccess=$textSuccess");
						}
					}
					$file = "includes.inc.php";
					break;
				}
			DEFAULT :
				$file = "error404.inc.php";
		}
		if(!FileManager::issetFile($file)) $file = "error404.inc.php";
		if(!FileManager::issetFile($file)) throw new FileNotFoundException("Не найден файл $file");
		return $file;
	}
	
	//Регистрируем
	private function signIn(){
		return $this->adminAccountManager->signIn();
	}
	
	//проверяет зарегистрирован ли администратор
	private function isSignedIn(){
		return $this->adminAccountManager->isSignedIn();
	}
	
	//проверяет вошел ли администратор
	public function isLogedIn(){
		return $this->adminAccountManager->isLogedIn();
	}
	
	//выход из системы
	private function logOut(){
		return $this->adminAccountManager->logOut();
	}
	
	//вход в систему
	private function logIn(){
		return $this->adminAccountManager->logIn();
	}
	
	//возвращает пути к файлам с настройками страниц
	public function getFilesOfPages($withDirs=false){
		return FileManager::getFiles([
			"dir"=>Registry::get("dirDataAboutPage"),
			"keyWordsAND"=>[FileTypes::TYPE_JSON],
			"showPath"=>$withDirs
			]);
	}
	
	//возвращает настройки страницы, а точнее рендирует объект xml файла страницы
	function getOptionsOfPage($fileNameWithExtension){
		if(!class_exists("JSONParser"))
			throw new ClassNotFoundException("Ошибка!  Отсутствует класс JSONParser ");
		$jsonParser = new JSONParser($fileNameWithExtension);
		return $jsonParser;
	}
	
	//
	function getCSSAndJSFiles(){
		$files = FileManager::getFiles([
			"keyWordsOR" => [FileTypes::TYPE_CSS,FileTypes::TYPE_JS],
			"keyWordsNOT" => [FileTypes::TYPE_JSON],
			"showPath" => false
		]);
		
		/*$jsonParser = new JSONParser(Registry::get("fileLibs"));
		foreach($jsonParser->getArray() as $v){
			foreach($v as $item)
				array_push($files,$item);
		}*/
		return $files;
	}
	
	function getCSSAndJSLibs () {
		$list = array();
		$jsonParser = new JSONParser(Registry::get("fileLibs"));
		foreach($jsonParser->getArray() as $k=>$v){
			array_push($list,$k);
		}
		return $list;
	}
	
	//вернёт файлы wrappers страниц
	function getAllWrappersOfPages(){
		$filesWrapers = FileManager::getFiles([
			"dir"=>Registry::get("dirWrappersOfPages"),
			"keyWordsAND"=>[FileTypes::TYPE_PHP,"wrapper"],
			"showPath"=>false
			]);
		return $filesWrapers;
	}
	
	//добавление страницы
	private function addPage(){
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			if(isset($_POST["name"])&&isset($_POST["title"])&&isset($_POST["dir"])&&isset($_POST["metaKey"])&&isset($_POST["metaDesc"])&&isset($_POST["fileWrapper"])){
				//Обрабатываем данные
				$name = strip_tags(trim($_POST["name"]));
				$title = strip_tags(trim($_POST["title"]));
				$dir = strip_tags(trim($_POST["dir"]));
				$metaKey = strip_tags(trim($_POST["metaKey"]));
				$metaDesc = strip_tags(trim($_POST["metaDesc"]));
				$fileWrapper = strip_tags(trim($_POST["fileWrapper"]));
				$files = array();
				if(isset($_POST["files"]))
					foreach($_POST["files"] as $k=>$v)
						array_push($files, $k);
				
				//генерируем настройки
				$keys = array();
				$keys["removability"] = isset($_POST["removability"])?true:false;
				$keys["mutability"] = isset($_POST["mutability"])?true:false;
				$keys["visibility"] = isset($_POST["visibility"])?true:false;
				$keys["renaming"] = isset($_POST["renaming"])?true:false;
				$keys["copying"] = isset($_POST["copying"])?true:false;
				$keys["coding"] = isset($_POST["coding"])?true:false;
				
				//Проверка на существование файлов, которые мы хоти создать
				$nameOfController = ucfirst($name)."Controller";
				if(
					file_exists(Registry::get("dirDataAboutPage")."$name.json")||
					file_exists(Registry::get("dirControllers")."$nameOfController.class.php")||
					file_exists(Registry::get("dirViews").$dir."$name.php")
				){
					return false;
				}
				
				//создаём JSON файл с настройками
				$arrSettings = array(
					"dir"=>$dir,
					"path"=>$dir.$name,
					"name"=>$name,
					"title"=>$title,
					"metaKey"=>$metaKey,
					"metaDesc"=>$metaDesc,
					"removability"=>$keys["removability"], //возможность удалять
					"mutability"=>$keys["mutability"], //возможность изменять
					"visibility"=>$keys["visibility"], //возможность видить
					"renaming"=>$keys["renaming"], //возможность переименовывать
					"copying"=>$keys["copying"], //возможность копировать
					"coding"=>$keys["coding"], //возможность кодить
					"CSSAndJSFiles"=>$files,
					"fileWrapper"=>$fileWrapper,
				);
				$jsonParser = new JSONParser(Registry::get("dirDataAboutPage")."$name.json");
				$jsonParser->save($arrSettings);
				
				//создаём контроллер
				FileRender::createController($name);

				//Создаём файл
				FileRender::createFileOfPage($name,$dir);
				
				return true;
			}
		}
		return false;
	}
	
	//изменение настроек страницы
	private function changeSettingsOfFile(){
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			if(isset($_POST["title"])&&isset($_POST["metaKey"])&&isset($_POST["metaDesc"])&&isset($_GET["page"])){
				//Обрабатываем данные
				$name = strip_tags(trim($_GET["page"]));
				$title = strip_tags(trim($_POST["title"]));
				$metaKey = strip_tags(trim($_POST["metaKey"]));
				$metaDesc = strip_tags(trim($_POST["metaDesc"]));
				$files = array();
				if(isset($_POST["files"]))
					foreach($_POST["files"] as $k=>$v)
						array_push($files, $k);

				//генерируем настройки
				$keys = array();
				$keys["removability"] = isset($_POST["removability"])?true:false;
				$keys["mutability"] = isset($_POST["mutability"])?true:false;
				$keys["visibility"] = isset($_POST["visibility"])?true:false;
				$keys["renaming"] = isset($_POST["renaming"])?true:false;
				$keys["copying"] = isset($_POST["copying"])?true:false;
				$keys["coding"] = isset($_POST["coding"])?true:false;
				
				$options = self::getOptionsOfPage("$name.json");
				
				//создаём JSON файл с настройками
				$arrSettings = array(
					"dir"=>$options->dir,
					"name"=>$options->name,
					"path"=>$options->path,
					"title"=>$title,
					"metaKey"=>$metaKey,
					"metaDesc"=>$metaDesc,
					"removability"=>$keys["removability"], //возможность удалять
					"mutability"=>$keys["mutability"], //возможность изменять
					"visibility"=>$keys["visibility"], //возможность видить
					"renaming"=>$keys["renaming"], //возможность переименовывать
					"copying"=>$keys["copying"], //возможность копировать
					"coding"=>$keys["coding"], //возможность кодить страницу
					"CSSAndJSFiles"=>$files,
					"fileWrapper"=>$options->fileWrapper,
				);
				$jsonParser = new JSONParser(Registry::get("dirDataAboutPage")."$name.json");
				$jsonParser->save($arrSettings);
				
				return true;
			}
		}
		return false;
	}
	
	//изменение найстроек дефолтной страницы
	private function changeDefaultSettings(){
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			if(isset($_POST["title"])&&isset($_POST["metaKey"])&&isset($_POST["metaDesc"])){
				//Обрабатываем данные
				$name = "main";
				$title = strip_tags(trim($_POST["title"]));
				$metaKey = strip_tags(trim($_POST["metaKey"]));
				$metaDesc = strip_tags(trim($_POST["metaDesc"]));
				$files = array();
				if(isset($_POST["files"]))
					foreach($_POST["files"] as $k=>$v)
						array_push($files, $k);
				
				$jsonParser = new JSONParser("$name.json");
				$arrayData = $jsonParser->getArray();
				$arrayData["title"] = $title;
				$arrayData["metaKey"] = $metaKey;
				$arrayData["metaDesc"] = $metaDesc;
				$arrayData["CSSAndJSFiles"] = $files;

				$jsonParser->save($arrayData);
				
				return true;
			}
		}
		return false;
	}
	
	//удаление страницы
	private function delPage(){
		if($_SERVER["REQUEST_METHOD"]=="GET"){
			if(isset($_GET["page"])&&!empty($_GET["page"])){
				//Обрабатываем данные
				$page = strip_tags(trim($_GET["page"]));
				
				//Проверка на существование файлов, которые мы хотим удалить
				if(file_exists(Registry::get("dirDataAboutPage")."$page.json")){
					$options = self::getOptionsOfPage("$page.json");
					if($options->path!=null&&file_exists(Registry::get("dirViews").$options->path.".php")){
						$nameOfController = ucfirst($page)."Controller";
						if(file_exists(Registry::get("dirControllers")."$nameOfController.class.php")){
							//Удаление
							unlink(Registry::get("dirControllers")."$nameOfController.class.php");
							unlink(Registry::get("dirViews").$options->path.".php");
							unlink(Registry::get("dirDataAboutPage")."$page.json");
							return true;
						}
					}
				}
			}
		}
		return false;
	}
	
	//вернёт содержимое файла
	public function getContentOfFile ($fileNameAndExtension) {
		if(FileManager::issetFile($fileNameAndExtension)){
			ob_start();
			echo htmlspecialchars(file_get_contents(FileManager::getPathOfFile($fileNameAndExtension)));
			return ob_get_clean();
		}
		return null;
	}
	
	//перезапишет 3 файла из которых состоит страница страницы
	private function updateCodeOfPage ($pageName) {
		$key = false;
		$controllerName = ucfirst($pageName)."Controller.class.php";
		$jsonFileName = $pageName.".json";
		$htmlFileName = $pageName.".php";
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			
			if(isset($_POST["jsonFile"])){
				$key = self::updateCodeOfFile($_POST["jsonFile"],$jsonFileName);
			}
			if(isset($_POST["controllerFile"])){
				$key = self::updateCodeOfFile($_POST["controllerFile"],$controllerName);
			}
			if(isset($_POST["htmlFile"])){
				$key = self::updateCodeOfFile($_POST["htmlFile"],$htmlFileName);
			}
		}
		return $key;
	}
	
	//функция для обновления перезаписи определённой страицы
	private function updateCodeOfFile ($data,$fileNameAndExtension) {
		if(FileManager::issetFile($fileNameAndExtension)){
			$data = "'".html_entity_decode($data)."'";
			file_put_contents(FileManager::getPathOfFile($fileNameAndExtension),trim($data,"'"));
			return true;
		}
		return false;
	}
	
	//обновления кода главных файлов файла: main.json views/index.php и wrapper_standart.php
	private function updateMainCode () {
		$key = false;
		$indexName = "views/index.php";
		$jsonFileName = "main.json";
		$wrapperName = "wrapper_standart.php";
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			
			if(isset($_POST["jsonFile"])){
				$key = self::updateCodeOfFile($_POST["jsonFile"],$jsonFileName);
			}
			if(isset($_POST["indexFile"])){
				$key = self::updateCodeOfFile($_POST["indexFile"],$indexName);
			}
			if(isset($_POST["wrapperFile"])){
				$key = self::updateCodeOfFile($_POST["wrapperFile"],$wrapperName);
			}
		}
		return $key;
	}
	
	//добавление библиотек к сайту (в файл main.json)
	private function addLibsToMainFile () {
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			if(isset($_POST["libs"])){
				//Обрабатываем данные
				$name = "libs";
				$libFiles = array();
				$libNames = array();
				
				$libParser = new JSONParser("$name.json");
				foreach($libParser->getArray() as $libName=>$files){
					foreach($_POST["libs"] as $lib=>$v){
						if($libName==$lib){
							array_push($libNames, $libName);
							foreach($files as $file){
								if(!in_array($file,$libFiles))
									array_push($libFiles, $file);
							}
						}
					}
				}
				
				$mainJsonParser = new JSONParser("main.json");
				$data = $mainJsonParser->getArray();
				$data['libFiles'] = $libFiles;
				$data['libNames'] = $libNames;
				$mainJsonParser->save($data);
				return true;
			}
		}
		return false;
	}
}
?>