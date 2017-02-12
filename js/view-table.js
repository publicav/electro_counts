﻿$(function () {

    $('#group').change(function () {
        cmd_arr.group = $(this).val();
        jsonGetGroup(cmd_arr);
    })
    cmd_arr.group = 1;
    jsonGetGroup(cmd_arr);

    $('.filtred_checkbox').on('click', function () {
        var checkbox_id = $(this).attr('id');

        cmd_arr.group = $('#group').val();
        if ((checkbox_id == 'dt1_en'))
            if ($('#dt1_en').prop('checked')) {

                $('#dt2_en').prop('disabled', false);

                $("#dt1").datepicker('enable');
                jsonGetGroup(cmd_arr);
                // json_get_table($('#right'), cmd_arr);
                // history.pushState(null, null, create_cmd(base_link, cmd_arr));

            } else {
                delete cmd_arr.date_b;
                delete cmd_arr.date_e;

                $('#dt2_en').prop('disabled', true);
                $('#dt2_en').prop('checked', false);


                $("#dt1").datepicker('disable');
                $("#dt2").datepicker('disable');
                jsonGetGroup(cmd_arr);

                // json_get_table($('#right'), cmd_arr);
                // history.pushState(null, null, create_cmd(base_link, cmd_arr));
            }

        if ((checkbox_id == 'dt2_en'))
            if ($('#dt2_en').prop('checked')) {

                $("#dt2").datepicker('enable');
                cmd_arr.date_e = $("#dt2").datepicker().val();
                jsonGetGroup(cmd_arr);
                // json_get_table($('#right'), cmd_arr);
                // history.pushState(null, null, create_cmd(base_link, cmd_arr));

            } else {
                delete cmd_arr.date_e;


                $("#dt2").datepicker('disable');
                jsonGetGroup(cmd_arr);
                // json_get_table($('#right'), cmd_arr);
                // history.pushState(null, null, create_cmd(base_link, cmd_arr));
            }
    });


    $("#dt1").datepicker({
        changeYear: true, changeMonth: true, minDate: '2016-11-11', maxDate: '0', dateFormat: 'yy-mm-dd',
        onSelect: function (dateText, inst) {
            cmd_arr.date_b = dateText;
            console.log(cmd_arr);
            jsonGetGroup(cmd_arr);
            // json_get_table($('#right'), cmd_arr);
        }
    });

    $("#dt2").datepicker({
        changeYear: true, changeMonth: true, minDate: '2016-11-11', maxDate: '0', dateFormat: 'yy-mm-dd',
        onSelect: function (dateText, inst) {
            cmd_arr.date_e = dateText;
            jsonGetGroup(cmd_arr);
            // json_get_table($('#right'), cmd_arr);
        }
    });

    if (!$('#dt1_en').prop('checked')) $("#dt1").datepicker('disable');
    if (!$('#dt2_en').prop('checked')) $("#dt2").datepicker('disable');
     $('#dt2_en').prop('disabled', true);



$( document ).tooltip({ content: function() { return this.getAttribute("title") } });

});

