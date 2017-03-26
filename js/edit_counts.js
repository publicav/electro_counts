(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var RenderCounter_1 = require("./libs/RenderCounter");
var RenderSubstation_1 = require("./libs/RenderSubstation");
var ReqestData_1 = require("./libs/ReqestData");
var LoadFormValue_1 = require("./libs/LoadFormValue");
var ActionForm_1 = require("./libs/ActionForm");
var FormSelectValueField_1 = require("./libs/FormSelectValueField");
$(function () {
    var RIGTH = $('#right');
    var LOT_EDIT = $('#lot_edit');
    var SUBSTATION_EDIT = $('#substation_edit');
    var COUNTER_EDIT = $('#counter_edit');
    var DATE_AIRING_BEGIN_EDIT = $('#date_airing_begin_edit');
    var TIME_AIRING_BEGIN_EDIT = $('#time_airing_begin_edit');
    var renderCounter = new RenderCounter_1.RenderCounter(COUNTER_EDIT);
    var renderSubststion = new RenderSubstation_1.RenderSubstation(SUBSTATION_EDIT, renderCounter);
    var objEditForm = new FormSelectValueField_1.FormSelectValueField(LOT_EDIT, SUBSTATION_EDIT, COUNTER_EDIT, DATE_AIRING_BEGIN_EDIT, TIME_AIRING_BEGIN_EDIT, $('#counter_val_edit'), $('#edit_id1'));
    DATE_AIRING_BEGIN_EDIT.datepicker({ changeYear: true, dateFormat: 'dd-mm-yy' });
    $.mask.definitions['H'] = '[012]';
    $.mask.definitions['M'] = '[012345]';
    $.mask.definitions['F'] = '[0-9.]+';
    TIME_AIRING_BEGIN_EDIT.mask('H9:M9');
    LOT_EDIT.change(function () {
        var lot = $(this).val();
        renderSubststion.Value1 = 0;
        var ReqestLot = new ReqestData_1.ReqestData(renderSubststion, 'ajax/subst/', { data: lot }, 'get');
        ReqestLot.reqest();
    });
    SUBSTATION_EDIT.change(function () {
        var substation = $(this).val();
        var ReqestSubstation = new ReqestData_1.ReqestData(renderCounter, 'ajax/counter/', { data: substation }, 'get');
        ReqestSubstation.reqest();
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
                    editFormActions.setModeAction = 'edit';
                    editFormActions.doActions();
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
        editFormActions.setModeAction = 'edit';
        editFormActions.doActions();
        edit_form.dialog("close");
    });
    RIGTH.on('click', '.counter_str_even, .counter_str_odd', function (event) {
        var edit_id = $(this).attr('id');
        var param = { 'id': edit_id.slice(3) };
        var loadFormVal = new LoadFormValue_1.LoadFormValue(renderSubststion, objEditForm);
        var reqestLoadForm = new ReqestData_1.ReqestData(loadFormVal, 'ajax/loadform_value/', param);
        reqestLoadForm.reqest();
        edit_form.dialog("open");
        event.preventDefault();
    });
});

},{"./libs/ActionForm":2,"./libs/FormSelectValueField":3,"./libs/LoadFormValue":4,"./libs/RenderCounter":5,"./libs/RenderSubstation":6,"./libs/ReqestData":7}],2:[function(require,module,exports){
"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var ActionForm = (function () {
    function ActionForm(form) {
        this._modeAction = '';
        this._form = form;
    }
    Object.defineProperty(ActionForm.prototype, "setModeAction", {
        set: function (action) {
            this._modeAction = action;
        },
        enumerable: true,
        configurable: true
    });
    ActionForm.prototype.doActions = function () {
        var formActions = $(this._form);
        var m_method = formActions.attr('method');
        var m_action = formActions.attr('action');
        var m_data = formActions.serialize();
        if (this._modeAction != '')
            m_data += "&actions=" + this._modeAction;
        $.ajax({ dataType: 'json', type: m_method, url: m_action, data: m_data })
            .done(function (result) {
            if (result.success) {
            }
            else
                alert(result.error);
        })
            .fail(function (result) { return alert(result.responseJSON.error); });
    };
    return ActionForm;
}());
exports.ActionForm = ActionForm;

},{}],3:[function(require,module,exports){
"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var FormSelectValueField = (function () {
    function FormSelectValueField(objLot, objSubstation, objCounter, objDate, objTime, objValEdit, objId) {
        this.objLot = objLot;
        this.objSubstation = objSubstation;
        this.objCounter = objCounter;
        this.objDate = objDate;
        this.objTime = objTime;
        this.objValEdit = objValEdit;
        this.objId = objId;
    }
    return FormSelectValueField;
}());
exports.FormSelectValueField = FormSelectValueField;

},{}],4:[function(require,module,exports){
"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var ReqestData_1 = require("./ReqestData");
var LoadFormValue = (function () {
    function LoadFormValue(renderSubstation, dest) {
        this.renderSubstation = renderSubstation;
        this.dest = dest;
    }
    ;
    LoadFormValue.prototype.before = function () {
    };
    LoadFormValue.prototype.after = function () {
    };
    LoadFormValue.prototype.doRun = function (data) {
        this.data = data;
        this.dest.objLot.find('[value="' + data.lot_id + '"]').prop("selected", true);
        this.dest.objDate.val(data.date1);
        this.dest.objTime.val(data.time1);
        this.dest.objValEdit.val(data.value);
        this.dest.objId.val(data.id);
    };
    LoadFormValue.prototype.render = function () {
        var value = this.data.lot_id;
        if (value != 0) {
            this.renderSubstation.Value1 = this.data.sub_id;
            this.renderSubstation.valuecounter = this.data.counter_id;
        }
        console.log('Test subst = ', this.renderSubstation.Value);
        console.log("Lot = ", value, "Substation = ", this.data.sub_id);
        var ReqestSubstation = new ReqestData_1.ReqestData(this.renderSubstation, 'ajax/subst/', { data: value }, 'get');
        ReqestSubstation.reqest();
    };
    return LoadFormValue;
}());
exports.LoadFormValue = LoadFormValue;

},{"./ReqestData":7}],5:[function(require,module,exports){
"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var RenderCounter = (function () {
    function RenderCounter(dest, value) {
        if (value === void 0) { value = 0; }
        this._value = 0;
        this.dest = dest;
        this._value = value;
    }
    ;
    Object.defineProperty(RenderCounter.prototype, "Value", {
        set: function (value) {
            this._value = value;
        },
        enumerable: true,
        configurable: true
    });
    RenderCounter.prototype.before = function () {
        this.dest.prop('disabled', true);
        this.dest.html('<option>загрузка...</option>');
    };
    RenderCounter.prototype.after = function () {
        this.dest.prop('disabled', false);
    };
    RenderCounter.prototype.doRun = function (data) {
        var options = '';
        $(data).each(function () {
            options += '<option value="' + $(this).attr('id') + '">' + $(this).attr('name') + '</option>';
        });
        this.html = options;
    };
    RenderCounter.prototype.render = function () {
        var out = this.dest;
        var value = this._value;
        out.html(this.html);
        if (value != 0)
            out.find('[value="' + value + '"]').prop("selected", true);
    };
    return RenderCounter;
}());
exports.RenderCounter = RenderCounter;

},{}],6:[function(require,module,exports){
"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var ReqestData_1 = require("./ReqestData");
var RenderSubstation = (function () {
    function RenderSubstation(dest, renderCounter, value) {
        if (value === void 0) { value = 0; }
        this._valuecounter = 0;
        this.dest = dest;
        this.renderCounter = renderCounter;
        this._value = value;
    }
    ;
    Object.defineProperty(RenderSubstation.prototype, "Value1", {
        set: function (value) {
            this._value = value;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(RenderSubstation.prototype, "valuecounter", {
        set: function (value) {
            this._valuecounter = value;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(RenderSubstation.prototype, "Value", {
        get: function () {
            return this._value;
        },
        enumerable: true,
        configurable: true
    });
    RenderSubstation.prototype.before = function () {
        this.dest.prop('disabled', true);
        this.dest.html('<option>загрузка...</option>');
    };
    RenderSubstation.prototype.after = function () {
        this.dest.prop('disabled', false);
    };
    RenderSubstation.prototype.doRun = function (data) {
        this.data = data;
        var options = '';
        $(data).each(function () {
            options += '<option value="' + $(this).attr('id') + '">' + $(this).attr('name') + '</option>';
        });
        this.html = options;
    };
    RenderSubstation.prototype.render = function () {
        var out = this.dest;
        var value = this._value;
        out.html(this.html);
        if (value != 0) {
            out.prop('disabled', true);
            out.find('[value="' + value + '"]').prop("selected", true);
            this.renderCounter.Value = this._valuecounter;
        }
        else {
            this.renderCounter.Value = 0;
            value = this.data[0].id;
        }
        console.log('Substation = ', this._value);
        var ReqestCount = new ReqestData_1.ReqestData(this.renderCounter, 'ajax/counter/', { data: value }, 'get');
        ReqestCount.reqest();
    };
    return RenderSubstation;
}());
exports.RenderSubstation = RenderSubstation;

},{"./ReqestData":7}],7:[function(require,module,exports){
"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var ReqestData = (function () {
    function ReqestData(render, url, param, type) {
        if (param === void 0) { param = {}; }
        if (type === void 0) { type = 'post'; }
        this.data = {};
        this.url = '';
        this.type = '';
        this.data = param;
        this.render = render;
        this.url = url;
        this.type = type;
    }
    ReqestData.prototype.reqest = function () {
        var me = this;
        me.render.before();
        $.ajax({ dataType: 'json', type: me.type, url: me.url, data: me.data })
            .done(function (result) {
            console.log(result);
            me.render.doRun(result.data);
            me.render.render();
            me.render.after();
        })
            .fail(function (result) { return alert('error'); });
    };
    return ReqestData;
}());
exports.ReqestData = ReqestData;

},{}]},{},[1]);
