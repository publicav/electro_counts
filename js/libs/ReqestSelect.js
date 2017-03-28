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
                    console.log(param_1);
                    me_1.render.selectByValue(param_1.setparam.toLocaleString());
                    _this._data = param_1.setparam;
                }
                else {
                    _this._data = result.data[0].id;
                }
                console.log(result);
                _this.reqest();
            })
                .fail(function (result) { return alert('error'); });
        }
    };
    return ReqestSelect;
}());
exports.ReqestSelect = ReqestSelect;
exports.default = ReqestSelect;
