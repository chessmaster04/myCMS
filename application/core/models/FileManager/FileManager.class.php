<?
/*
FileManager::getFiles([$options]) - ����� ������ ������
FileManager::getDirs([$options]) - ����� ������ ����������
FileManager::issetFile($fileNameWithExtension) - ����� true/false �������� �� ������������� �����
FileManager::issetDir($dirName) - ����� true/false �������� �� ������������� ����������
FileManager::getPathOfFile($fileNameWithExtension[,$options]) - ����� path �� ����� �����
FileManager::getDirOfFile($fileNameWithExtension[,$options]) - ����� dir �� ����� �����
FileManager::getPathOfFolder($folderName[,$options]) - ����� dir �� ����� �����
FileManager::getTypeOfFile($fileName) - ����� ���(����������) �����
*/
class FileManager {
	
	//����� ������ ��� ������
	public static function getFiles ($options=[]) {
		return (new Scanner)
			->setOptions($options)
			->scan()
			->getFiles();
	}
	
	//����� ������ ��� ����������
	public static function getDirs ($options=[]) {
		return (new Scanner)
			->setOptions($options)
			->scan()
			->getDirs();
	}
	
	//�������� �� ������� ����� 
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
	
	//�������� �� ������� ���������� 
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
	
	//����� path �� ����� �����, ����� �������� �����
	public static function getPathOfFile ($fileNameWithExtension,$options=[]) {
		$options["keyWordsAND"] = [$fileNameWithExtension];
		$options["showPath"] = true;
		$tmp = (new Scanner)
			->setOptions($options)
			->scan()
			->getFiles();
		return $tmp[0];
	}
	
	//����� dir �� ����� �����, ����� �������� �����
	public static function getDirOfFile ($fileNameWithExtension,$options=[]) {
		$options["keyWordsAND"] = [$fileNameWithExtension];
		$options["showPath"] = true;
		$tmp = (new Scanner)
			->setOptions($options)
			->scan()
			->getFiles();
		return mb_strrchr($tmp[0],"/",true)."/";
	}
	
	//����� dir �� ����� �����, ����� �������� �����
	public static function getPathOfFolder ($folderName,$options=[]) {
		$options["keyWordsAND"] = [$folderName];
		$options["showPath"] = true;
		$tmp = (new Scanner)
			->setOptions($options)
			->scan()
			->getDirs();
		return $tmp[0]."/";
	}
	
	//����� ���(����������) �����
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
		if(!is_string($dir)) throw new IllegalArgumentException("path ������ ���� �������, � ������: $dir");
		if(!is_string($name)) throw new IllegalArgumentException("path ������ ���� �������, � ������: $name");
		if(!is_string($data)) throw new IllegalArgumentException("path ������ ���� �������, � ������: $data");
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
		if(!is_string($dir)) throw new IllegalArgumentException("path ������ ���� �������, � ������: $dir");
		if(!is_string($fileName)) throw new IllegalArgumentException("path ������ ���� �������, � ������: $fileName");
		if(!is_string($newName)) throw new IllegalArgumentException("path ������ ���� �������, � ������: $newName");
		$dir = rtrim(rtrim($dir,"/"),"\\")."/";
		
		if(self::issetFile($dir.$fileName)){
			rename($dir.$fileName,$dir.$newName);
			if(self::issetFile($dir.$newName)) return true;
		}
		return false;
	}
	
	/*public static function deleteFile ($fileName, $dir) {
		if(!is_string($dir)) throw new IllegalArgumentException("path ������ ���� �������, � ������: $dir");
		if(!is_string($fileName)) throw new IllegalArgumentException("path ������ ���� �������, � ������: $fileName");
		$dir = rtrim(rtrim($dir,"/"),"\\")."/";
		
		if(self::issetFile($dir.$fileName)){
			unlink ($dir.$fileName);
			if(!self::issetFile($dir.$fileName)) return true;
		}
		return false;
	}*/
	
	
	
}
?>