"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var RenderCounter = (function () {
    function RenderCounter(dest, value) {
        if (value === void 0) { value = 0; }
        this._value = 0;
        this.dest = dest;
        this._value = value;
    }
    ;
    Object.defineProperty(RenderCounter.prototype, "Value1", {
        set: function (value) {
            this._value = value;
        },
        enumerable: true,
        configurable: true
    });
    RenderCounter.prototype.before = function () {
        this.dest.prop('disabled', true);
        this.dest.html('<option>загрузка...</option>');
    };
    RenderCounter.prototype.after = function () {
        this.dest.prop('disabled', false);
    };
    RenderCounter.prototype.doRun = function (data) {
        var options = '';
        $(data).each(function () {
            options += '<option value="' + $(this).attr('id') + '">' + $(this).attr('name') + '</option>';
        });
        this.html = options;
    };
    RenderCounter.prototype.render = function () {
        var out = this.dest;
        var value = this._value;
        out.html(this.html);
        if (!value)
            out.find('[value="' + value + '"]').prop("selected", true);
    };
    return RenderCounter;
}());
exports.RenderCounter = RenderCounter;
