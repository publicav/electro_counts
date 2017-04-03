"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var GeturlVar_1 = require("./libs/GeturlVar");
$(function () {
    var RIGHT = $('#right');
    var SELECTED_ACTIONS = 1, EDIT_ACTIONS = 2;
    var parseBASENAME = window.location.pathname.slice(1).split('/');
    var BASENAME = parseBASENAME[parseBASENAME.length - 1];
    var base_link = BASENAME;
    var objFiltred = {
        objSubstation: $('#substation'),
        objCounter: $('#counter'),
        url_substation: 'ajax/subst_filter/',
        url_counter: 'ajax/counter_filter/'
    };
    var cmd_line = GeturlVar_1.getUrlVars1();
    json_get_table($('#right'), cmd_line);
    $.datepicker.setDefaults($.extend($.datepicker.regional["ru"]));
    if (('id_lot' in cmd_line) && ('id_sub' in cmd_line) && ('id_counter' in cmd_line)) {
        $('#lot [value="' + cmd_arr.id_lot + '"]').prop("selected", true);
        get_substation(objFiltred, cmd_line.id_lot, EDIT_ACTIONS, cmd_line.id_sub, cmd_line.id_counter);
    }
    else {
        if (('id_lot' in cmd_line) && ('id_sub' in cmd_line)) {
            $('#lot [value="' + cmd_line.id_lot + '"]').prop("selected", true);
            get_substation(objFiltred, cmd_line.id_lot, EDIT_ACTIONS, cmd_line.id_sub);
        }
        else {
            if ('id_lot' in cmd_line) {
                $('#lot [value="' + cmd_line.id_lot + '"]').prop("selected", true);
                get_substation(objFiltred, cmd_line.id_lot);
            }
        }
    }
    if ('date_b' in cmd_line) {
        $("#dt1_en").attr("checked", "checked");
        $('#dt2_en').prop('disabled', false);
        $("#dt1").datepicker('enable');
        console.log('date_b in cmd_line');
    }
    if ('date_e' in cmd_line) {
        $("#dt2_en").attr("checked", "checked");
        $("#dt2").datepicker('enable');
        console.log('date_e in cmd_line');
    }
    $('#lot').change(function () {
        var lot = $(this).val();
        cmd_line.id_lot = lot;
        console.log(cmd_line);
        if (lot == 0) {
            delete cmd_line.id_lot;
            delete cmd_line.id_sub;
            delete cmd_line.id_counter;
            delete cmd_line.st;
        }
        else {
            delete cmd_line.st;
            delete cmd_line.id_sub;
            delete cmd_line.id_counter;
            $('#substation').prop('disabled', false);
        }
        console.log(cmd_line);
        get_substation(objFiltred, lot);
        json_get_table($('#right'), cmd_line);
        history.pushState(null, null, create_cmd(base_link, cmd_line));
    });
    $('#substation').change(function () {
        var lot = $('#lot').val();
        var substation = $(this).val();
        cmd_line.id_lot = lot;
        cmd_line.id_sub = substation;
        if (substation == 0) {
            delete cmd_line.id_sub;
            delete cmd_line.id_counter;
            delete cmd_line.st;
        }
        else {
            delete cmd_line.st;
            delete cmd_line.id_counter;
        }
        get_counter(objFiltred, substation);
        json_get_table($('#right'), cmd_line);
        history.pushState(null, null, create_cmd(base_link, cmd_line));
    });
    $('#counter').change(function () {
        cmd_line.id_lot = $('#lot').val();
        cmd_line.id_sub = $('#substation').val();
        cmd_line.id_counter = $(this).val();
        if (cmd_line.id_counter == 0) {
            delete cmd_line.id_counter;
        }
        json_get_table($('#right'), cmd_line);
        history.pushState(null, null, create_cmd(base_link, cmd_line));
    });
    $('.filtred_checkbox').on('click', function (e) {
        var checkbox_id = $(this).attr('id');
        var lot = $('#lot').val();
        if ((checkbox_id == 'dt1_en'))
            if ($('#dt1_en').prop('checked')) {
                delete cmd_line.st;
                $('#dt2_en').prop('disabled', false);
                $("#dt1").datepicker('enable');
                cmd_line.date_b = $("#dt1").datepicker().val();
                json_get_table($('#right'), cmd_line);
                history.pushState(null, null, create_cmd(base_link, cmd_line));
            }
            else {
                delete cmd_line.date_b;
                delete cmd_line.st;
                delete cmd_line.date_e;
                $('#dt2_en').prop('disabled', true);
                $('#dt2_en').prop('checked', false);
                $("#dt1").datepicker('disable');
                $("#dt2").datepicker('disable');
                json_get_table($('#right'), cmd_line);
                history.pushState(null, null, create_cmd(base_link, cmd_line));
            }
        if ((checkbox_id == 'dt2_en'))
            if ($('#dt2_en').prop('checked')) {
                delete cmd_line.st;
                $("#dt2").datepicker('enable');
                cmd_line.date_e = $("#dt2").datepicker().val();
                json_get_table($('#right'), cmd_line);
                history.pushState(null, null, create_cmd(base_link, cmd_line));
            }
            else {
                delete cmd_line.date_e;
                delete cmd_line.st;
                $("#dt2").datepicker('disable');
                json_get_table($('#right'), cmd_line);
                history.pushState(null, null, create_cmd(base_link, cmd_line));
            }
    });
    $("#dt1").datepicker({
        changeYear: true, changeMonth: true, minDate: '2016-01-01', maxDate: '0', dateFormat: 'yy-mm-dd',
        onSelect: function (dateText, inst) {
            cmd_line.date_b = dateText;
            json_get_table($('#right'), cmd_line);
        }
    });
    $("#dt2").datepicker({
        changeYear: true, changeMonth: true, minDate: '2016-01-01', maxDate: '0', dateFormat: 'yy-mm-dd',
        onSelect: function (dateText, inst) {
            cmd_line.date_e = dateText;
            json_get_table($('#right'), cmd_line);
        }
    });
    if (!$('#dt1_en').prop('checked'))
        $("#dt1").datepicker('disable');
    if (!$('#dt2_en').prop('checked'))
        $("#dt2").datepicker('disable');
    RIGHT.on('click', 'a', function (event) {
        event.preventDefault();
        var param = event.target.search;
        if (param != '') {
            var stArr = (param.substr(1)).split('&');
            for (var i = 0; i < stArr.length; i++) {
                var st = stArr[i].split('=');
                if (st[0] == 'st') {
                    if (st[1] != 0)
                        cmd_line.st = st[1];
                    else
                        delete cmd_line.st;
                }
            }
        }
        console.log(cmd_line);
        json_get_table($('#right'), cmd_line);
    });
    $(document).tooltip({
        content: function () {
            return this.getAttribute("title");
        }
    });
});
