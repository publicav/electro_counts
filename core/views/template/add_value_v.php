<div id="wrap_myupload">
    <form id="add_value_counts_form" name="add_value_form" method="post" action="ajax/actionform_value/">
        <input id="edit_id" type="hidden" name="edit_id"/>
        <div class="p_input">
            <div class="label_p"><label for="lot">Участок</label></div><?php include_once 'core/views/base/lot.php' ?>
        </div>
        <div class="p_input">
            <div class="label_p"><label for="substation">Подстанция</label></div>
            <select id="substation" class="input_selected"></select></div>
        <div class="p_input">
            <div class="label_p"><label for="counter">Ячейка</label></div>
            <select id="counter" class="input_selected"></select></div>

        <div class="p_input">
            <div class="label_p"><label for="path_name"> Время замера</label></div>
            <input type="text" class="input_date_b" id="date_airing_begin" name="date_begin"
                   value="<?= date( "d-m-Y" ); ?>"/><input class="input_time_b" id="time_airing_begin"
                                                           type="text" name="time_begin"/></div>
        <div class="p_input">
            <div class="label_p"><label for="counter_last_val">Предыдущие</label></div>
            <input id="counter_last_val" type="" class="input_form" name="counter_last_val" disabled="disabled"/></div>
        <div class="p_input">
            <div class="label_p"><label for="counter_val">Значение счётчика</label></div>
            <input id="counter_val" type="" class="input_form" name="counter_val"/></div>
        <button id="ok_f" type="submit" class="button">Ok</button>
        <button id="edit_f" type="submit" class="button" disabled="disabled">Правка</button>
    </form>

    <div id="add_last_counts" class="add_last_counts">
        <ul id="list_counts"></ul>
    </div>

</div>
