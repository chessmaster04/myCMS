<?
/*
Вспомогательный класс Search
*/
class PrioritySort{
	//СОРТИРУЕМ В ПОРЯДКЕ ПРИОРИТЕТА, ОТФИЛЬТРОВЫВАЯ ПО КЛЮЧЕВЫМ СЛОВАМ
	static function getSortedArray($array,$priorityFields,$keyString){
		$keyWords = $keyString;
		$keys = $priorityFields;
		$tmpArr = array();
		for($j=0;$j<count($keyWords);$j++){//перебираем все ключевые поля
			for($z=0;$z<count($keys);$z++)
				for($i=0;$i<count($array);$i++){
					$key = false;
					//ищим сходство	
					if(strstr($array[$i][$keys[$z]],$keyWords[$j]))
						$key=true;
					//проверка, если вдруг уже такой результат записали
					for($y=0;$y<count($tmpArr);$y++)
						if($tmpArr[$y]==$array[$i])$key=false;
					if($key)
						array_push($tmpArr,$array[$i]);
				}
		}
		//ВОЗВРАЩАЕМ ОТФИЛЬРОВАННЫЕ ДАННЫЕ
		return $tmpArr;
	}
}
?>