<div class="panel panel-default  animation scale-in">
	<div class="panel-heading">Панель управления страницами</div>
	<div class="panel-body">
		<h4><small>Здесь вы видите все страницы вашего сайта. С помощью кнопок управления вы можете : создавать, удалять, изменять, настраивать страницу.</small></h4>
	</div>
	<div style="max-height:600px;overflow:auto;">
	<table class="table table-hover">
		<tr>
			<th>Адресс страницы</th>
			<th>Индикаторы</th>
			<th>Кнопки управления</th>
		</tr>
		<?
		$pages = $thisController->getFilesOfPages(false);
		foreach($pages as $page){						
			//определяем настройки страницы
			$options = $thisController->getOptionsOfPage($page);
			if($options->visibility===false)continue;
			//генерируем данные для занесения в таблицу
			$pageName = strstr($page,".",true);
			
			//генерируем кнопки для управления страницой
			$buttons = "<div class='btn-group'>";
			if($options->mutability===true)
				$buttons .= "<a href='/controlpage/pageSettings?page=$pageName' class='btn btn-default' title='изменить'><i class='fa fa-wrench'></i></a>";
			if($options->removability===true)
				$buttons .= "<button data='$pageName' class='btn btn-default deletePage' title='удалить'><i class='fa fa-trash-o'></i></button>";
			if($options->renaming===true)
				$buttons .= "<button class='btn btn-default' title='переименовать' onClick='alert(\"в данной версии эта кнопка пока не работает\")'><i class='fa fa-i-cursor'></i></button>";
			if($options->copying===true)
				$buttons .= "<button class='btn btn-default' title='копировать' onClick='alert(\"в данной версии эта кнопка пока не работает\")'><i class='fa fa-clone'></i></button>";
			if($options->coding===true)
				$buttons .= "<a href='/controlpage/pageCoding?page=$pageName' class='btn btn-default' title='открыть исходный код'><i class='fa fa-file-code-o'></i></a>";
			$buttons .= "</div>";
			
			//генерируем индикаторы
			$indicators = "";
			if($options->mutability===false)
				$indicators .= '<span class="fa-stack fa-sm" title="нельзя изменять"><i class="fa fa-wrench fa-stack-1x"></i><i class="fa fa-ban fa-stack-2x text-danger"></i></span>';
			if($options->removability===false)
				$indicators .= '<span class="fa-stack fa-sm" title="нельзя удалять"><i class="fa fa-trash-o fa-stack-1x "></i><i class="fa fa-ban fa-stack-2x text-danger"></i></span>';
			if($options->renaming===false)
				$indicators .= '<span class="fa-stack fa-sm" title="нельзя переименовывать"><i class="fa fa-i-cursor fa-stack-1x "></i><i class="fa fa-ban fa-stack-2x text-danger"></i></span>';
			if($options->copying===false)
				$indicators .= '<span class="fa-stack fa-sm" title="нельзя копировать"><i class="fa fa-clone fa-stack-1x "></i><i class="fa fa-ban fa-stack-2x text-danger"></i></span>';
			if($pageName==Registry::get("defaultPage"))
				$indicators .= '<span class="fa-stack fa-sm" title="это главная страница"><i class="fa fa-home fa-stack-1x"></i><i class="fa fa-circle-thin fa-stack-2x"></i></span>';
			if($options->coding===false)
				$indicators .= '<span class="fa-stack fa-sm" title="нельзя открыть исходный код"><i class="fa fa-file-code-o fa-stack-1x"></i><i class="fa fa-ban fa-stack-2x text-danger"></i></span>';
			
			//генерируем таблицу
			echo "<tr>";
			echo "<td><a href='/$pageName'>/".$pageName."</a></td>";
			echo "<td>".$indicators."</td>";
			echo "<td>".$buttons."</td>";
			echo "</tr>";
		}
		
		//добавляем кнопку для добавления страницы
		$buttonAddPage = "<a href='/controlpage/addPage' class='btn btn-default' title='добавить'><i class='fa fa-plus'></i></a>";
		echo "<tr>";
		echo "<td></td>";
		echo "<td></td>";
		echo "<td>".$buttonAddPage."</td>";
		echo "</tr>";
		?>
	<table>
	</div>
</div>