<select id="lot_edit" class="input_selected">
<?php
	$mainfile = '';
	for($i = 0;$i < SizeOf( $lots ); $i++) 
	{
	  if ($i != 0)	
			$mainfile .= '<option value="' . $lots[$i][id] . '">' .
								$lots[$i]['name'] . '
						  </option>
			';
	}
	echo $mainfile;

?>
</select>