<div class="panel panel-default  animation scale-in">
	<div class="panel-heading">Добавление страницы</div>
	<div class="panel-body">
		<!--Форма-->
		<form class="form-horisontal" role="form" action="/controlpage/addPage" method="post">
			<!--Поле адресс-->
			<div class="form-group">
				<label for="inputName" class="col-xs-12 control-label"><h5><b>Name</b> <small>Aдресс должен содержать только латинские символы</small></h5></label>
				<div class="col-xs-12 input-group">
					<span class="input-group-addon"><?=$_SERVER["SERVER_NAME"]?>/</span>
					<input type="text" name="name" class="form-control" placeholder="Введите адресс файла" pattern="^[a-zA-Z0-9]+$" id="inputName" value="" maxlength="50" required>
				</div>
			</div>
			<!--Поле заголовок-->
			<div class="form-group">
				<label for="inputTitle" class="col-xs-12 control-label"><h5><b>Title</b> <small>Заголовок может содержать любые символы</small></h5></label>
				<div class="col-xs-12 input-group">
					<input type="text" name="title" class="form-control" placeholder="Введите заголовок страницы" id="inputTitle" value="" required maxlength="50">
				</div>
			</div>
			<!--Поле директория-->
			<div class="form-group">
				<label for="inputDir" class="col-xs-12 control-label"><h5><b>Directory</b> <small>Путь должен содержать только латинские символы и слешь "/" на конце</small></h5></label>
				<div class="col-xs-12 input-group">
					<span class="input-group-addon"><?=Registry::get("dirViews")?></span>
					<input type="text" name="dir" class="form-control" placeholder="Введите путь к будущему файлу страницы" pattern="^[a-zA-Z/]+$" id="inputDir" value="pages/" required>
				</div>
			</div>
			<!--Поле metaKey-->
			<div class="form-group">
				<label for="inputMetaKey" class="col-xs-12 control-label"><h5><b>MetaKey</b> <small>Ключевые слова могут содержать любые символы</small></h5></label>
				<div class="col-xs-12 input-group">
					<textarea required name="metaKey" class="form-control" placeholder="Введите Ключевые слова" id="inputMetaKey"  maxlength="100" style="height:100px; resize:none;"></textarea>
				</div>
			</div>
			<!--Поле metaDesc-->
			<div class="form-group">
				<label for="inputMetaDesc" class="col-xs-12 control-label"><h5><b>MetaDesc</b> <small>Описание страницы может содержать любые символы</small></h5></label>
				<div class="col-xs-12 input-group">
					<textarea required name="metaDesc" class="form-control" placeholder="Введите Описание страницы" id="inputMetaDesc"  maxlength="100" style="height:100px; resize:none;"></textarea>
				</div>
			</div>
			<!--Файлы, которые подключаем-->
			<div class="form-group" style="overflow:hidden;">
				<?
					$arrayFiles = $thisController->getCSSAndJSFiles();
					$options = $thisController->getOptionsOfPage("main.json");
				?>
				<h5 class="col-xs-12"><b>Подключаемые CSS и JS Файлы</b> <small>Выделите те файлы, которые вы хотите подключить к данной странице, но учтите, что к ней же подключатся все файлы, которые прописанны в дефолтной страние</small></h5>
				<div class="col-xs-12" style="height:300px;overflow:auto;">
					<table class="table table-condensed"> 
						<?
						foreach($arrayFiles as $file){
							$isCheckedFile = false;
							if($options->CSSAndJSFiles!=null)
								foreach($options->CSSAndJSFiles as $fileItem){
									if($fileItem == $file){
										$isCheckedFile = true;
										break;
									}
								}
							echo "<tr><td>";
							if($isCheckedFile){
							?>
							<label><input disabled checked type="checkbox" name="files[]" class="mylib-checkbox"> <?=$file?><span style="color:#999;font-size:12px;"> добавляется автоматически</span></label>
							<?
							} else {
							?>
							<label><input type="checkbox" name="files[<?=$file?>]" class="mylib-checkbox"> <?=$file?></label>
							<?
							}
							echo "</td></tr>";
						}
						?>
					</table>
				</div>
			</div>
			<!--Настройки-->
			<div class="form-group" style="clear:both;">
				<h5 class="col-xs-12"><b>Настройки</b> <small>Уделите этому большое внимание, так как настойки поменять будет уже нельзя</small></h5>
				<div class="panel-group col-xs-12">
						<!--Чекбокс "Можно ли удалять" -->
					<label class="btn btn-success btn-block">Можно ли удалять 
					<input type="checkbox" checked name="removability" class="mylib-checkbox"></label>
						<!--Чекбокс "Можно ли изменить" -->
					<label class="btn btn-success btn-block">Можно ли изменить 
					<input type="checkbox" checked name="mutability" class="mylib-checkbox"></label>
						<!--Чекбокс "Можно ли видеть" -->
					<label class="btn btn-success btn-block">Можно ли видеть 
					<input type="checkbox" checked name="visibility" class="mylib-checkbox"></label>
						<!--Чекбокс "Можно ли переименовывать" -->
					<label class="btn btn-success btn-block">Можно ли переименовывать 
					<input type="checkbox" checked name="renaming" class="mylib-checkbox"></label>
						<!--Чекбокс "Можно ли копировать" -->
					<label class="btn btn-success btn-block">Можно ли копировать 
					<input type="checkbox" checked name="copying" class="mylib-checkbox"></label>
						<!--Чекбокс "Можно ли изменять исходный код" -->
					<label class="btn btn-success btn-block">Можно ли изменять исходный код
					<input type="checkbox" checked name="coding" class="mylib-checkbox"></label>
				</div>
			</div>
			<!--Выбор Wrapper для страницы-->
			<div class="form-group">
				<h5 class="col-xs-12"><b>Выбор Wrapper для страницы</b> <small>не спрашивайте меня что это</small></h5>
				<div class="panel-group col-xs-12">
				<?
				$filesWrappers = $thisController->getAllWrappersOfPages();
				?>
				<table class="table table-condensed" > 
					<?
					foreach($filesWrappers as $file){
						echo "<tr><td>";
					?>
						<label><input type="radio" required name="fileWrapper" class="mylib-radio" value="<?=$file?>"><?=$file?>
						</label>
					<?
					}
					?>
				</table>
				</div>
			</div>
			<!--Submit-->
			<div class="form-group" >
				<div class="panel-group col-xs-12">
					<button type="submit" class="btn btn-default btn-block btn-lg"><i class="fa fa-plus"></i> Создать</button>
				</div>
			</div>
		</form>
	</div>
</div>