/*
!нужен Bootstrap
надо подключить класс
.deletePage
*/

$(function(){
	$(".deletePage").on("click",function(){
		addMidalWindowDeletePage($(this).attr("data"));
		$(this).attr("data-toggle","modal").attr("data-target","#modalInfoFromTitle");
	});
	$(".closeModalWindowDeletePage").on("click",function(){
		alert(1);
		delMidalWindow();
		$(this).removeAttr("data-toggle").removeAttr("data-target");
	});
});

function addMidalWindowDeletePage(text){
	$(document.body).append('<div class="modal fade" id="modalInfoFromTitle"><div class="modal-dialog modal-sm"><div class="modal-content"><div class="modal-header"><button class="close" type="button" data-dismiss="modal">&times;</button><h4 class="modal-title">Справка</h4></div><div class="modal-body"><p>Удалить страницу?</p></div><div class="modal-footer"><button class="btn btn-success closeModalWindowDeletePage" onClick="delMidalWindowDeletePage();" type="button" data-dismiss="modal">нет</button><a href="/controlpage/delPage?page='+text+'" class="btn btn-danger">да</a></div></div></div></div>');
}
function delMidalWindowDeletePage(){
	setTimeout(function(){
		$("#modalInfoFromTitle").remove();
		$(".modal-backdrop").remove();
		$("body").removeClass("modal-open");
		$(".deletePage").removeAttr("data-toggle").removeAttr("data-target");
	},100);
}