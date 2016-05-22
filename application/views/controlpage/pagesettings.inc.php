<div class="panel panel-default  animation scale-in">
	<div class="panel-heading">Настройка страницы</div>
	<div class="panel-body">
		<?
		$thisPageOptions  = $thisController->getOptionsOfPage(strip_tags(trim($_GET["page"])).".json");
		$mainOptions = $thisController->getOptionsOfPage("main.json");
		?>
		<!--Форма-->
		<form class="form-horisontal" role="form" action="/controlpage/pageSettings?page=<?=strip_tags(trim($_GET['page']))?>" method="post">
			<!--Поле заголовок-->
			<div class="form-group">
				<label for="inputTitle" class="col-xs-12 control-label"><h5><b>Title</b> <small>Заголовок может содержать любые символы</small></h5></label>
				<div class="col-xs-12 input-group">
					<input type="text" name="title" class="form-control" placeholder="Введите заголовок страницы" id="inputTitle" value="<?=$thisPageOptions->title?>" required maxlength="50">
				</div>
			</div>
			<!--Поле metaKey-->
			<div class="form-group">
				<label for="inputMetaKey" class="col-xs-12 control-label"><h5><b>MetaKey</b> <small>Ключевые слова могут содержать любые символы</small></h5></label>
				<div class="col-xs-12 input-group">
					<textarea required name="metaKey" class="form-control" placeholder="Введите Ключевые слова" id="inputMetaKey"  maxlength="100" style="height:100px; resize:none;"><?=$thisPageOptions->metaKey?></textarea>
				</div>
			</div>
			<!--Поле metaDesc-->
			<div class="form-group">
				<label for="inputMetaDesc" class="col-xs-12 control-label"><h5><b>MetaDesc</b> <small>Описание страницы может содержать любые символы</small></h5></label>
				<div class="col-xs-12 input-group">
					<textarea required name="metaDesc" class="form-control" placeholder="Введите Описание страницы" id="inputMetaDesc"  maxlength="100" style="height:100px; resize:none;"><?=$thisPageOptions->metaDesc?></textarea>
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
							$isDisabled = false;
							if($thisPageOptions->CSSAndJSFiles!=null)
								foreach($thisPageOptions->CSSAndJSFiles as $fileItem){
									if($fileItem == $file){
										$isCheckedFile = true;
										break;
									}
							}
							if($mainOptions->CSSAndJSFiles!=null)
								foreach($mainOptions->CSSAndJSFiles as $fileItem){
									if($fileItem == $file){
										$isDisabled = true;
										break;
									}
								}
							echo "<tr><td>";
							if($isDisabled){
							?>
							<label><input disabled checked type="checkbox" class="mylib-checkbox"><?=$file?> <span style="color:#999;font-size:12px;">наследуемые настройки</span></label>
							<?
							} elseif($isCheckedFile) {
							?>
							<label><input checked type="checkbox" name="files[<?=$file?>]" class="mylib-checkbox"> <?=$file?></label>
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
					<?
					if($thisPageOptions->removability==true){
					?>
					<label class="btn btn-success btn-block">Можно ли удалять 
					<input type="checkbox" checked name="removability" class="mylib-checkbox"></label>
					<?
					}
					if($thisPageOptions->mutability==true){
					?>
						<!--Чекбокс "Можно ли изменить" -->
					<label class="btn btn-success btn-block">Можно ли изменить 
					<input type="checkbox" checked name="mutability" class="mylib-checkbox"></label>
					<?
					}
					if($thisPageOptions->visibility==true){
					?>
						<!--Чекбокс "Можно ли видеть" -->
					<label class="btn btn-success btn-block">Можно ли видеть страницу в списках панели управления
					<input type="checkbox" checked name="visibility" class="mylib-checkbox"></label>
					<?
					}
					if($thisPageOptions->renaming==true){
					?>
						<!--Чекбокс "Можно ли переименовывать" -->
					<label class="btn btn-success btn-block">Можно ли переименовывать 
					<input type="checkbox" checked name="renaming" class="mylib-checkbox"></label>
					<?
					}
					if($thisPageOptions->copying==true){
					?>
						<!--Чекбокс "Можно ли копировать" -->
					<label class="btn btn-success btn-block">Можно ли копировать 
					<input type="checkbox" checked name="copying" class="mylib-checkbox"></label>
					<?
					}
					if($thisPageOptions->coding==true){
					?>
						<!--Чекбокс "Можно ли копировать" -->
					<label class="btn btn-success btn-block">Можно ли изменять исходный код 
					<input type="checkbox" checked name="coding" class="mylib-checkbox"></label>
					<?
					}
					?>
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