<div class="panel panel-default  animation scale-in">
	<div class="panel-heading">Панель кодирования страницы</div>
	<div class="panel-body">
		<h4><small>Здесь вы можете кодировать страницу.</small></h4>
		<div class="tabs">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab-1" data-toggle="tab">json-файл</a></li>
				<li><a href="#tab-2" data-toggle="tab">контроллер</a></li>
				<li><a href="#tab-3" data-toggle="tab">исходный код страницы</a></li>
			</ul>
			<div class="tab-content" style="margin-top:10px;">
				<div class="tab-pane fade in active" id="tab-1">
					<pre style="word-wrap:break-word;"><code class="json" id="contentJsonFile" contenteditable="true"><?echo $thisController->getContentOfFile($_GET["page"].".json");?></code></pre>
					<form class="form-horisontal" action="/controlpage/pageCoding?page=<?=$_GET["page"]?>" method="post">
						<div class="form-group">
							<input type="hidden" name="jsonFile" id="jsonFile1" required readonly value="">
							<div class="input-group">
								<input type="submit" class="btn btn-success" value="Сохранить json-файл" onmouseup='clearhljs();document.getElementById("jsonFile1").value = document.getElementById("contentJsonFile").innerHTML;'>
							</div>
						</div>
					</form>
				</div>
				<div class="tab-pane fade" id="tab-2">
					<pre style="word-wrap:break-word;"><code class="php" id="contentControllerFile" contenteditable="true"><?echo $thisController->getContentOfFile(ucfirst($_GET["page"])."Controller.class.php");?></code></pre>
					<form class="form-horisontal" action="/controlpage/pageCoding?page=<?=$_GET["page"]?>" method="post">
						<div class="form-group">
							<input type="hidden" name="controllerFile" id="controllerFile1" required readonly value="">
							<div class="input-group">
								<input type="submit" class="btn btn-success" value="Сохранить текущий файл" onmouseup='clearhljs();document.getElementById("controllerFile1").value = document.getElementById("contentControllerFile").innerHTML;'>
							</div>
						</div>
					</form>
				</div>
				<div class="tab-pane fade" id="tab-3">
					<pre style="word-wrap:break-word;"><code class="html" id="contentHtmlFile" contenteditable="true"><?echo $thisController->getContentOfFile($_GET["page"].".php");?></code></pre>
					<form class="form-horisontal" action="/controlpage/pageCoding?page=<?=$_GET["page"]?>" method="post">
						<div class="form-group">
							<input type="hidden" name="htmlFile" id="htmlFile1" required readonly value="">
							<div class="input-group">
								<input type="submit" class="btn btn-success" value="Сохранить текущий файл" onmouseup='clearhljs();document.getElementById("htmlFile1").value = document.getElementById("contentHtmlFile").innerHTML;'>
							</div>
						</div>
					</form>
				</div>
			</div>
			<form class="form-horisontal" action="/controlpage/pageCoding?page=<?=$_GET["page"]?>" method="post">
				<div class="form-group">
					<input type="hidden" name="jsonFile" id="jsonFile" required readonly value="">
					<input type="hidden" name="controllerFile" id="controllerFile" required readonly value="">
					<input type="hidden" name="htmlFile" id="htmlFile" required readonly value="">
					<div class="input-group">
						<input type="submit" class="btn btn-success" value="Сохранить все файлы" onmouseup='clearhljs();document.getElementById("jsonFile").value = document.getElementById("contentJsonFile").innerHTML;document.getElementById("htmlFile").value = document.getElementById("contentHtmlFile").innerHTML;document.getElementById("controllerFile").value = document.getElementById("contentControllerFile").innerHTML;'>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>