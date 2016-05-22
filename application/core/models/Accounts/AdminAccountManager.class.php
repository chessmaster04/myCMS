<?
/*

*/
class AdminAccountManager {
	function __construct(){
		
	}
	
	//Регистрируем
	function signIn(){
		if(!self::isSignedIn()&&$_SERVER["REQUEST_METHOD"]=="POST"){
			if(
				isset($_POST["login"])&&
				isset($_POST["pass1"])&&
				isset($_POST["pass2"])&&
				isset($_POST["time"])&&
				isset($_POST["ip"])&&
				isset($_POST["key"])
			){
				//Инициализация
				$login = trim(strip_tags($_POST["login"]));
				$pass1 = trim(strip_tags($_POST["pass1"]));
				$pass2 = trim(strip_tags($_POST["pass2"]));
				$time = trim(strip_tags($_POST["time"]));
				$ip = trim(strip_tags($_POST["ip"]));
				$key = trim(strip_tags($_POST["key"]));
				//проверяем секретный код на соответствие
				$keyParts = explode("-",$key);
				$key = parse_ini_file(Registry::get("pathWithKey"));
				if(
					count($keyParts)==4&&
					$key["part1"]==md5($keyParts[0])&&
					$key["part2"]==md5($keyParts[1])&&
					$key["part3"]==md5($keyParts[2])&&
					$key["part4"]==md5($keyParts[3])
				){
					if($pass1==$pass2){
						$pass = $pass1;
						//Кодируем данные
						$login = md5($login);
						$pass = md5(Coder::code($pass,date("d",$time)));
						$ip = md5(Coder::code($ip,date("d",$time)));
						//Генерируем json данные
						$data = array(
							"login" => $login,
							"pass" => $pass,
							"time" => $time,
							"ip" => $ip);
						//записываем данные
						$adminRegData = new JSONParser(Registry::get("pathWithAdminRegData"));
						$adminRegData->save($data);
						//запоменаем данные об админе
						self::createSessions($login,$pass);
						return true;
					}
				}
			}
		}
		return false;
	}
	
	//проверяет зарегистрирован ли администратор
	function isSignedIn(){
		return file_exists(Registry::get("pathWithAdminRegData"));
	}
	
	//проверяет вошел ли администратор
	function isLogedIn(){
		if(isset($_SESSION["adminLogin"])&&isset($_SESSION["adminPass"])&&self::isSignedIn()){
			$adminRegData = new JSONParser(Registry::get("fileWithAdminRegData"));
			if(
				$_SESSION["adminLogin"]==$adminRegData->login&&
				$_SESSION["adminPass"]==$adminRegData->pass		
			){
				return true;
			}
		}
		return false;
	}
	
	//выход из системы
	function logOut(){
		if(isset($_SESSION["adminLogin"])&&isset($_SESSION["adminPass"])){
			unset($_SESSION["adminLogin"]);
			unset($_SESSION["adminPass"]);
			return true;
		}
		return false;
	}
	
	//вход в систему
	function logIn(){
		if(self::isSignedIn()&&$_SERVER["REQUEST_METHOD"]=="POST"){
			if(
				isset($_POST["login"])&&
				isset($_POST["pass"])&&
				isset($_POST["time"])&&
				isset($_POST["ip"])&&
				isset($_POST["capcha"])
			){
				//Инициализация
				$login = trim(strip_tags($_POST["login"]));
				$pass = trim(strip_tags($_POST["pass"]));
				$time = trim(strip_tags($_POST["time"]));
				$ip = trim(strip_tags($_POST["ip"]));
				$capcha = trim(strip_tags($_POST["capcha"]));
				//проверка капчи
				if($capcha==$_SESSION['capchaLogIn']){
					$adminRegData = new JSONParser(Registry::get("fileWithAdminRegData"));
					//Кодирование
					$login = md5($login);
					$pass = md5(Coder::code($pass,date("d",$adminRegData->time)));
					if(
						$login==$adminRegData->login&&
						$pass==$adminRegData->pass
					){
						self::createSessions($login,$pass);
						return true;
					}
				}
			}
		}
		return false;
	}
	
	//изменение логина
	function changeLogin(){
		if(self::isSignedIn()&&$_SERVER["REQUEST_METHOD"]=="POST"){
			if(
				isset($_POST["loginOld"])&&
				isset($_POST["loginNew"])
			){
				//Инициализация
				$loginOld = trim(strip_tags($_POST["loginOld"]));
				$loginNew = trim(strip_tags($_POST["loginNew"]));

				$adminRegData = new JSONParser(Registry::get("fileWithAdminRegData"));
				//Кодирование
				$loginOld = md5($loginOld);
				$loginNew = md5($loginNew);
				if(
					$loginOld==$adminRegData->login
				){
					$data = $adminRegData->getArray();
					$data["login"] = $loginNew;
					$adminRegData->save($data);
					$this->createSessions($loginNew,$adminRegData->pass);
					return true;
				}
			}
		}
		return false;
	}
	
	//изменение пароля
	function changePass(){
		if(self::isSignedIn()&&$_SERVER["REQUEST_METHOD"]=="POST"){
			if(
				isset($_POST["passOld"])&&
				isset($_POST["passNew1"])&&
				isset($_POST["passNew2"])
			){
				//Инициализация
				$passOld = trim(strip_tags($_POST["passOld"]));
				$passNew1 = trim(strip_tags($_POST["passNew1"]));
				$passNew2 = trim(strip_tags($_POST["passNew2"]));

				//проверка совпадения паролей
				if($passNew1==$passNew2){
					$adminRegData = new JSONParser(Registry::get("fileWithAdminRegData"));
					//Кодирование
					$passOld = md5(Coder::code($passOld,date("d",$adminRegData->time)));
					$passNew1 = md5(Coder::code($passNew1,date("d",$adminRegData->time)));
					if(
						$passOld==$adminRegData->pass
					){
						$data = $adminRegData->getArray();
						$data["pass"] = $passNew1;
						$adminRegData->save($data);
						$this->createSessions($adminRegData->login,$passNew1);
						return true;
					}
				}
			}
		}
		return false;
	}
	
	private function createSessions($login,$pass){
		$_SESSION["adminLogin"] = $login;
		$_SESSION["adminPass"] = $pass;
	}
}
?>