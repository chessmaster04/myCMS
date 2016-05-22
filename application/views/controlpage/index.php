<?
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
	<title><?=$title?></title>
	<meta charset="utf-8">
	<meta name="author" content="Трубин Борис Игоревич">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!--meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><!--Вы можете ограничить возможности приближения на мобильных устройствах добавляя user-scalable=no в мета тег видимого экрана. Это ограничит приближение, означающее что пользователи могут только скроллить (BOOTSTRAP)-->
	<?=$CSSFiles?>
	<?=$JSFiles?>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script>
		//hljs.initHighlightingOnLoad();
		function clearhljs () {
			//$("code").html(function(i,h){ return h.replace(/<span class="hljs[a-z-]{0,20}">/g,"").replace(/<span>/g,"").replace(/<span class="php">/g,"").replace(/<span>/g,"");});
		}
	</script>
</head>
<body>
	<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<br>
			<!--ШАПКА-->
			<div class="navbar navbar-default">
				<div class="container">
					<div class="navbar-header">
						<a href="/controlpage" class="navbar-brand"><i class="fa fa-coffee"></i> Boris's Engine</a>
						<?
						if($thisController->isLogedIn()){
						?>
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#responsive-menu">
							<!--Надпись "Открыть навигацию" видна только для мобильных устройств-->
							<span class="sr-only">Открыть навигацию</span>
							<!--Чёрточки, которые предопределяют внешний вид-->
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<?
						}
						?>
					</div>
					<?
					if($thisController->isLogedIn()){
					?>
					<div class="collapse navbar-collapse" id="responsive-menu">
						<ul class="nav navbar-nav">
							<li><a href="/"><i class="fa fa-home"></i></i> Перейти на сайт</a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Управление<b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="/controlpage/office"><i class="fa fa-columns"></i></i> Панель управления страницами</a></li>
									<li><a href="/controlpage/includes"><i class="fa fa-code-fork"></i></i> Подключения</a></li>
									<li><a href="/controlpage/mainCode"><i class="fa fa-code"></i></i> Исходный код сайта</a></li>
									<li><a href="/controlpage/controlAccounts"><i class="fa fa-users"></i></i> Управление аккаунтами пользователей</a></li>
								</ul>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Настройки<b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="/controlpage/defaultSettings"><i class="fa fa-cog"></i></i> Дефолтные настройки страницы</a></li>
									<li><a href="/controlpage/securityOfAdminka"><i class="fa fa-lock"></i></i> Настройки безопасности админки</a></li>
									<li><a href="/controlpage/systemConfig"><i class="fa fa-cogs"></i></i> Конфигурации системы</a></li>
								</ul>
							</li>
							<li><a href="/controlpage/exit"><i class="fa fa-sign-out"></i> Выход</a></li>
						</ul>
					</div>
					<?
					}
					?>
				</div>
			</div>
			<!--Окно с ошибками-->
			<?
			global $textError;
			if(isset($textError)&&!empty($textError)) {
			?>
			<div class="alert alert-warning alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?=$textError?>
			</div>
			<?
			} elseif(isset($_GET["textSuccess"])){
				$textSuccess = trim(strip_tags($_GET["textSuccess"]));
			?>
			<div class="alert alert-success alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?=$textSuccess?>
			</div>
			<?
			}
			?>
			<!--ТЕЛО-->
			<?=$content?>
		</div>
	</div>
	</div>
	
</body>
</html>