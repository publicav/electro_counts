"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var Select = (function () {
    function Select(idEl) {
        this.onChange = null;
        this.data = [];
        this.el = null;
        this.idEl = idEl;
    }
    Select.prototype.setData = function (data) {
        this.data = data;
        this.render();
    };
    Select.prototype.selectById = function (id) {
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
