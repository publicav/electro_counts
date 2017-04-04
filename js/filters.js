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
var GeturlVar_1 = require("./libs/GeturlVar");
var MySelect_1 = require("./libs/MySelect");
var ReqestSelect_1 = require("./libs/ReqestSelect");
var RenderTablValCounter_1 = require("./libs/RenderTablValCounter");
$(function () {
    var RIGHT = $('#right');
    var COUNTER = $('#counter');
    var SELECTED_ACTIONS = 1, EDIT_ACTIONS = 2;
    var parseBASENAME = window.location.pathname.slice(1).split('/');
    var BASENAME = GeturlVar_1.nameUrl(window.location.pathname);
    var base_link = BASENAME;
    var objFiltred = {
        objSubstation: $('#substation'),
        objCounter: COUNTER,
        url_substation: 'ajax/subst_filter/',
        url_counter: 'ajax/counter_filter/'
    };
    var cmd_line = GeturlVar_1.getUrlVars1();
    var json_get_table = function (objTarget, cmd_line) {
        var right = document.getElementById('right');
        var table = new RenderTablValCounter_1.default();
        right.innerHTML = '';
        table.render();
        right.appendChild(table.elTitle);
        right.appendChild(table.elTable);
        right.appendChild(table.elnavigator);
        var requstTable = new ReqestData_1.ReqestData(table, 'ajax/filterValue/', cmd_line, 'get');
        requstTable.reqest();
        history.replaceState(cmd_line, '', BASENAME + '?' + $.param(cmd_line));
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
    json_get_table(RIGHT, cmd_line);
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
            delete cmd_line.st;
        }
        else {
            delete cmd_line.st;
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
        json_get_table(RIGHT, cmd_line);
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
            delete cmd_line.st;
        }
        else {
            delete cmd_line.st;
            delete cmd_line.id_counter;
        }
        var primaer = [
            { url: 'ajax/counter_filter', 'render': selectCount },
        ];
        var req = new ReqestSelect_1.ReqestSelect(primaer);
        req.data = val;
        req.reqest();
        json_get_table(RIGHT, cmd_line);
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
        json_get_table(RIGHT, cmd_line);
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
                json_get_table(RIGHT, cmd_line);
            }
            else {
                delete cmd_line.date_b;
                delete cmd_line.st;
                delete cmd_line.date_e;
                $('#dt2_en').prop('disabled', true);
                $('#dt2_en').prop('checked', false);
                $("#dt1").datepicker('disable');
                $("#dt2").datepicker('disable');
                json_get_table(RIGHT, cmd_line);
            }
        if ((checkbox_id == 'dt2_en'))
            if ($('#dt2_en').prop('checked')) {
                delete cmd_line.st;
                $("#dt2").datepicker('enable');
                cmd_line.date_e = $("#dt2").datepicker().val();
                json_get_table(RIGHT, cmd_line);
            }
            else {
                delete cmd_line.date_e;
                delete cmd_line.st;
                $("#dt2").datepicker('disable');
                json_get_table(RIGHT, cmd_line);
            }
    });
    $("#dt1").datepicker({
        changeYear: true, changeMonth: true, minDate: '2016-01-01', maxDate: '0', dateFormat: 'yy-mm-dd',
        onSelect: function (dateText, inst) {
            cmd_line.date_b = dateText;
            json_get_table(RIGHT, cmd_line);
        }
    });
    $("#dt2").datepicker({
        changeYear: true, changeMonth: true, minDate: '2016-01-01', maxDate: '0', dateFormat: 'yy-mm-dd',
        onSelect: function (dateText, inst) {
            cmd_line.date_e = dateText;
            json_get_table(RIGHT, cmd_line);
        }
    });
    if (!$('#dt1_en').prop('checked'))
        $("#dt1").datepicker('disable');
    if (!$('#dt2_en').prop('checked'))
        $("#dt2").datepicker('disable');
    RIGHT.on('click', 'a', function (event) {
        event.preventDefault();
        var param;
        var paramStr = event.target;
        param = $(paramStr).attr('href');
        console.log($(paramStr).attr('href'));
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
        json_get_table(RIGHT, cmd_line);
    });
    $(document).tooltip({
        content: function () {
            return this.getAttribute("title");
        }
    });
});

},{"./libs/GeturlVar":3,"./libs/MySelect":4,"./libs/RenderTablValCounter":5,"./libs/ReqestData":6,"./libs/ReqestSelect":7}],3:[function(require,module,exports){
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

},{}],4:[function(require,module,exports){
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

},{}],5:[function(require,module,exports){
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

},{"./../../json/title-tabl-counter.json":1}],6:[function(require,module,exports){
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

},{}]},{},[2]);
