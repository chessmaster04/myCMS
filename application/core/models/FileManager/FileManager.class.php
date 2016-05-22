<?
/*
FileManager::getFiles([$options]) - вернёт массив файлов
FileManager::getDirs([$options]) - вернёт массив директорий
FileManager::issetFile($fileNameWithExtension) - вернёт true/false проверка на существование файла
FileManager::issetDir($dirName) - вернёт true/false проверка на существование директории
FileManager::getPathOfFile($fileNameWithExtension[,$options]) - вернёт path по имени файла
FileManager::getDirOfFile($fileNameWithExtension[,$options]) - вернёт dir по имени файла
FileManager::getPathOfFolder($folderName[,$options]) - вернёт dir по имени папки
FileManager::getTypeOfFile($fileName) - вернёт тип(расширение) файла
*/
class FileManager {
	
	//вернёт массив имён файлов
	public static function getFiles ($options=[]) {
		return (new Scanner)
			->setOptions($options)
			->scan()
			->getFiles();
	}
	
	//вернёт массив имён директорий
	public static function getDirs ($options=[]) {
		return (new Scanner)
			->setOptions($options)
			->scan()
			->getDirs();
	}
	
	//проверка на наличие файла 
	public static function issetFile ($fileNameWithExtension, $dir=null) {
		return count((new Scanner)
			->setOptions(
				[
					"dir"=>$dir,
					"keyWordsAND"=>[$fileNameWithExtension]
				])
			->scan()
			->getFiles())>0;
	}
	
	//проверка на наличие директории 
	public static function issetDir ($dirName,$dir=null) {
		return count((new Scanner)
			->setOptions(
				[
					"dir"=>$dir,
					"keyWordsAND"=>[$dirName]
				])
			->scan()
			->getDirs())>0;
	}
	
	//вернёт path по имени файла, можно передать опции
	public static function getPathOfFile ($fileNameWithExtension,$options=[]) {
		$options["keyWordsAND"] = [$fileNameWithExtension];
		$options["showPath"] = true;
		$tmp = (new Scanner)
			->setOptions($options)
			->scan()
			->getFiles();
		return $tmp[0];
	}
	
	//вернёт dir по имени файла, можно передать опции
	public static function getDirOfFile ($fileNameWithExtension,$options=[]) {
		$options["keyWordsAND"] = [$fileNameWithExtension];
		$options["showPath"] = true;
		$tmp = (new Scanner)
			->setOptions($options)
			->scan()
			->getFiles();
		return mb_strrchr($tmp[0],"/",true)."/";
	}
	
	//вернёт dir по имени папки, можно передать опции
	public static function getPathOfFolder ($folderName,$options=[]) {
		$options["keyWordsAND"] = [$folderName];
		$options["showPath"] = true;
		$tmp = (new Scanner)
			->setOptions($options)
			->scan()
			->getDirs();
		return $tmp[0]."/";
	}
	
	//вернёт тип(расширение) файла
	public static function getTypeOfFile($fileName){
		$classReflect = new ReflectionClass("FileTypes");
		$constants = $classReflect->getConstants();
		foreach($constants as $constant){
			if(preg_match("/".$constant."$/",$fileName))
				return $constant;
		}
		return undefined;
	}
	
	/*public static function createFile ($name,$dir,$data="") {
		if(!is_string($dir)) throw new IllegalArgumentException("path должно быть строкой, а пришло: $dir");
		if(!is_string($name)) throw new IllegalArgumentException("path должно быть строкой, а пришло: $name");
		if(!is_string($data)) throw new IllegalArgumentException("path должно быть строкой, а пришло: $data");
		$dir = rtrim(rtrim($dir,"/"),"\\")."/";
		
		if(!self::issetFile($dir.$name)){
			file_put_contents($dir.$name,$data);
			if(self::issetFile($dir.$name)) return true;
		}
		return false;
	}*/
	
	/*public static function createDir () {
		
	}*/
	
	public static function renameFile ($fileName, $newName, $dir) {
		if(!is_string($dir)) throw new IllegalArgumentException("path должно быть строкой, а пришло: $dir");
		if(!is_string($fileName)) throw new IllegalArgumentException("path должно быть строкой, а пришло: $fileName");
		if(!is_string($newName)) throw new IllegalArgumentException("path должно быть строкой, а пришло: $newName");
		$dir = rtrim(rtrim($dir,"/"),"\\")."/";
		
		if(self::issetFile($dir.$fileName)){
			rename($dir.$fileName,$dir.$newName);
			if(self::issetFile($dir.$newName)) return true;
		}
		return false;
	}
	
	/*public static function deleteFile ($fileName, $dir) {
		if(!is_string($dir)) throw new IllegalArgumentException("path должно быть строкой, а пришло: $dir");
		if(!is_string($fileName)) throw new IllegalArgumentException("path должно быть строкой, а пришло: $fileName");
		$dir = rtrim(rtrim($dir,"/"),"\\")."/";
		
		if(self::issetFile($dir.$fileName)){
			unlink ($dir.$fileName);
			if(!self::issetFile($dir.$fileName)) return true;
		}
		return false;
	}*/
	
	
	
}
?>