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
