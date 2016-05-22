/*
.validate-form //вставляется как класс формы
нужно создать класс wrongData для выделения не верно заполненых полей
Нужно создать атрибут pattern с шаблоном для валидации поля
*/
$(function(){
	$('.validate-form input[type="text"], .validate-form input[type="password"], .validate-form input[type="email"]').on("focusout",function(){
		var key = null;
		if(this.pattern!=""){
			key = validateData(this.value,this.pattern);
			
			if(key!=null){
				delWrongClass(this,key);
				addWrongClass(this,!key);
			}
		}
	});
	if($(".validate-form input[type='password']").length==2){
		$(".validate-form [type=submit]").on("mouseover",function(){
			var obj1 = $(".validate-form input[type='password']");
			var val1 = $(".validate-form input[type='password']").val();
			var obj2 = $(".validate-form input[type='password']").last();
			var val2 = $(".validate-form input[type='password']").last().val();
			if(val1!=val2){
				addWrongClass(obj1,true);
				addWrongClass(obj2,true);
			}
		});
	}
});
function validateData(str,pattern){
	var regExp = new RegExp(pattern);
	return regExp.test(str);
}
function addWrongClass(obj,key){
	if(key){
		$(".validate-form [type=submit]").addClass("disabled").attr("disabled","disabled");
		$(obj).addClass("wrongData");
	}
}
function delWrongClass(obj,key){
	if(key){
		$(".validate-form [type=submit]").removeClass("disabled").removeAttr("disabled");
		$(obj).removeClass("wrongData");
	}
}