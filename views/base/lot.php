<select id="lot" class="input_selected">
<?php
	$mainfile = '';
	for($i=0;$i<SizeOf($lots);$i++) 
	{
			$mainfile .= '<option value="' . $lots[$i][id] . '">' .
								$lots[$i]['name'] . '
						  </option>
			';
	}
	echo $mainfile;

?>
</select>