"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var ReqestData_1 = require("./libs/ReqestData");
var LoadFormValue_1 = require("./libs/LoadFormValue");
var ActionForm_1 = require("./libs/ActionForm");
var FormSelectValueField_1 = require("./libs/FormSelectValueField");
var MySelect_1 = require("./libs/MySelect");
var ReqestSelect_1 = require("./libs/ReqestSelect");
var RenderTablValCounter_1 = require("./libs/RenderTablValCounter");
var GeturlVar_1 = require("./libs/GeturlVar");
$(function () {
    var RIGHT = $('#right');
    var LOT_EDIT = $('#lot_edit');
    var SUBSTATION_EDIT = $('#substation_edit');
    var COUNTER_EDIT = $('#counter_edit');
    var DATE_AIRING_BEGIN_EDIT = $('#date_airing_begin_edit');
    var TIME_AIRING_BEGIN_EDIT = $('#time_airing_begin_edit');
    var objEditForm = new FormSelectValueField_1.FormSelectValueField(LOT_EDIT, SUBSTATION_EDIT, COUNTER_EDIT, DATE_AIRING_BEGIN_EDIT, TIME_AIRING_BEGIN_EDIT, $('#counter_val_edit'), $('#edit_id1'));
    var selectLot = new MySelect_1.default('lot_edit');
    selectLot.classHTML = 'input_selected';
    var selectSubs = new MySelect_1.default('substation_edit');
    selectSubs.classHTML = 'input_selected';
    var selectCount = new MySelect_1.default('counter_edit');
    selectCount.classHTML = 'input_selected';
    selectLot.render();
    selectSubs.render();
    selectCount.render();
    DATE_AIRING_BEGIN_EDIT.datepicker({ changeYear: true, dateFormat: 'dd-mm-yy' });
    $.mask.definitions['H'] = '[012]';
    $.mask.definitions['M'] = '[012345]';
    $.mask.definitions['F'] = '[0-9.]+';
    TIME_AIRING_BEGIN_EDIT.mask('H9:M9');
    $(document).on("change", '#lot_edit', function (e) {
        console.log('change lots');
        var me = e.target;
        console.log($(me).val());
        var val = $(me).val();
        var primaer = [
            { url: 'ajax/subst', 'render': selectSubs },
            { url: 'ajax/counter', 'render': selectCount },
        ];
        var req = new ReqestSelect_1.default(primaer);
        req.data = val;
        req.reqest();
    });
    $(document).on("change", '#substation_edit', function (e) {
        console.log('change subs');
        var me = e.target;
        var val = $(me).val();
        console.log(val);
        var primaer = [
            { url: 'ajax/counter', 'render': selectCount },
        ];
        var req = new ReqestSelect_1.default(primaer);
        req.data = val;
        req.reqest();
    });
    var edit_form = $("#edit_value_counts_form").dialog({
        title: "Редактирование значения счётчика",
        autoOpen: false,
        resizable: false,
        height: 350,
        width: 620,
        modal: true,
        close: function () {
            var formRes = $(this)[0];
            formRes.reset();
        },
        buttons: [
            {
                text: 'Ok',
                click: function () {
                    var editFormActions = new ActionForm_1.ActionForm(this);
                    editFormActions.doActions();
                    var right = document.getElementById('right');
                    right.innerHTML = '';
                    var table = new RenderTablValCounter_1.default();
                    table.render();
                    right.appendChild(table.elTitle);
                    right.appendChild(table.elTable);
                    right.appendChild(table.elnavigator);
                    var requstTable = new ReqestData_1.ReqestData(table, 'ajax/filterValue/', GeturlVar_1.getUrlVars1(), 'get');
                    requstTable.reqest();
                    $(this).dialog("close");
                }
            },
            {
                text: 'Cancel',
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });
    $(document).on("submit", '#edit_value_counts_form', function (event) {
        event.preventDefault();
        var editFormActions = new ActionForm_1.ActionForm(this);
        editFormActions.doActions();
        var right = document.getElementById('right');
        right.innerHTML = '';
        var table = new RenderTablValCounter_1.default();
        table.render();
        right.appendChild(table.elTitle);
        right.appendChild(table.elTable);
        right.appendChild(table.elnavigator);
        var requstTable = new ReqestData_1.ReqestData(table, 'ajax/filterValue/', GeturlVar_1.getUrlVars1(), 'get');
        requstTable.reqest();
        edit_form.dialog("close");
    });
    RIGHT.on('click', '.counter_str_even, .counter_str_odd', function (event) {
        var edit_id = $(this).attr('id');
        var param = { 'id': edit_id.slice(3) };
        var primaer = [
            { url: 'ajax/lots', 'render': selectLot },
            { url: 'ajax/subst', 'render': selectSubs },
            { url: 'ajax/counter', 'render': selectCount },
        ];
        var req = new ReqestSelect_1.default(primaer, 1);
        var loadFormVal = new LoadFormValue_1.LoadFormValue(req, objEditForm);
        var reqestLoadForm = new ReqestData_1.ReqestData(loadFormVal, 'ajax/loadform_value/', param);
        reqestLoadForm.reqest();
        console.log('Param = ', GeturlVar_1.getUrlVars1());
        edit_form.dialog("open");
        event.preventDefault();
    });
});
