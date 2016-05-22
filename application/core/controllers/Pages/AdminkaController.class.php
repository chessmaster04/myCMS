<?
//Контролер страницы "adminka"
class AdminkaController extends PageController{
	
	private $adminAccountManager;
	private $fileManager;
	
	function __construct(){
		//проверки
		if(!class_exists("FileManager"))
			throw new ClassNotFoundException("Ошибка!  Отсутствует класс FileManager ");
		if(!class_exists("AdminAccountManager"))
			throw new ClassNotFoundException("Ошибка!  Отсутствует класс AdminAccountManager ");
			
		$this->fileManager = new FileManager();
		parent::__construct();//надо для предопределения например первостепенных вайлов CSS
		
		$this->pageData["controllerName"] = __CLASS__;//надо для предоставления возможности обращения к данному контроллеру со страницы

		$this->adminAccountManager = new AdminAccountManager();
		
		//Парсерим настройки для админки в реестр
		$_SETTINGS = parse_ini_file('application/views/adminka/settings.ini');
		foreach($_SETTINGS as $k=>$v){
			Registry::set($k,$v);
		}
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
		$fileName = $this->pagePath;
		$page = $this->fileRender->render(Registry::get("dirViews")."/".$fileName.Registry::get("fileExtension"),$this->pageData);
		$this->body = $page;
	}
	
	//Регистрируем
	function signIn(){
		return $this->adminAccountManager->signIn();
	}
	
	//проверяет зарегистрирован ли пользователь
	function isSignedIn(){
		return $this->adminAccountManager->isSignedIn();
	}
	
	//проверяет вошел ли администратор
	function isLogedIn(){
		return $this->adminAccountManager->isLogedIn();
	}
	
	//выход из системы
	function logOut(){
		return $this->adminAccountManager->logOut();
	}
	
	//вход в систему
	function logIn(){
		return $this->adminAccountManager->logIn();
	}
	
	//возвращает пути к файлам с настройками страниц
	function getFilesOfPages($withDirs=false){
		return $this->fileManager->getFiles([
			"dir"=>Registry::get("dirDataAboutPage"),
			"keyWords"=>[FileTypes::TYPE_JSON],
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
		$files = array();
		array_push($files,$this->fileManager->getFilesIn(Registry::get("dirCSSFiles"),FileTypes::TYPE_CSS,false));
		array_push($files,$this->fileManager->getFilesIn(Registry::get("dirJSFiles"),FileTypes::TYPE_JS,false));	
		
		$jsonParser = new JSONParser(Registry::get("fileLibs"));
		foreach($jsonParser->getArray() as $k=>$v){
			array_push($files,$v);
		}
		return $files;
	}
	
	//проверка на существование файлов страницы
	function issetPage($pageName){
		$options = self::getOptionsOfPage("$pageName.json");
		$nameOfController = ucfirst($pageName)."Controller";
		if(
			file_exists(Registry::get("dirDataAboutPage")."$pageName.json")&&
			file_exists(Registry::get("dirControllers")."$nameOfController.class.php")&&
			file_exists(Registry::get("dirViews").$options->path.".php")
		){
			return true;
		}
		return false;
	}
	
	//добавление страницы
	function addPage(){
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
				
				//Проверка на существование файлов, которые мы хоти создать
				$nameOfController = ucfirst($name)."Controller";
				if(
					file_exists(Registry::get("dirDataAboutPage")."$name.xml")||
					file_exists(Registry::get("dirControllers")."$nameOfController.class.php")||
					file_exists(Registry::get("dirViews").$dir."$name.php")
				){
					return false;
				}
				
				//создаём JSON файл с настройками
				$arrSettings = array(
					"path"=>$dir.$name,
					"title"=>$title,
					"metaKey"=>$metaKey,
					"metaDesc"=>$metaDesc,
					"removability"=>$keys["removability"], //возможность удалять
					"mutability"=>$keys["mutability"], //возможность изменять
					"visibility"=>$keys["visibility"], //возможность видить
					"renaming"=>$keys["renaming"], //возможность переименовывать
					"copying"=>$keys["copying"], //возможность копировать
					"CSSAndJSFiles"=>$files,
					"fileWrapper"=>$$fileWrapper,
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
	
	function changeDefaultXMLFile(){
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

				//генерируем настройки
				$keys = array();
				$keys["removability"] = false;
				$keys["mutability"] = false;
				$keys["visibility"] = false;
				$keys["renaming"] = false;
				$keys["copying"] = false;
				
				//создаём JSON файл с настройками
				$arrSettings = array(
					"title"=>$title,
					"metaKey"=>$metaKey,
					"metaDesc"=>$metaDesc,
					"removability"=>$keys["removability"], //возможность удалять
					"mutability"=>$keys["mutability"], //возможность изменять
					"visibility"=>$keys["visibility"], //возможность видить
					"renaming"=>$keys["renaming"], //возможность переименовывать
					"copying"=>$keys["copying"], //возможность копировать
					"CSSAndJSFiles"=>$files
				);
				$jsonParser = new JSONParser("$name.json");
				$jsonParser->save($arrSettings);
				
				return true;
			}
		}
		return false;
	}
	
	//удаление страницы
	function delPage(){
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
	
	//изменение настроек страницы (файл xml)
	function changeSettingsOfFile(){
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
				
				$options = self::getOptionsOfPage("$name.json");
				
				//создаём JSON файл с настройками
				$arrSettings = array(
					"path"=>$options->path,
					"title"=>$title,
					"metaKey"=>$metaKey,
					"metaDesc"=>$metaDesc,
					"removability"=>$keys["removability"], //возможность удалять
					"mutability"=>$keys["mutability"], //возможность изменять
					"visibility"=>$keys["visibility"], //возможность видить
					"renaming"=>$keys["renaming"], //возможность переименовывать
					"copying"=>$keys["copying"], //возможность копировать
					"CSSAndJSFiles"=>$files
				);
				$jsonParser = new JSONParser(Registry::get("dirDataAboutPage")."$name.json");
				$jsonParser->save($arrSettings);
				
				return true;
			}
		}
		return false;
	}
	
	//вернёт файлы wrappers страниц
	function getAllWrappersOfPages(){
		$allFiles = $this->fileManager->getFilesIn(Registry::get("dirWrappersOfPages"),FileTypes::TYPE_PHP,false);
		$filesWrapers = array();
		foreach($allFiles as $file){
			if(stripos($file,"wrapper")===0){
				array_push($filesWrapers,$file);
			}
		}
		return $filesWrapers;
	}
	
	//все действия связанные с изменением защиты админки
	function actionsOfProtectionOfAdminka(){
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			if(isset($_POST["loginOld"])&&isset($_POST["loginNew"])){
				//изменение логина
				if($this->adminAccountManager->changeLogin())
					return "Login успешно изменён";
			} elseif(isset($_POST["passOld"])&&isset($_POST["passNew1"])&&isset($_POST["passNew2"])){
				//изменение пароля
				if($this->adminAccountManager->changePass())
					return "Pass успешно изменён";
			} elseif(isset($_POST["itIsIPSecurity"])) {
				//защита по ip
				$adminRegData = new JSONParser(Registry::get("fileWithAdminRegData"));
				$data = $adminRegData->getArray();
				
				$switchIPProtection = isset($_POST["switchIPProtection"])?true:false;
				$data["switchIPProtection"] = $switchIPProtection;

				$ips = array();
				
				if(isset($_POST["ip"]))
					foreach($_POST["ip"] as $k=>$v)
						array_push($ips, $k);
				
				$data["adminIPs"] = $ips;

				$adminRegData->save($data);
				
				return "IP успешно добавлен в исключения";
			}
			return false;
		}
	}
}
?>