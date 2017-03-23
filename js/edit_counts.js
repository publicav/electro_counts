"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var RenderCounter_1 = require("./RenderCounter");
$(function () {
    var RIGTH = $('#right');
    var LOT_EDIT = $('#lot_edit');
    var SUBSTATION_EDIT = $('#substation_edit');
    var ReqestData = {
        render: {},
        data: '',
        url: '',
        type: '',
        init: function (render, url, param, type) {
            if (param === void 0) { param = {}; }
            if (type === void 0) { type = 'post'; }
            this.data = param;
            this.render = render;
            this.url = url;
            this.type = type;
        },
        reqest: function () {
            var _this = this;
            var me = this;
            $.ajax({ dataType: 'json', type: me.type, url: me.url, data: me.data })
                .done(function (result) {
                console.log(result);
                _this.render.doRun(result.data);
                _this.render.render();
            })
                .fail(function (result) { return alert(result.responseJSON.error); });
        },
    };
    var renderCounter = new RenderCounter_1.RenderCounter($('#counter_edit'));
    var loadFormValue = {
        dest: {},
        init: function (dest) {
            this.dest = dest;
        },
        doRun: function (data) {
            this.dest.objLot.find('[value="' + data.lot_id + '"]').prop("selected", true);
            this.dest.objDate.val(data.date1);
            this.dest.objTime.val(data.time1);
            this.dest.objValEdit.val(data.value);
            this.dest.objId.val(data.id);
        },
        render: function () {
        }
    };
    var ObjSelected = (function () {
        function ObjSelected(objLot, objSubstation, objCounter, url_substation, url_counter) {
            this.objLot = objLot;
            this.objSubstation = objSubstation;
            this.objCounter = objCounter;
            this.url_substation = url_substation;
            this.url_counter = url_counter;
        }
        return ObjSelected;
    }());
    var objSelected = new ObjSelected(LOT_EDIT, SUBSTATION_EDIT, $('#counter_edit'), 'ajax/subst/', 'ajax/counter/');
    var objEditForm = {
        objDate: $('#date_airing_begin_edit'),
        objTime: $('#time_airing_begin_edit'),
        objValEdit: $('#counter_val_edit'),
        objId: $('#edit_id1'),
        param: {},
        __proto__: objSelected
    };
    var edit_form_actions = function (form) {
        var formActions = $(form);
        var m_method = formActions.attr('method');
        var m_action = formActions.attr('action');
        var m_data = formActions.serialize();
        $.ajax({ dataType: 'json', type: m_method, url: m_action, data: m_data })
            .done(function (result) {
            if (result.success) {
            }
            else
                alert(result.error);
        })
            .fail(function (result) { return alert(result.responseJSON.error); });
    };
    $("#date_airing_begin_edit").datepicker({ changeYear: true, dateFormat: 'dd-mm-yy' });
    $('#time_airing_begin_edit').mask('H9:M9');
    LOT_EDIT.change(function () {
        var lot = $(this).val();
        get_substation(objSelected, lot);
    });
    SUBSTATION_EDIT.change(function () {
        var substation = $(this).val();
        ReqestData.init(renderCounter, 'ajax/counter/', { data: substation }, 'get');
        ReqestData.reqest();
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
                    edit_form_actions(this);
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
        edit_form_actions(this);
        edit_form.dialog("close");
    });
    RIGTH.on('click', '.counter_str_even, .counter_str_odd', function (event) {
        var edit_id = $(this).attr('id');
        var param = { 'id': edit_id.slice(3) };
        loadFormValue.init(objEditForm);
        ReqestData.init(loadFormValue, 'ajax/loadform_value/', param);
        ReqestData.reqest();
        edit_form.dialog("open");
        event.preventDefault();
    });
});
