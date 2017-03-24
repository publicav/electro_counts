"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var RenderCounter = (function () {
    function RenderCounter(dest) {
        this.dest = dest;
    }
    ;
    RenderCounter.prototype.doRun = function (data) {
        var options = '';
        $(data).each(function () {
            options += '<option value="' + $(this).attr('id') + '">' + $(this).attr('name') + '</option>';
        });
        this.html = options;
    };
    RenderCounter.prototype.render = function () {
        var out = this.dest;
        out.html(this.html);
    };
    return RenderCounter;
}());
exports.RenderCounter = RenderCounter;
