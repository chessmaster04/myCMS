<div class="panel panel-default  animation scale-in">
	<div class="panel-heading">Подключения</div>
	<div class="panel-body">
		<?
		$options = $thisController->getOptionsOfPage("main.json");
		?>
		<!--Форма-->
		<form class="form-horisontal" role="form" action="/controlpage/includes" method="post">
			<!--Файлы, которые подключаем-->
			<div class="form-group" style="overflow:hidden;">
				<?
					$arraysFiles = $thisController->getCSSAndJSLibs();
					//$arraysFiles = $thisController->getCSSAndJSFiles();
				?>
				<h5 class="col-xs-12"><b>Библиотеки</b> <small>Выделите те библиотеки, которые вы хотите подключить к сайту</small></h5>
				<div class="col-xs-12" style="max-height:600px;overflow:auto;">
					<table class="table table-condensed"> 
						<?
						foreach($arraysFiles as $lib){
							$isCheckedFile = false;
							if(is_array($options->libNames))
								foreach($options->libNames as $fileItem){
									if($fileItem == $lib){
										$isCheckedFile = true;
										break;
									}
								}
							echo "<tr><td>";
							if($isCheckedFile){
							?>
							<label><input checked type="checkbox" name="libs[<?=$lib?>]" class="mylib-checkbox"><?=$lib?></label>
							<?
							} else {
							?>
							<label><input type="checkbox" name="libs[<?=$lib?>]" class="mylib-checkbox"><?=$lib?></label>
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