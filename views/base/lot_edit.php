<select id="lot_edit" class="input_selected">
<?php
    $lots = \pdo\Lots::GetLots();
	$mainfile = '';
	for($i = 0;$i < SizeOf( $lots ); $i++){
        $mainfile .= "<option value=\"{$lots[$i]['id']}\">{$lots[$i]['name']}</option>";
	}
	echo $mainfile;
?>
</select>