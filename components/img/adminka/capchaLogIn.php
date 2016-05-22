<?
//генерирует картинку капчи
session_start();
$_SESSION['capchaLogIn'] = rand(1000,99999);
$png=imagecreate(200,30);
$bgc=imagecolorallocate($png,255,255,255);
$textc=imagecolorallocate($png,0,0,0);
imagestring($png,5,80,6,$_SESSION['capchaLogIn'],$textc);
header("content-type: image/png");
imagepng($png);
?>