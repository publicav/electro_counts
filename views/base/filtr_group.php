	<div class="title_filtred">Фильтры</div>
	<div class="f_input_filtred">
		<label for="lot_en" class="filtred_label">Группа счётчиков</label>
	</div>

	<select id="group" class="filtred_selected">
	<?php
        \pdo\Groupfilter::init()->render();
    ?>
	</select>
<div class="f_input">
	<label for="dt1_en" class="filtred_label">Дата начало</label>
</div>
<div id="dt1" ></div>

<div class="f_input">
	<label for="dt2_en" class="filtred_label">Дата конец</label>
</div>
<div id="dt2" ></div>
