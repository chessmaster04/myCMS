<?
/*
ЗАДАЧА МОДЕЛИ:
	1. дать нужные данные тем компонентам, которые их запрашивают
	2. знает где данные находятся и как они организованы
	3. умеет обновлять, вставлять и удалять данные.
*/
class DBModel{
	private static $_instance;
	private $_db;
	
	private function __construct(){
		$this->_db = self::connect();
	}
	private function __clone(){
		
	}
	public static function getInstance(){
		if (null === self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	function connect(){//подключение к базе данных
		try{			
			$db = new PDO(Registry::get("db.conn"),Registry::get("db.user"),Registry::get("db.pass"));
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (PDOException $e){
			throw new DBException("Ошибка подключения к базе данных! ".$e->getMessage());
		}
		return $db;
	}
	function getData($sql){
		//производим очистку sql текста
		if(class_exists("CheckData")){
			$dataEditor = new CheckData($sql);
			$dataEditor->clearData();
			$sql = $dataEditor;
		}
		//производим опирации по вытаскиванию данных из БД
		$data = array();
		if($this->_db){
			try{
				$query = $this->_db->query($sql);
				$result = $query->fetchAll(PDO::FETCH_ASSOC);
				if($result){
					foreach($result as $k=>$v){
						$data[$k] = $v;
					}
				}
			}catch(PDOException $e){
				throw new DBException("Ошибка при работе с базой данных! ".$e->getMessage());
			}
		}
		return $data;
	}
	function setData($sql){
		//производим очистку sql текста
		if(class_exists("CheckData")){
			$dataEditor = new CheckData($sql);
			$dataEditor->clearData();
			$sql = $dataEditor;
		}
		//производим опирации по направлению команды в БД
		if($this->_db){
			try{
				$query = $this->_db->query($sql);
				$res = true;
			}catch(PDOException $e){
				throw new DBException("Ошибка при работе с базой данных! ".$e->getMessage());
				$res = false;
			}
		}
		return $res;
	}
	function __call($name,$params){//на запрашиваемые несуществующие методы 
		return $this->_db->$name($params[0]);
	}
	function __destruct(){
		unset($this->_db);
	}
}
?>