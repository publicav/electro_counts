$(function () {
    var RIGTH = $('#right');
    var objEditUser = {
        objUser: $('#user_edit'),
        objPassword: $('#pass_edit'),
        objConfirmPassword: $('#pass_repeat_edit'),
        objUserFamily: $('#family_edit'),
        objUserName: $('#name_edit'),
        objId: $('#edit_user_id')
    };
    var ReqestData = {
        render: {},
        data: '',
        url: '',
        type: '',
        init: function (render, url, param, type) {
            if (param === void 0) { param = {}; }
            if (type === void 0) { type = 'post'; }
            this.data = param;
            this.render = render;
            this.url = url;
            this.type = type;
        },
        reqest: function () {
            var _this = this;
            var me = this;
            $.ajax({ dataType: 'json', type: me.type, url: me.url, data: me.data })
                .done(function (result) {
                console.log(result);
                _this.render.doRun(result.data);
                _this.render.render();
            })
                .fail(function (result) { return alert(result.responseJSON.error); });
        }
    };
    var userRender = {
        dest: {},
        html: '',
        init: function (dest) {
            this.dest = dest;
        },
        doRun: function (data) {
            var count = 0, class_e, st;
            st = this.doUserBtnAdd();
            st += "<div class=\"title_table_user\">\n                        <div class=\"title_user\">\u041F\u043E\u043B\u044C\u0437\u043E\u0432\u0430\u0442\u0435\u043B\u044C</div>\n                        <div class=\"title_family\">\u0424\u0430\u043C\u0438\u043B\u0438\u044F</div>\n                        <div class=\"title_name\">\u0418\u043C\u044F</div>\n                   </div>";
            for (var key in data) {
                if (count % 2 != 0)
                    class_e = 'counter_str_odd';
                else
                    class_e = 'counter_str_even';
                st += "\n                <div id=\"id_" + data[key].id + "\" class=\"" + class_e + "\"  title=\"\u0420\u0435\u0434\u0430\u043A\u0442\u0438\u0440\u043E\u0432\u0430\u0442\u044C \u043F\u0430\u0440\u0430\u043C\u0435\u0442\u0440\u044B \u043F\u043E\u043B\u044C\u0437\u043E\u0432\u0430\u0442\u0435\u043B\u044F\">\n                    <div class=\"col_user\">" + data[key].users + "</div>\n                    <div class=\"col_family\">" + data[key].family + "</div>\n                    <div class=\"col_name\">" + data[key].name + "</div>\n               </div>";
                count++;
            }
            this.html = st;
        },
        doUserBtnAdd: function () {
            return "\n            \t<div id=\"add_user_btn\">\n                    <div class=\"btn-ico\"><img src=\"img/web/add_user.png\" width=\"32\" height=\"32\" alt=\"add_user\"></div>\n                    <div class=\"btn-text\">\u0414\u043E\u0431\u0430\u0432\u0438\u0442\u044C \u043F\u043E\u043B\u044C\u0437\u043E\u0432\u0430\u0442\u0435\u043B\u044F</div>\n                </div>";
        },
        render: function () {
            this.dest.html(this.html);
        }
    };
    var loadFormUser = {
        dest: {},
        init: function (dest) {
            this.dest = dest;
        },
        doRun: function (data) {
            this.dest.objUser.val(data.users);
            this.dest.objPassword.val('');
            this.dest.objConfirmPassword.val('');
            this.dest.objUserFamily.val(data.family);
            this.dest.objUserName.val(data.name);
            this.dest.objId.val(data.id);
        },
        render: function () {
        }
    };
    var loadFormPrivege = {
        dest: {},
        html: '',
        init: function (dest) {
            this.dest = dest;
        },
        doRun: function (data) {
            console.log(data);
            var st = '<ol>';
            for (var i = 0; i < data.length; i++) {
                st += "<li>" + data[i].name + "\n\t\t\t\t\t\t\t\t    <input id=\"check_" + data[i].id_a + "\" class=\"privilege_checkbox\" type=\"checkbox\" " + data[i].checked + "/>\n\t\t\t\t\t\t\t    </li>";
            }
            st += '</ol>';
            this.html = st;
        },
        render: function () {
            this.dest.html(this.html);
        }
    };
    var user_form_actions = function (form) {
        var formActions = $(form);
        var m_method = formActions.attr('method');
        var m_action = formActions.attr('action');
        var m_data = formActions.serialize();
        $.ajax({ dataType: 'json', type: m_method, url: m_action, data: m_data })
            .done(function (result) {
            if (result.success == true) {
            }
            else
                alert(result.error);
        })
            .fail(function (result) { return alert(result.responseJSON.error); });
    };
    var privilege_form_actions = function (form) {
        var formActions = $(form);
        var sList = '';
        var m_method = formActions.attr('method');
        var m_action = formActions.attr('action');
        var m_checkbox = formActions.find('input[type=checkbox]');
        $(m_checkbox).each(function () {
            var sThisVal = (this.checked ? "1" : "0");
            sList += (sList == "" ? sThisVal : "," + sThisVal);
        });
        var m_data = {
            data: sList,
            id_user: $('#edit_user_id').val()
        };
        $.ajax({ dataType: 'json', type: m_method, url: m_action, data: m_data })
            .done(function () {
        })
            .fail(function (result) { return alert(result.error); });
    };
    var user_form_add = $("#user_form_add").dialog({
        title: "Добавление пользователя",
        autoOpen: false,
        resizable: false,
        modal: true,
        height: 430,
        width: 500,
        close: function () {
            var formRes = $(this)[0];
            formRes.reset();
        },
        buttons: [
            {
                text: 'Ok',
                click: function () {
                    user_form_actions(this);
                    userRender.init($('#right'));
                    ReqestData.init(userRender, 'ajax/getuser_all/', '', 'get');
                    ReqestData.reqest();
                    $(this).dialog("close");
                }
            },
            {
                text: 'Cancel',
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });
    var user_form_edit = $("#user_form_edit").dialog({
        title: "Редактирование пользователя",
        autoOpen: false,
        resizable: false,
        modal: true,
        height: 430,
        width: 500,
        close: function () {
            var formRes = $(this)[0];
            formRes.reset();
        },
        buttons: [
            {
                "class": 'ui-button-left',
                text: 'Привелегии...',
                click: function () {
                    var param = { 'id_user': $('#edit_user_id').val() };
                    loadFormPrivege.init($('#user_form_privelege'));
                    ReqestData.init(loadFormPrivege, 'ajax/loadform_privelege/', param);
                    ReqestData.reqest();
                    $(this).dialog("close");
                    user_form_privilege.dialog("open");
                    user_form_privilege.focus();
                }
            },
            {
                text: 'Ok',
                click: function () {
                    user_form_actions(this);
                    userRender.init($('#right'));
                    ReqestData.init(userRender, 'ajax/getuser_all/', '', 'get');
                    ReqestData.reqest();
                    $(this).dialog("close");
                }
            },
            {
                text: 'Cancel',
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });
    var user_form_privilege = $("#user_form_privelege").dialog({
        title: "Редактирование привелегий",
        autoOpen: false,
        resizable: false,
        modal: true,
        height: 350,
        width: 350,
        close: function () {
            var formRes = $(this)[0];
            formRes.reset();
        },
        buttons: [
            {
                text: 'Ok',
                click: function () {
                    privilege_form_actions(this);
                    $(this).dialog("close");
                }
            },
            {
                text: 'Cancel',
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });
    $(document).tooltip();
    $(document).on("submit", '#user_form_add', function (event) {
        event.preventDefault();
        user_form_actions(this);
        userRender.init($('#right'));
        ReqestData.init(userRender, 'ajax/getuser_all/', '', 'get');
        ReqestData.reqest();
        user_form_add.dialog("close");
    });
    $(document).on("submit", '#user_form_edit', function (event) {
        event.preventDefault();
        user_form_actions(this);
        userRender.init($('#right'));
        ReqestData.init(userRender, 'ajax/getuser_all/', '', 'get');
        ReqestData.reqest();
        user_form_edit.dialog("close");
    });
    $(document).on("submit", '#user_form_privelege', function (event) {
        event.preventDefault();
        privilege_form_actions(this);
        user_form_privilege.dialog("close");
    });
    RIGTH.on('click', '#add_user_btn', function (event) {
        user_form_add.dialog("open");
        event.preventDefault();
    });
    RIGTH.on('click', '.counter_str_even, .counter_str_odd', function (event) {
        var edit_user_id = $(this).attr('id');
        var param = { 'id': edit_user_id.slice(3) };
        loadFormUser.init(objEditUser);
        ReqestData.init(loadFormUser, 'ajax/loadform_user/', param);
        ReqestData.reqest();
        user_form_edit.dialog("open");
        event.preventDefault();
    });
    userRender.init(RIGTH);
    ReqestData.init(userRender, 'ajax/getuser_all/', '', 'get');
    ReqestData.reqest();
});
