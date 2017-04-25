(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var GeturlVar_1 = require("./libs/GeturlVar");
var MySelect_1 = require("./libs/MySelect");
var ReqestSelectLastVal_1 = require("./libs/ReqestSelectLastVal");
$(function () {
    var gl_add_counts = 0, buttonpressed;
    var edit_arr = [];
    var objSelected = {
        objLot: $('#lot'),
        objSubstation: $('#substation'),
        objCounter: $('#counter'),
        objCounterLastVal: $('#counter_last_val'),
        url_substation: 'ajax/subst/',
        url_counter: 'ajax/counter/',
        editCounter: 0
    };
    var cmd_line = GeturlVar_1.getUrlVars1();
    var ADD_COUNTER_BTN_NAME = 'ok_f', EDIT_COUNTER_BTN_NAME = 'edit_f';
    var find_arr_id = function (arr, find_id) {
        var ret = -1;
        for (var i = 0; i < arr.length; i++)
            if (arr[i].id == find_id) {
                ret = i;
                break;
            }
        return ret;
    };
    var get_last_val = function (_a) {
        var objCounterLastVal = _a.objCounterLastVal, param = _a.param;
        $.ajax({ dataType: 'json', type: 'post', url: 'ajax/lastvalue_counter/', data: param })
            .done(function (result) {
            var data = result.data;
            objCounterLastVal.val(data.value);
        })
            .fail(function (result) { return alert('Error'); });
    };
    var print_add_record = function (_a) {
        var name_lot = _a.name_lot, name_substation = _a.name_substation, name_counter = _a.name_counter, date = _a.date, time = _a.time, value = _a.value, id = _a.id;
        return "\n\t\t\t<div class=\"col_lots\">" + name_lot + "</div>\n\t\t\t<div class=\"col_substation\">" + name_substation + "</div> \n\t\t\t<div class=\"col_counts\">" + name_counter + "</div> \n\t\t\t<div class=\"col_date\">" + date + " " + time + "</div> \n\t\t\t<div class=\"col_value\">" + value + "</div> \n\t\t\t<a id=\"" + id + "\">\u041F\u0440\u0430\u0432\u043A\u0430</a>\t\n\t\t\t";
    };
    var add_form_actions = function (_a) {
        var form = _a.form, objLot = _a.objLot, objSubstation = _a.objSubstation, objCounter = _a.objCounter, objBtnOk = _a.objBtnOk, objBtnEdit = _a.objBtnEdit, objListRec = _a.objListRec, btnPress = _a.btnPress, gl_add_counts = _a.gl_add_counts, edit_arr = _a.edit_arr;
        var lot = objLot.val();
        var substation = objSubstation.val();
        var counts = objCounter.val();
        var m_method = $(form).attr('method');
        var m_action = $(form).attr('action');
        var m_data = $(form).serialize();
        m_data += "&lot=" + lot + "&counter=" + counts + "&substation=" + substation;
        if (btnPress.id == ADD_COUNTER_BTN_NAME)
            m_data += '&actions=add';
        if (btnPress.id == EDIT_COUNTER_BTN_NAME)
            m_data += '&actions=edit';
        $.ajax({ dataType: 'json', type: m_method, url: m_action, data: m_data })
            .done(function (result) {
            if (result.success) {
                var data = result.data;
                gl_add_counts++;
                var row_edit = print_add_record(data);
                var row_add = "<li>" + row_edit + "</li>";
                if (btnPress.id == ADD_COUNTER_BTN_NAME)
                    ok_btn(data, row_add);
                if (btnPress.id == EDIT_COUNTER_BTN_NAME)
                    edit_btn(data, row_edit);
            }
            else
                alert(result.error);
        })
            .fail(function (result) { return alert(result.responseJSON.error); });
        var ok_btn = function (data, row_add) {
            if (gl_add_counts <= 10) {
                edit_arr.unshift(data);
                objListRec.prepend(row_add);
            }
            else {
                edit_arr.unshift(data);
                edit_arr.pop();
                objListRec.find('li:last').remove();
                objListRec.prepend(row_add);
            }
        };
        var edit_btn = function (data, row_edit) {
            var index = find_arr_id(edit_arr, data.id);
            edit_arr[index] = data;
            objBtnOk.button("option", "disabled", false);
            objBtnEdit.button("option", "disabled", true);
            objListRec.find('li:nth-child(' + (index + 1) + ')').html(row_edit);
        };
    };
    var filter = [];
    var zero = 1;
    if ('id_lot' in cmd_line) {
        filter.push({ setparam: cmd_line.id_lot });
    }
    else {
        filter.push({ setparam: zero });
    }
    if ('id_sub' in cmd_line) {
        filter.push({ setparam: cmd_line.id_sub });
    }
    else {
        filter.push({ setparam: zero });
    }
    if ('id_counter' in cmd_line) {
        filter.push({ setparam: cmd_line.id_counter });
    }
    else {
        filter.push({ setparam: zero });
    }
    console.log('cmd array ->', cmd_line);
    console.log('filter ->', filter);
    var selectLot = new MySelect_1.default('lot');
    selectLot.classHTML = 'input_selected';
    var selectSubs = new MySelect_1.default('substation');
    selectSubs.classHTML = 'input_selected';
    var selectCount = new MySelect_1.default('counter');
    selectCount.classHTML = 'input_selected';
    selectLot.render();
    selectSubs.render();
    selectCount.render();
    var dependentFilters = [
        { url: 'ajax/lots', 'render': selectLot },
        { url: 'ajax/subst', 'render': selectSubs },
        { url: 'ajax/counter', 'render': selectCount },
    ];
    var req = new ReqestSelectLastVal_1.ReqestSelectLastVal(dependentFilters, 1);
    req.lastEl = $('#counter_last_val');
    req.param = filter;
    req.reqestMod();
    console.log('Param = ', GeturlVar_1.getUrlVars1());
    $('#date_airing_begin').datepicker({ changeYear: true, dateFormat: 'dd-mm-yy' });
    $.mask.definitions['H'] = '[012]';
    $.mask.definitions['M'] = '[012345]';
    $.mask.definitions['F'] = '[0-9.]+';
    $('#time_airing_begin').mask('H9:M9');
    console.log(objSelected);
    $(document).on("change", '#lot', function (e) {
        console.log('change lots');
        var me = e.target;
        console.log($(me).val());
        var val = $(me).val();
        var primaer = [
            { url: 'ajax/subst', 'render': selectSubs },
            { url: 'ajax/counter', 'render': selectCount },
        ];
        var req = new ReqestSelectLastVal_1.ReqestSelectLastVal(primaer);
        req.lastEl = $('#counter_last_val');
        req.data = val;
        req.reqestMod();
        var counter = objSelected.objCounter.val();
    });
    $(document).on("change", '#substation', function (e) {
        console.log('change subs');
        var me = e.target;
        var val = $(me).val();
        console.log(val);
        var primaer = [
            { url: 'ajax/counter', 'render': selectCount },
        ];
        var req = new ReqestSelectLastVal_1.ReqestSelectLastVal(primaer);
        req.lastEl = $('#counter_last_val');
        req.data = val;
        req.reqestMod();
        $('#counter_val').val('');
    });
    $(document).on("change", '#counter', function (e) {
        var me = e.target;
        var val = $(me).val();
        console.log(val);
        $('#counter_val').val('');
    });
    $('#counter_val').keydown(function (event) {
        if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 ||
            (event.keyCode == 65 && event.ctrlKey === true) || (event.keyCode == 188) || (event.keyCode == 190) ||
            (event.keyCode == 116 && event.ctrlKey === true) || (event.keyCode == 110) ||
            (event.keyCode >= 35 && event.keyCode <= 39)) {
            return;
        }
        else {
            if ((event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
                event.preventDefault();
            }
        }
    });
    $('#counter_val').keyup(function () {
        var counterVal = $(this).val();
        var counterLastVal = $('#counter_last_val').val();
        if (objSelected.editCounter == 0) {
            if (counterVal.length > 0) {
                counterVal = counterVal.replace(',', '.');
                var dtVal = +counterVal - +counterLastVal;
                if (dtVal >= 0) {
                    $(this).removeClass('bad_cell').addClass('good_cell');
                }
                else {
                    $(this).removeClass('good_cell').addClass('bad_cell');
                }
                console.log('This - > ', counterVal, typeof (counterVal), dtVal);
            }
        }
        else
            $('#counter_last_val').removeClass('good_cell').removeClass('bad_cell').addClass('norm_cell');
    });
    $('#list_counts').on('click', 'a', function (event) {
        var arr_id = $(this).attr('id');
        var index = find_arr_id(edit_arr, arr_id);
        var lot_value = edit_arr[index].lot;
        var substation_value = edit_arr[index].substation;
        var couner_value = edit_arr[index].counter;
        objSelected.editCounter = 1;
        $('#counter_last_val').val('');
        $('#counter_val').removeClass('good_cell').removeClass('bad_cell').addClass('norm_cell');
        $('#date_airing_begin').val(edit_arr[index].date);
        $('#time_airing_begin').val(edit_arr[index].time);
        $('#counter_val').val(edit_arr[index].value);
        $('#edit_id').val(arr_id);
        $('#ok_f').button("option", "disabled", true);
        $('#edit_f').button("option", "disabled", false);
        event.preventDefault();
    });
    $('input[type=submit], a, button').button().click(function () {
        buttonpressed = $(this).attr('id');
    });
    $('#add_value_counts_form').submit(function (event) {
        event.preventDefault();
        var me = this;
        var btn = { id: buttonpressed };
        buttonpressed = '';
        var obj = {
            form: me,
            objBtnOk: $('#ok_f'),
            objBtnEdit: $('#edit_f'),
            btnPress: btn,
            objListRec: $('#list_counts'),
            gl_add_counts: gl_add_counts,
            edit_arr: edit_arr,
            __proto__: objSelected
        };
        objSelected.editCounter = 0;
    });
});

},{"./libs/GeturlVar":2,"./libs/MySelect":3,"./libs/ReqestSelectLastVal":5}],2:[function(require,module,exports){
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
function nameUrl(path) {
    path = path.substring(path.lastIndexOf("/") + 1);
    return (path.match(/[^.]+(\.[^?#]+)?/) || [])[0];
}
exports.nameUrl = nameUrl;

},{}],3:[function(require,module,exports){
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

},{}],4:[function(require,module,exports){
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
        get: function () {
            return this._data;
        },
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

},{}],5:[function(require,module,exports){
"use strict";
var __extends = (this && this.__extends) || (function () {
    var extendStatics = Object.setPrototypeOf ||
        ({ __proto__: [] } instanceof Array && function (d, b) { d.__proto__ = b; }) ||
        function (d, b) { for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p]; };
    return function (d, b) {
        extendStatics(d, b);
        function __() { this.constructor = d; }
        d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
    };
})();
Object.defineProperty(exports, "__esModule", { value: true });
var ReqestSelect_1 = require("./ReqestSelect");
var ReqestSelectLastVal = (function (_super) {
    __extends(ReqestSelectLastVal, _super);
    function ReqestSelectLastVal() {
        return _super !== null && _super.apply(this, arguments) || this;
    }
    Object.defineProperty(ReqestSelectLastVal.prototype, "lastEl", {
        set: function (value) {
            this._lastEl = value;
        },
        enumerable: true,
        configurable: true
    });
    ReqestSelectLastVal.prototype.get_last_val = function () {
        var _this = this;
        $.ajax({ dataType: 'json', type: 'post', url: 'ajax/lastvalue_counter/', data: { 'counter': this.data } })
            .done(function (result) {
            var data = result.data;
            _this._lastEl.val(data.value);
        })
            .fail(function (result) { return alert('Error'); });
    };
    ;
    ReqestSelectLastVal.prototype.reqestMod = function () {
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
                if (_this.reqRender.length == 1)
                    _this.get_last_val();
                console.log('размер массива', _this.reqRender.length);
                _this.reqestMod();
            })
                .fail(function (result) { return alert('error'); });
        }
    };
    return ReqestSelectLastVal;
}(ReqestSelect_1.default));
exports.ReqestSelectLastVal = ReqestSelectLastVal;
exports.default = ReqestSelectLastVal;

},{"./ReqestSelect":4}]},{},[1]);
