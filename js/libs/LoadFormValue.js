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
