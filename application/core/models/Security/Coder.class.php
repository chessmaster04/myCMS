<?
/*

*/
class Coder{
	public static function code($str,$slide=1){
		$chars = array(
			"a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","0","2","3","4","5","6","7","8","9",".","-","_"
		);
		for($i=0;$i<strlen($str);$i++){
			for($j=0;$j<count($chars);$j++){
				if($str[$i]==$chars[$j]){
					$pos = $j + $slide;
					while($pos>count($chars))
						$pos = $pos-count($chars);
					$str[$i] = $chars[$pos];
					break;
				}
			}
		}
		return $str;
	}
}
?>