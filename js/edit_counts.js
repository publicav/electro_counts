(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
module.exports=﻿[
  {
    "class": "title_lots",
    "name": "Участок"
  },
  {
    "class": "title_substation",
    "name": "Подстанция"
  },
  {
    "class": "title_counts",
    "name": "Ячейка"
  },
  {
    "class": "title_date",
    "name": "Дата"
  },
  {
    "class": "title_value",
    "name": "Значение"
  }
]
},{}],2:[function(require,module,exports){
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
    var form = $('#edit_value_counts_form');
    var RIGHT = $('#right');
    var LOT_EDIT = $('#lot_edit');
    var SUBSTATION_EDIT = $('#substation_edit');
    var COUNTER_EDIT = $('#counter_edit');
    var DATE_AIRING_BEGIN_EDIT = $('#date_airing_begin_edit');
    var TIME_AIRING_BEGIN_EDIT = $('#time_airing_begin_edit');
    var objEditForm = new FormSelectValueField_1.FormSelectValueField(LOT_EDIT, SUBSTATION_EDIT, COUNTER_EDIT, DATE_AIRING_BEGIN_EDIT, TIME_AIRING_BEGIN_EDIT, $('#counter_val_edit'), $('#edit_id1'));
    var selectLot = new MySelect_1.default('lot_edit');
    var selectSubs = new MySelect_1.default('substation_edit');
    var selectCount = new MySelect_1.default('counter_edit');
    DATE_AIRING_BEGIN_EDIT.datepicker({ changeYear: true, dateFormat: 'dd-mm-yy' });
    $.mask.definitions['H'] = '[012]';
    $.mask.definitions['M'] = '[012345]';
    $.mask.definitions['F'] = '[0-9.]+';
    TIME_AIRING_BEGIN_EDIT.mask('H9:M9');
    $.fn.select2.defaults.set("theme", "classic");
    $(document).on("change", '#lot_edit', function (e) {
        console.log('change lots');
        var me = e.target;
        console.log($(me).val());
        var val = $(me).val();
        var primaer = [
            { url: 'ajax/subst', 'render': selectSubs },
            { url: 'ajax/counter', 'render': selectCount },
        ];
    });
    $(document).on("change", '#substation_edit', function (e) {
        console.log('change subs');
        var me = e.target;
        var val = $(me).val();
        console.log(val);
        var primaer = [
            { url: 'ajax/counter', 'render': selectCount },
        ];
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

},{"./libs/ActionForm":3,"./libs/FormSelectValueField":4,"./libs/GeturlVar":5,"./libs/LoadFormValue":6,"./libs/MySelect":7,"./libs/RenderTablValCounter":8,"./libs/ReqestData":9,"./libs/ReqestSelect":10}],3:[function(require,module,exports){
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

},{}],4:[function(require,module,exports){
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

},{}],5:[function(require,module,exports){
"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var getUrlVars1 = function () {
    var vars = {}, hash;
    if (location.search) {
        var hashes = (location.search.substr(1)).split('&');
        for (var i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            vars[hash[0]] = hash[1];
        }
    }
    return vars;
};
exports.getUrlVars1 = getUrlVars1;

},{}],6:[function(require,module,exports){
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

},{}],7:[function(require,module,exports){
"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var Select = (function () {
    function Select(idEl) {
        this.onChange = null;
        this.data = [];
        this.idEl = idEl;
        this.elSetup = document.getElementById(idEl);
        this.elSelect2 = $(this.elSetup);
        this.elSelect2.select2({
            MinimumResultsForSearch: Infinity
        });
        this.oneRun = null;
    }
    Object.defineProperty(Select.prototype, "classHTML", {
        set: function (value) {
            this._class = value;
        },
        enumerable: true,
        configurable: true
    });
    Select.prototype.setData = function (data) {
        var dataSrc = [];
        for (var _i = 0, data_1 = data; _i < data_1.length; _i++) {
            var row = data_1[_i];
            dataSrc.push({
                id: row.id,
                text: row.name
            });
        }
        this.data = data;
        this.elSelect2.select2({
            data: dataSrc
        });
        this.render();
    };
    Select.prototype.selectByValue = function (id) {
        this.elSelect2.select2('val', id);
    };
    Select.prototype.render = function () {
    };
    return Select;
}());
exports.default = Select;

},{}],8:[function(require,module,exports){
"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var RenderTablValCounter = (function () {
    function RenderTablValCounter() {
        this._elTitle = null;
        this._elTable = null;
        this._elnavigator = null;
        console.log('RenderTablValCounter');
        this.title = require('./../../json/title-tabl-counter.json');
    }
    Object.defineProperty(RenderTablValCounter.prototype, "elnavigator", {
        get: function () {
            return this._elnavigator;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(RenderTablValCounter.prototype, "elTable", {
        get: function () {
            return this._elTable;
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(RenderTablValCounter.prototype, "elTitle", {
        get: function () {
            return this._elTitle;
        },
        enumerable: true,
        configurable: true
    });
    RenderTablValCounter.prototype.titleRender = function () {
        var divMain = document.createElement('div');
        divMain.setAttribute('class', 'title_table_counter');
        for (var _i = 0, _a = this.title; _i < _a.length; _i++) {
            var row = _a[_i];
            var div = document.createElement('div');
            div.setAttribute('class', row.class);
            div.innerHTML = row.name;
            divMain.appendChild(div);
        }
        if (this._elTitle && this._elTitle.parentNode) {
            this._elTitle.parentNode.replaceChild(divMain, this._elTitle);
        }
        this._elTitle = divMain;
    };
    RenderTablValCounter.prototype.navigationRender = function () {
        var divNavig = document.createElement('div');
        divNavig.setAttribute('class', 'navigator');
        if (this._elnavigator != null) {
            var nav = this.navigator;
            var page = nav.page;
            var span = '';
            var pNavig = document.createElement('p');
            for (var _i = 0, page_1 = page; _i < page_1.length; _i++) {
                var row = page_1[_i];
                if (row.st == null) {
                    span = "<span class=\"pagecurrent\">" + row.text + "</span>";
                }
                else {
                    span = "<span class=\"pagelink\"><a href=\"" + nav.file + "?st=" + row.st + nav.paramUrl + "\" title=\"" + row.title + "\">" + row.text + "</a></span>";
                }
                pNavig.innerHTML += span;
            }
            divNavig.appendChild(pNavig);
        }
        if (this._elnavigator && this._elnavigator.parentNode) {
            this._elnavigator.parentNode.replaceChild(divNavig, this._elnavigator);
        }
        this._elnavigator = divNavig;
    };
    RenderTablValCounter.prototype.after = function () {
    };
    RenderTablValCounter.prototype.before = function () {
    };
    RenderTablValCounter.prototype.doRun = function (data) {
        this.navigator = data.navigationData;
        this.table = data.counter;
    };
    RenderTablValCounter.prototype.tableRender = function () {
        var divMain = document.createElement('div');
        if (this._elTable != null) {
            var tabl = this.table;
            var count = 0;
            var class_e = void 0;
            var st = void 0;
            for (var _i = 0, tabl_1 = tabl; _i < tabl_1.length; _i++) {
                var row = tabl_1[_i];
                if (count % 2 != 0)
                    class_e = 'counter_str_odd';
                else
                    class_e = 'counter_str_even';
                var divRow = document.createElement('div');
                divRow.setAttribute('class', class_e);
                divRow.setAttribute('id', "id_" + row.id);
                divRow.setAttribute('title', "\u0412\u0432\u043E\u0434 - <b>" + row.name_user + "</b>");
                st = "<div class=\"col_lots\">" + row.lot + "</div>\n\t\t\t\t   <div class=\"col_substation\">" + row.substation + "</div>\n\t\t\t\t   <div class=\"col_counts\">" + row.counter + "</div>\n                   <div class=\"col_date\">" + row.date1 + "</div>\n                   <div class=\"col_value\">" + row.value + "</div>\n\t\t\t    ";
                divRow.innerHTML = st;
                count++;
                divMain.appendChild(divRow);
            }
        }
        if (this._elTable && this._elTable.parentNode) {
            this._elTable.parentNode.replaceChild(divMain, this._elTable);
        }
        this._elTable = divMain;
    };
    RenderTablValCounter.prototype.render = function () {
        this.titleRender();
        this.tableRender();
        this.navigationRender();
    };
    return RenderTablValCounter;
}());
exports.default = RenderTablValCounter;

},{"./../../json/title-tabl-counter.json":1}],9:[function(require,module,exports){
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

},{}],10:[function(require,module,exports){
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
                console.log('Count = ', _this._counter);
                _this.reqest();
            })
                .fail(function (result) { return alert('error'); });
        }
    };
    return ReqestSelect;
}());
exports.ReqestSelect = ReqestSelect;
exports.default = ReqestSelect;

},{}]},{},[2]);
