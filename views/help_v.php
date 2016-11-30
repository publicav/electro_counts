<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html> 
<?php 

 echo $head; 

?>
<script type="text/javascript">
    <?php include('views/base/jquery_exec.php'); ?>
 </script>


<body>
<div id=wrap>
<?php
// include("base/top.php");
// include("base/left.php");


?>
<div id="top"> 
</div>
<div id="menu"> 
<?php 	include("base/menu.php"); ?>
</div>
<?php 	include("base/login_form.php"); // loginform ?>

<div id="left">
			<?php if ($sid > 0)	include("base/menu_left.php"); ?>
</div>

<div id="right"> 
	<div id="help1">
		<p>Для работы с программой нужно установить ниже представленные браузеры.</p>
		<p><b>x32</b></p>
		<p><a href="prog/MozillaFirefox32OfflineInstaller.exe" title="Mozila Firefox">Mozilla Firefox</a></p>
		<p><a href="prog/GoogleChrome32OfflineInstaller.exe" title="Google Chrome">Google Chrome</a></p>
		<p><a href="prog/OperaOfflineInstaller.exe" title="Opera">Opera</a></p>

		<p><b>x64</b></p>
		<p><a href="prog/MozillaFirefox64OfflineInstaller.exe" title="Mozila Firefox">Mozilla Firefox x64</a></p>
		<p><a href="prog/GoogleChrome64OfflineInstaller.exe" title="Google Chrome">Google Chrome x64</a></p>
	<div>
	<div id="product">Учёт электоэнергии  2016  ver. <?php echo $config['VERSION']; ?></div>
</div>


<div id="test"></div>
<?php
//  include_once('base/footer.php');
?>

</div>
</body>
</html>
