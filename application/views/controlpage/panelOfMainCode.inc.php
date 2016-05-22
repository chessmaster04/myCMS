<div class="panel panel-default  animation scale-in">
	<div class="panel-heading">Панель кодирования страницы</div>
	<div class="panel-body">
		<h4><small>Здесь вы можете кодировать страницу.</small></h4>
		<div class="tabs">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab-1" data-toggle="tab">main.json</a></li>
				<li><a href="#tab-2" data-toggle="tab">index</a></li>
				<li><a href="#tab-3" data-toggle="tab">wrapper_standart</a></li>
			</ul>
			<div class="tab-content" style="margin-top:10px;">
				<div class="tab-pane fade in active" id="tab-1">
					<pre style="word-wrap:break-word;"><code class="json" id="contentJsonFile" contenteditable="true"><?echo $thisController->getContentOfFile(main.".json");?></code></pre>
					<form class="form-horisontal" action="/controlpage/mainCode" method="post">
						<div class="form-group">
							<input type="hidden" name="jsonFile" id="jsonFile1" required readonly value="">
							<div class="input-group">
								<input type="submit" class="btn btn-success" value="Сохранить json-файл" onmouseup='clearhljs();document.getElementById("jsonFile1").value = document.getElementById("contentJsonFile").innerHTML;'>
							</div>
						</div>
					</form>
				</div>
				<div class="tab-pane fade" id="tab-2">
					<pre style="word-wrap:break-word;"><code class="php" id="contentIndexFile" contenteditable="true"><?echo $thisController->getContentOfFile("views/index.php");?></code></pre>
					<form class="form-horisontal" action="/controlpage/mainCode" method="post">
						<div class="form-group">
							<input type="hidden" name="indexFile" id="indexFile1" required readonly value="">
							<div class="input-group">
								<input type="submit" class="btn btn-success" value="Сохранить текущий файл" onmouseup='clearhljs();document.getElementById("indexFile1").value = document.getElementById("contentIndexFile").innerHTML;'>
							</div>
						</div>
					</form>
				</div>
				<div class="tab-pane fade" id="tab-3">
					<pre style="word-wrap:break-word;"><code class="html" id="contentWrapperFile" contenteditable="true"><?echo $thisController->getContentOfFile("parts/wrapper_standart.php");?></code></pre>
					<form class="form-horisontal" action="/controlpage/mainCode" method="post">
						<div class="form-group">
							<input type="hidden" name="wrapperFile" id="wrapperFile1" required readonly value="">
							<div class="input-group">
								<input type="submit" class="btn btn-success" value="Сохранить текущий файл" onmouseup='clearhljs();document.getElementById("wrapperFile1").value = document.getElementById("contentWrapperFile").innerHTML;'>
							</div>
						</div>
					</form>
				</div>
			</div>
			<form class="form-horisontal" action="/controlpage/mainCode" method="post">
				<div class="form-group">
					<input type="hidden" name="jsonFile" id="jsonFile" required readonly value="">
					<input type="hidden" name="indexFile" id="indexFile" required readonly value="">
					<input type="hidden" name="wrapperFile" id="wrapperFile" required readonly value="">
					<div class="input-group">
						<input type="submit" class="btn btn-success" value="Сохранить все файлы" onmouseup='clearhljs();
						document.getElementById("jsonFile").value = document.getElementById("contentJsonFile").innerHTML; document.getElementById("wrapperFile").value = document.getElementById("contentWrapperFile").innerHTML; document.getElementById("indexFile").value = document.getElementById("contentIndexFile").innerHTML;'>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>