<?
/*
класс Scanner записывает в массив все имена файлов и директорий
(new Scanner)[->setOptions(...)]->scan()->getDirs()/getFiles();

Пример использования:
print_r(
	(new Scanner)
		->setOptions(
			[
				"dir"=>"application",
				"showPath"=>false,
				"keyWordsAND"=>["Controller","class"],
				"keyWordsOR"=>["Controller","inc"],
				"keyWordsNOT"=>["FrontController"],
				"goInDepth"=>false
			])
		->scan()
		->getDirs()
);
*/
class Scanner {
	
	const STARTDIR = ".";
	private $_arrayFiles = array();
	private $_arrayDirs = array();
	
	private $_dir = "."; //от куда начинать сканирование
	private $_showPath = true; //показывать путь к файлу или нет
	private $_goInDepth = true; //идти в глубину или нет
	private $_keyWordsAND = null; //ключевые слова, которые должны обязательно содержаться в каждом имени (КОНЪЮНКЦИЯ)
	private $_keyWordsOR = null; //ключевые слова, по которым делать поиск (ДИЗЪЮНКЦИЯ)
	private $_keyWordsNOT = null; //ключеные слова, которые надо избегать
	
	public function setOptions ($options=[]) {
		if(is_array($options))
			extract($options);
		//Инициализация настроек
		$this->_dir = isset($dir)?$dir:self::STARTDIR;
		$this->_dir = rtrim($this->_dir,"/");
		$this->_dir = rtrim($this->_dir,"\\");
		$this->_showPath = isset($showPath)?$showPath:true; //показывать путь к файлу или нет
		$this->_keyWordsAND = isset($keyWordsAND)?$keyWordsAND:null;
		$this->_keyWordsOR = isset($keyWordsOR)?$keyWordsOR:null;
		$this->_keyWordsNOT = isset($keyWordsNOT)?$keyWordsNOT:null;

		$this->_goInDepth = isset($goInDepth)?$goInDepth:true; //искать в глубину папок или нет
		
		return $this;
	}
	
	public function getFiles () {
		return $this->_arrayFiles;
	}
	
	public function getDirs () {
		return $this->_arrayDirs;
	}
	
	public function scan () {
		//Инициализация настроек
		$dir = $this->_dir;
		$showPath = $this->_showPath;
		//$arrayKeyWords = $this->_keyWords;
		//$arrayExceptivesKeyWords = $this->_exceptivesKeyWords;
		$keyWordsAND = $this->_keyWordsAND;
		$keyWordsOR = $this->_keyWordsOR;
		$keyWordsNOT = $this->_keyWordsNOT;
		$goInDepth = $this->_goInDepth;
	
		//Алгоритм поиска
		$arrayElements = array();
		$catalog = scandir($dir);
		foreach($catalog as $item){
			$key = false;
			if($item=="."||$item=="..")continue;
			$itemWithPath = $dir=="."?$item:$dir."/".$item;
			if(is_dir($itemWithPath)){
				//добавляем директорию
				$dir = htmlentities($dir, ENT_QUOTES, "utf-8");
				
				if ( $keyWordsAND!=null ) {
					$key = self::conjunction($dir,$keyWordsAND) || $key;
				} 
				if ( $keyWordsOR!=null ) {
					$key = self::disjunction($dir,$keyWordsOR) || $key;
				} 
				if ( $keyWordsNOT!=null ) {
					$key = self::not($dir,$keyWordsNOT) || $key;
				}
				
				if($key!=true){
					array_push($this->_arrayDirs,$dir);
					$this->_arrayDirs = array_values(array_unique($this->_arrayDirs));
				}
				//Идём в глубину
				if($goInDepth){
					$this->_dir = $itemWithPath;
					self::scan();
				}
			}elseif(is_file($itemWithPath)){
				//Добавление файла
				if($showPath)
					$item = $itemWithPath;
				$item = htmlentities($item, ENT_QUOTES, "utf-8");
				
				if ( $keyWordsAND!=null ) {
					$key = self::conjunction($item,$keyWordsAND) || $key;
				} 
				if ( $keyWordsOR!=null ) {
					$key = self::disjunction($item,$keyWordsOR) || $key;
				} 
				if ( $keyWordsNOT!=null ) {
					$key = self::not($item,$keyWordsNOT) || $key;
				}
				
				if($key!=true){
					array_push($this->_arrayFiles,$item);
					$this->_arrayFiles = array_values(array_unique($this->_arrayFiles));
				}
			}
		}
		return $this;
	}
	
	//логическое и
	private function conjunction ($str, $arrayWords) {
		if ($arrayWords==null) return null;
		foreach ($arrayWords as $word) {
			if(empty($word)) continue;
			$word = trim($word);
			if(stristr($str,$word)===false){
				return true;
			}
		}
		return false;
	}
	
	//логическое или
	private function disjunction ($str, $arrayWords) {
		if ($arrayWords==null) return null;
		foreach ($arrayWords as $word) {
			if(empty($word)) continue;
			$word = trim($word);
			if(stristr($str,$word)!==false){
				return false;
			}
		}
		return true;
	}
	
	//логическое не
	private function not ($str, $arrayWords) {
		return !self::conjunction($str, $arrayWords);
	}
}
?>