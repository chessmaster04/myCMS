<div class="panel panel-default  animation scale-in">
	<div class="panel-heading">Дефолтные настройки страницы</div>
	<div class="panel-body">
		<?
		$options = $thisController->getOptionsOfPage("main.json");
		?>
		<!--Форма-->
		<form class="form-horisontal" role="form" action="/controlpage/defaultSettings" method="post">
			<!--Поле заголовок-->
			<div class="form-group">
				<label for="inputTitle" class="col-xs-12 control-label"><h5><b>Title</b> <small>Заголовок может содержать любые символы</small></h5></label>
				<div class="col-xs-12 input-group">
					<input type="text" name="title" class="form-control" placeholder="Введите заголовок страницы" id="inputTitle" value="<?=$options->title?>" required maxlength="50">
				</div>
			</div>
			<!--Поле metaKey-->
			<div class="form-group">
				<label for="inputMetaKey" class="col-xs-12 control-label"><h5><b>MetaKey</b> <small>Ключевые слова могут содержать любые символы</small></h5></label>
				<div class="col-xs-12 input-group">
					<textarea required name="metaKey" class="form-control" placeholder="Введите Ключевые слова" id="inputMetaKey"  maxlength="100" style="height:100px; resize:none;"><?=$options->metaKey?></textarea>
				</div>
			</div>
			<!--Поле metaDesc-->
			<div class="form-group">
				<label for="inputMetaDesc" class="col-xs-12 control-label"><h5><b>MetaDesc</b> <small>Описание страницы может содержать любые символы</small></h5></label>
				<div class="col-xs-12 input-group">
					<textarea required name="metaDesc" class="form-control" placeholder="Введите Описание страницы" id="inputMetaDesc"  maxlength="100" style="height:100px; resize:none;"><?=$options->metaDesc?></textarea>
				</div>
			</div>
			<!--Файлы, которые подключаем-->
			<div class="form-group" style="overflow:hidden;">
				<?
					$arraysFiles = $thisController->getCSSAndJSFiles();
				?>
				<h5 class="col-xs-12"><b>Подключаемые CSS и JS Файлы</b> <small>Выделите те файлы, которые вы хотите подключить к данной странице, но учтите, что к ней же подключатся все файлы, которые прописанны в дефолтной страние</small></h5>
				<div class="col-xs-12" style="height:300px;overflow:auto;">
					<table class="table table-condensed"> 
						<?
						foreach($arraysFiles as $file){
							$isCheckedFile = false;
							if(is_array($options->CSSAndJSFiles))
								foreach($options->CSSAndJSFiles as $fileItem){
									if($fileItem == $file){
										$isCheckedFile = true;
										break;
									}
								}
							echo "<tr><td>";
							if($isCheckedFile){
							?>
							<label><input checked type="checkbox" name="files[<?=$file?>]" class="mylib-checkbox"><?=$file?></label>
							<?
							} else {
							?>
							<label><input type="checkbox" name="files[<?=$file?>]" class="mylib-checkbox"><?=$file?></label>
							<?
							}
							echo "</td></tr>";
						}
						?>
					</table>
				</div>
			</div>
			<!--Submit-->
			<div class="form-group" style=
			"margin:20px;">
				<button type="submit" class="btn btn-default btn-block btn-lg"><i class="fa fa-plus"></i> Обновить</button>
			</div>
		</form>
	</div>
</div>