(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var GeturlVar_1 = require("./libs/GeturlVar");
var MySelect_1 = require("./libs/MySelect");
var ReqestSelect_1 = require("./libs/ReqestSelect");
$(function () {
    var RIGHT = $('#right');
    var dt1 = $("#dt1");
    var dt2 = $("#dt2");
    var dt1_en = $("#dt1_en");
    var dt2_en = $("#dt2_en");
    var BASENAME = GeturlVar_1.nameUrl(window.location.pathname);
    var cmd_line = GeturlVar_1.getUrlVars1();
    var print_t_calc = function (data) {
        var count = 0, class_e;
        var title = data.title;
        var counter = data.Data;
        var st = "\t<div class=\"title_table_counter\">\n\t\t\t\t\t<div class=\"title_calc_counter\">\u042F\u0447\u0435\u0439\u043A\u0430</div>\n\t\t\t\t\t<div class=\"title_calc_date\">\u0414\u0430\u0442\u0430</div>\n\t\t\t\t\t<div class=\"title_calc_value\">\u0417\u043D\u0430\u0447\u0435\u043D\u0438\u0435</div>\n\t\t\t\t</div>";
        for (var key in counter) {
            if (count % 2 != 0)
                class_e = 'counter_str_odd';
            else
                class_e = 'counter_str_even';
            if (counter[key].rare < 0)
                class_e = 'counter_str_err';
            st += "\t<div class=\"" + class_e + "\" title=\"\u0420\u0430\u0441\u0447\u0451\u0442\">\n\t\t\t\t\t<div class=\"colum_calc_counter\">" + title + "</div>\n\t\t\t\t\t<div class=\"colum_calc_date\">" + counter[key][0] + "</div>\n\t\t\t\t\t<div class=\"colum_calc_value\">" + counter[key][1] + "</div>\n\t\t\t\t</div>";
            count++;
        }
        return st;
    };
    var json_get_t_calc = function (objTarget, cmd_line) {
        $.ajax({ dataType: 'json', type: 'get', url: 'ajax/calculation_counter/', data: cmd_line })
            .done(function (result) {
            if (result.success) {
                objTarget.html(print_t_calc(result));
                objTarget.append(result.navigator);
                history.replaceState(cmd_line, '', BASENAME + '?' + $.param(cmd_line));
            }
            else
                alert(result.error);
        })
            .fail(function (result) { return alert('Error'); });
    };
    var selectLot = new MySelect_1.default('lot');
    selectLot.classHTML = 'filtred_selected';
    var selectSubs = new MySelect_1.default('substation');
    selectSubs.classHTML = 'filtred_selected';
    var selectCount = new MySelect_1.default('counter');
    selectCount.classHTML = 'filtred_selected';
    selectLot.render();
    selectSubs.render();
    selectCount.render();
    var filter = [];
    var zero = 0;
    json_get_t_calc(RIGHT, cmd_line);
    $.datepicker.setDefaults($.extend($.datepicker.regional["ru"]));
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
    var dependentFilters = [
        { url: 'ajax/lots_filter', 'render': selectLot },
        { url: 'ajax/subst_filter', 'render': selectSubs },
        { url: 'ajax/counter_filter', 'render': selectCount },
    ];
    console.log(filter, dependentFilters);
    var req = new ReqestSelect_1.ReqestSelect(dependentFilters, 1);
    req.param = filter;
    req.reqest();
    $(document).on("change", '#lot', function (e) {
        console.log('change lots');
        var me = e.target;
        console.log($(me).val());
        var val = $(me).val();
        cmd_line.id_lot = val;
        if (val == 0) {
            delete cmd_line.id_lot;
            delete cmd_line.id_sub;
            delete cmd_line.id_counter;
            delete cmd_line.date_b;
        }
        else {
            delete cmd_line.date_b;
            delete cmd_line.id_sub;
            delete cmd_line.id_counter;
            $('#substation').prop('disabled', false);
        }
        console.log(cmd_line);
        var primaer = [
            { url: 'ajax/subst_filter', 'render': selectSubs },
            { url: 'ajax/counter_filter', 'render': selectCount },
        ];
        var req = new ReqestSelect_1.ReqestSelect(primaer);
        req.data = val;
        req.reqest();
        json_get_t_calc(RIGHT, cmd_line);
    });
    $(document).on("change", '#substation', function (e) {
        console.log('change subs');
        var me = e.target;
        var val = $(me).val();
        var lot = $('#lot').val();
        console.log(val);
        cmd_line.id_lot = lot;
        cmd_line.id_sub = val;
        if (val == 0) {
            delete cmd_line.id_sub;
            delete cmd_line.id_counter;
            delete cmd_line.date_b;
        }
        else {
            delete cmd_line.date_b;
            delete cmd_line.id_counter;
        }
        var primaer = [
            { url: 'ajax/counter_filter', 'render': selectCount },
        ];
        var req = new ReqestSelect_1.ReqestSelect(primaer);
        req.data = val;
        req.reqest();
        json_get_t_calc(RIGHT, cmd_line);
    });
    $(document).on("change", '#counter', function (e) {
        console.log('change counter');
        cmd_line.id_lot = $('#lot').val();
        cmd_line.id_sub = $('#substation').val();
        var me = e.target;
        var val = $(me).val();
        cmd_line.id_counter = val;
        console.log(val);
        if (cmd_line.id_counter == 0) {
            delete cmd_line.id_counter;
        }
        json_get_t_calc(RIGHT, cmd_line);
    });
    RIGHT.on('click', 'a', function (event) {
        event.preventDefault();
        var paramAll, param;
        var paramStr = event.target;
        paramAll = $(paramStr).attr('href');
        paramAll = paramAll.split('?');
        param = '?' + paramAll[1];
        console.log(param);
        if (param != '') {
            var stArr = (param.substr(1)).split('&');
            console.log(stArr);
            for (var i = 0; i < stArr.length; i++) {
                var st = stArr[i].split('=');
                if (st[0] == 'date_b') {
                    console.log(st[0]);
                    if (st[1] != 0)
                        cmd_line.date_b = st[1];
                    else
                        delete cmd_line.date_b;
                    break;
                }
            }
        }
        console.log(cmd_line);
        json_get_t_calc(RIGHT, cmd_line);
    });
    $('#edit_count').on('click', function (e) {
        var mount = ['31', '28', '31', '30', '31', '30', '31', '31', '30', '31', '30', '31'];
        var param = cmd_line;
        if ('date_b' in cmd_line) {
            var dtBg = cmd_line.date_b;
            var dtArr = dtBg.split('-');
            if (!(Number(dtArr[0]) % 4))
                mount[1] = '29';
            param.date_e = dtArr[0] + '-' + dtArr[1] + '-' + mount[Number(dtArr[1]) - 1];
            param.date_b = dtArr[0] + '-' + dtArr[1] + '-' + '01';
            console.log(param);
        }
        window.location.href = $('#edit_count').attr('href') + '?' + $.param(param);
        e.preventDefault();
    });
    $(document).tooltip({
        content: function () {
            return this.getAttribute("title");
        }
    });
});

},{"./libs/GeturlVar":2,"./libs/MySelect":3,"./libs/ReqestSelect":4}],2:[function(require,module,exports){
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

},{}]},{},[1]);
