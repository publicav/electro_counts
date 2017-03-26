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
        })
            .fail(function (result) { return alert('error'); });
        me.render.after();
    };
    return ReqestData;
}());
exports.ReqestData = ReqestData;
