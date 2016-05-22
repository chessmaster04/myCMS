//v1
function getXmlHttpRequest(){//функцыя которая знает как создать объекст для разных браузеров
		if (window.XMLHttpRequest){
			try {
				return new XMLHttpRequest();//Mozilla Firefox, Opera, IE7
			}catch (e){}
		}else if (window.ActiveXObject){
			try{
				return new ActiveXObject('Msxml2.XMLHTTP');//Internet Explorer 6 и ниже
			}catch (e){}
			try{
				return new ActiveXObject('Microsoft.XMLHTTP');//Ранние версии Internet Explorer
			}catch (e){}
		}
		return null;
	}