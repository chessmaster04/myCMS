//v1
function getXmlHttpRequest(){//������� ������� ����� ��� ������� ������� ��� ������ ���������
		if (window.XMLHttpRequest){
			try {
				return new XMLHttpRequest();//Mozilla Firefox, Opera, IE7
			}catch (e){}
		}else if (window.ActiveXObject){
			try{
				return new ActiveXObject('Msxml2.XMLHTTP');//Internet Explorer 6 � ����
			}catch (e){}
			try{
				return new ActiveXObject('Microsoft.XMLHTTP');//������ ������ Internet Explorer
			}catch (e){}
		}
		return null;
	}