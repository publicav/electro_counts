$(function () {
    var RIGTH = $('#right');
    var ReqestData = {
        render: {},
        data: '',
        url: '',
        type: '',
        init: function (render, url, param, type) {
            if (param === void 0) { param = ''; }
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
    var GroupCountRender = {
        dest: {},
        html: '',
        init: function (dest) {
            this.dest = dest;
        },
        doRun: function (data) {
            var st = '<div id="group-counter">';
            st += '<ul class="ui-group-counter">';
            for (var i = 0; i < data.length; i++) {
                var grp = data[i];
                st += "<li id=\"g-" + grp.id + "\" class=\"group-counter-list\">" + grp.name + "</li>";
            }
            st += '</ul>';
            st += '</div>';
            this.html = st;
        },
        render: function () {
            this.dest.find("#group-counter").remove();
            this.dest.append(this.html);
            $("ul.ui-group-counter").sortable({
                connectWith: "ul"
            });
        }
    };
    var groupNameForm = $("#group-counter-name-form").dialog({
        title: "Добавление группы",
        autoOpen: false,
        resizable: false,
        modal: true,
        height: 170,
        width: 600,
        close: function () {
            var formRes = $(this)[0];
            formRes.reset();
        },
        buttons: [
            {
                text: 'Ok',
                click: function () {
                    ActionFormGroupName.doGroupName(this);
                    GroupCountRender.init(RIGTH);
                    ReqestData.init(GroupCountRender, 'ajax/getgroup_all/', '', 'get');
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
    var ActionFormGroupName = {
        doGroupName: function (form) {
            var m_method = $(form).attr('method');
            var m_action = $(form).attr('action');
            var m_data = $(form).serialize();
            $.ajax({ dataType: 'json', type: m_method, url: m_action, data: m_data })
                .done(function () {
            })
                .fail(function (result) { return alert(result.responseJSON.error); });
        }
    };
    var ActionBtnSortingGroup = {
        sorting: '',
        init: function (src_obj_data) {
            var sorting = '';
            src_obj_data.each(function (index, element) {
                if (index != 0)
                    sorting += ',';
                sorting += $(element).attr("id").substring(2);
            });
            this.sorting = sorting;
        },
        doSorting: function () {
            $.ajax({
                dataType: 'json',
                type: 'post',
                url: 'ajax/actionbtn_sorting_group/',
                data: { 'sort': this.sorting }
            })
                .done(function () {
            })
                .fail(function (result) { return alert(result.responseJSON.error); });
        }
    };
    $(RIGTH).append("<div id=\"btn-action-group\" class=\"widget\">\n            <button id=\"add-group\"><i class=\"fa fa-plus\"></i>\u0414\u043E\u0431\u0430\u0432\u0438\u0442\u044C \u0433\u0440\u0443\u043F\u043F\u0443</button>\n            <button id=\"sorting-group\"><i class=\"fa fa-save\"></i></i>\u0421\u043E\u0445\u0440\u0430\u043D\u0438\u0442\u044C \u0441\u043E\u0440\u0442\u0438\u0440\u043E\u0432\u043A\u0443</button>\n            \n        </div>");
    GroupCountRender.init(RIGTH);
    ReqestData.init(GroupCountRender, 'ajax/getgroup_all/', '', 'get');
    ReqestData.reqest();
    $("#add-group").click(function (e) {
        console.log('Add group');
        groupNameForm.dialog("open");
        e.preventDefault();
    });
    $("#sorting-group").click(function (e) {
        console.log('Sorting group');
        ActionBtnSortingGroup.init($("#group-counter").find('li'));
        ActionBtnSortingGroup.doSorting();
        e.preventDefault();
    });
    $(".widget button").button();
});
