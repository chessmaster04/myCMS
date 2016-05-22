<?
class FileManager {
	
	//вернёт массив названий файлов с их путями или без по определённому типу
	static function getFiles($type,$withPath=true){
		$arrayFiles = self::getAllFiles(".",$withPath);
		$arrayFilesByType = array();
		foreach($arrayFiles as $file){
			if(self::getTypeOfFile($file)==$type){
				array_push($arrayFilesByType,$file);
			}
		}
		return $arrayFilesByType;
	}
	
	//вернёт массив названий файлов с их путями или без по определённому типу или без указания типа в указанной дириктории
	static function getFilesIn($dir=".",$type=null,$withPath=true){
		$arrayFiles = self::getAllFiles($dir,$withPath);
		$arrayFilesByType = array();
		foreach($arrayFiles as $file){
			if(type==null){
				array_push($arrayFilesByType,$file);
			} elseif(self::getTypeOfFile($file)==$type) {
				array_push($arrayFilesByType,$file);
			}
		}
		return $arrayFilesByType;
	}
	
	//проверяет есть ли такой файл
	static function issetFile($fileNameAndExtension,$dir="."){
		$arrayFiles = self::getAllFiles($dir,false);
		foreach($arrayFiles as $file){
			if($file==$fileNameAndExtension){
				return true;
			}
		}
		return false;
	}
	
	//вернёт путь к файлу
	static function getPathOfFile($fileName){
		$arrayFiles = self::getAllFiles(".",true);
		foreach($arrayFiles as $file){
			if(empty($file)||empty($fileName))
				continue;
			if(stristr($file,trim($fileName))){
				return $file;
			}
		}
		return null;
	}
	
	//вернёт тип(расширение) файла
	static function getTypeOfFile($fileName){
		$classReflect = new ReflectionClass("FileTypes");
		$constants = $classReflect->getConstants();
		foreach($constants as $constant){
			//if(stristr($fileName,$constant))
			if(preg_match("/".$constant."$/",$fileName))
				return $constant;
		}
		return undefined;
	}
	
	private static function getAllFiles($dir=".",$withPath=true){
		$arrayDirs = array();
		$catalog = scandir($dir);
		foreach($catalog as $item){
			if($item=="."||$item=="..")continue;
			$itemWithPath = $dir=="."?$item:$dir."/".$item;
			if($withPath)
				$item = $itemWithPath;
			if(is_dir($itemWithPath)){
				$arrayDirs = array_merge($arrayDirs,self::getAllFiles($itemWithPath,$withPath));
			}elseif(is_file($itemWithPath)){
				array_push($arrayDirs,$item);
			}
		}
		return $arrayDirs;
	}
}
?>