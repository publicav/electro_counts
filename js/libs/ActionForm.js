"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
var ActionForm = (function () {
    function ActionForm(form) {
        this._form = form;
    }
    ActionForm.prototype.doActions = function () {
        var formActions = $(this._form);
        var m_method = formActions.attr('method');
        var m_action = formActions.attr('action');
        var m_data = formActions.serialize();
        $.ajax({ dataType: 'json', type: m_method, url: m_action, data: m_data })
            .done(function (result) {
            if (result.success) {
            }
            else
                alert(result.error);
        })
            .fail(function (result) { return alert(result.responseJSON.error); });
    };
    return ActionForm;
}());
exports.ActionForm = ActionForm;
