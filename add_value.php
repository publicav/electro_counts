<?php
include_once("models/config.php");
include_once("models/open.php");
include_once("models/json/lots.php");
?>
<!DOCTYPE html>
<html> 
<head>
</head>

<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
<script type="text/javascript" charset="utf-8" src="js/main.js"></script>
<script src="js/ui/minified/jquery-ui.min.js"></script>
<link rel="stylesheet" href="css/jquery-ui.min.css">
<link rel="stylesheet" href="css/adm.css">
<script src="js/jquery.maskedinput.min.js"></script>
<script src="js/add_counts.js"></script>

<body> 
<div id="wrap_myupload">
    <form id="add_value_counts_form" name="add_value_form" method="post" action="models/json/add_value_counts.php">     
		<input id="edit_id"  type="hidden"  name="edit_id"/>
		<div class="p_input"><div class="label_p"><label for="lot">Участок</label></div><?php include_once("views/base/lot.php"); ?></div>
		<div class="p_input"><div class="label_p"><label for="substation">Подстанция</label></div><select id="substation" class="input_selected"></select></div>
		<div class="p_input"><div class="label_p"><label for="counter">Ячейка</label></div><select id="counter" class="input_selected"></select></div>
        
		<div class="p_input"><div class="label_p"><label for="path_name"> Время замера</label></div><input type="text"  class="input_date_b" id="date_airing_begin"  name="date_begin" value="<?php echo  date("d-m-Y");;?>"/><input   class="input_time_b" id="time_airing_begin" type="time" name="time_begin"/></div>
        <div class="p_input"><div class="label_p"><label for="counter_val">Значение счётчика</label></div><input id="counter_val"  type="" class="input_form" name="counter_val"/></div>        
		<button id="ok_f"  type="submit" class="button">Ok</button>
		<button id="edit_f"  type="submit" class="button" disabled="disabled">Правка</button>
	</form>

	<div id="add_last_counts" class="add_last_counts">
		<ul id="list_counts"></ul> 
	</div>

</div>

</body> 
</html>