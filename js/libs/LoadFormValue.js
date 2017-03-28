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
        this.renderSel.reqest();
    };
    return LoadFormValue;
}());
exports.LoadFormValue = LoadFormValue;
