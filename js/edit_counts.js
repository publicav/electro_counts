(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var ReqestData_1 = require("./libs/ReqestData");
var LoadFormValue_1 = require("./libs/LoadFormValue");
var ActionForm_1 = require("./libs/ActionForm");
var FormSelectValueField_1 = require("./libs/FormSelectValueField");
var MySelect_1 = require("./libs/MySelect");
var ReqestSelect_1 = require("./libs/ReqestSelect");
$(function () {
    var RIGTH = $('#right');
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
        edit_form.dialog("close");
    });
    RIGTH.on('click', '.counter_str_even, .counter_str_odd', function (event) {
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
        edit_form.dialog("open");
        event.preventDefault();
    });
});

},{"./libs/ActionForm":2,"./libs/FormSelectValueField":3,"./libs/LoadFormValue":4,"./libs/MySelect":5,"./libs/ReqestData":6,"./libs/ReqestSelect":7}],2:[function(require,module,exports){
"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var ActionForm = (function () {
    function ActionForm(form) {
        this._form = form;
    }
    ActionForm.prototype.doActions = function () {
        var formActions = $(this._form);
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
var LoadFormValue = (function () {
    function LoadFormValue(renderSel, dest) {
        this.renderSel = renderSel;
        this.dest = dest;
    }
    ;
    LoadFormValue.prototype.before = function () {
    };
    LoadFormValue.prototype.after = function () {
    };
    LoadFormValue.prototype.doRun = function (data) {
        this._data = data;
        this.dest.objDate.val(data.date1);
        this.dest.objTime.val(data.time1);
        this.dest.objValEdit.val(data.value);
        this.dest.objId.val(data.id);
    };
    LoadFormValue.prototype.render = function () {
        var lf = this._data;
        console.log(lf);
        var param = [{ setparam: lf.lot_id }, { setparam: lf.sub_id }, { setparam: lf.counter_id }];
        this.renderSel.param = param;
        this.renderSel.reqest();
    };
    return LoadFormValue;
}());
exports.LoadFormValue = LoadFormValue;

},{}],5:[function(require,module,exports){
"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var Select = (function () {
    function Select(idEl) {
        this.onChange = null;
        this.data = [];
        this.idEl = idEl;
        this.elSetup = document.getElementById(idEl);
        this.el = this.elSetup;
    }
    Object.defineProperty(Select.prototype, "classHTML", {
        set: function (value) {
            this._class = value;
        },
        enumerable: true,
        configurable: true
    });
    Select.prototype.setData = function (data) {
        this.data = data;
        this.render();
    };
    Select.prototype.selectByValue = function (id) {
        var _this = this;
        return !!this.el && this.data.some(function (item, index) {
            if (item.id === id) {
                _this.el.selectedIndex = index;
                return true;
            }
            return false;
        });
    };
    Select.prototype.render = function () {
        var select = document.createElement('select');
        select.setAttribute("id", this.idEl);
        select.setAttribute('name', this.idEl);
        select.setAttribute('class', this._class);
        this.data.forEach(function (item) {
            select.options.add(new Option(item.name, item.id));
        });
        if (this.el && this.el.parentNode) {
            this.el.parentNode.replaceChild(select, this.el);
        }
        this.el = select;
        return this.el;
    };
    return Select;
}());
exports.default = Select;

},{}],6:[function(require,module,exports){
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

},{}],7:[function(require,module,exports){
"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var ReqestSelect = (function () {
    function ReqestSelect(reqRender, loadForm) {
        if (loadForm === void 0) { loadForm = 0; }
        this._param = [];
        this.reqRender = reqRender;
        this.loadForm = loadForm;
        this._data = 0;
    }
    Object.defineProperty(ReqestSelect.prototype, "data", {
        set: function (value) {
            this._data = value;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(ReqestSelect.prototype, "param", {
        set: function (value) {
            this._param = value;
        },
        enumerable: true,
        configurable: true
    });
    ReqestSelect.prototype.reqest = function () {
        var _this = this;
        if (this.reqRender.length) {
            var me_1 = this.reqRender.shift();
            var param_1 = this._param.shift();
            console.log(param_1);
            $.ajax({ dataType: 'json', type: 'get', url: me_1.url, data: { 'data': this._data } })
                .done(function (result) {
                me_1.render.setData(result.data);
                if (_this.loadForm) {
                    me_1.render.selectByValue(param_1.setparam.toLocaleString());
                    _this._data = param_1.setparam;
                }
                else {
                    _this._data = result.data[0].id;
                }
                _this.reqest();
            })
                .fail(function (result) { return alert('error'); });
        }
    };
    return ReqestSelect;
}());
exports.ReqestSelect = ReqestSelect;
exports.default = ReqestSelect;

},{}]},{},[1]);
