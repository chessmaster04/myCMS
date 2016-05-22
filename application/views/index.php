<!DOCTYPE HTML>
<html>
<head>
	<title><?=$title?></title>
	<meta charset="utf-8">
	<meta name="description" content="<?=$metaDesc?>">
	<meta name="keywords" content="<?=$metaKey?>">
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
</head>
<body>
	<?include_once("parts/wrapper_standart.php")?>
</body>
</html>