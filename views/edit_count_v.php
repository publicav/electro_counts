<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html> 
<?php 

 echo $head; 

?>
<script src="js/jquery.maskedinput.min.js"></script>
<script src="js/filters.js"></script>
<script src="js/edit_counts.js"></script>

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
<?php 	
	include("base/login_form.php"); // loginform 
	include("base/edit_form.php"); 
?>
<div id="left">
	<?php 	include("base/menu_left.php"); 
			if ($visibly == 1) {	include("base/filtr_lot.php");} ?>
		
</div>

<div id="right"> 

</div>


<div id="test"><?php print_r($sq); ?></div>
<?php
//  include_once('base/footer.php');
?>

</div>
</body>
</html>
