$(function(){
	/*CHECKBOX*/
	$(".mylib-checkbox").each(function(){
		$(this).css({"height":"0px","display":"block","margin-right":"5px","float":"left"});
		$(this).parent().css({"display":"block"});
		if($(this).is(':checked')){
			$(this).addClass("fa fa-check-square-o");
		} else {
			$(this).addClass("fa fa-square-o");
		}
		$(this).on("click",function(){
			if($(this).is(':checked')){
				$(this).removeClass("fa-square-o");
				$(this).addClass("fa-check-square-o");
				
			} else {
				$(this).removeClass("fa-check-square-o");
				$(this).addClass("fa-square-o");
			}
		});
	});
	/*RADIOBUTON*/
	$(".mylib-radio").each(function(){
		$(this).css({"height":"0px","display":"block","margin-right":"5px","float":"left"});
		$(this).parent().css({"display":"block"});
		if($(this).is(':checked')){
			$(this).addClass("fa fa-check-circle-o");
		} else {
			$(this).addClass("fa fa-circle-o");
		}
		$(this).on("click",function(){
			if($(this).is(':checked')){
				var name = $(this).attr("name");
				$("[name="+name+"][type=radio]").removeClass("fa-check-circle-o");
				$("[name="+name+"][type=radio]").addClass("fa-circle-o");
				$(this).removeClass("fa-circle-o");
				$(this).addClass("fa-check-circle-o");
			}
		});
	});
});