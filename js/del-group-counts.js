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
        },
    };
    var GroupCountRender = {
        dest: {},
        html: '',
        init: function (dest) {
            this.dest = dest;
        },
        doRun: function (data) {
            var st = '<div id="group-counter" class="widget">';
            st += '<label for="group">Выбор группы счётчиков</label>';
            st += '<select id="group" name="group" class="ui-group-counter">';
            for (var i = 0; i < data.length; i++) {
                var grp = data[i];
                st += "<option value=\"" + grp.id + "\" class=\"group-counter-list\">" + grp.name + "</option>";
            }
            st += '</select>';
            st += '</div>';
            this.html = st;
        },
        render: function () {
            this.dest.find("#group-counter").remove();
            this.dest.find("#btn-action-group").remove();
            this.dest.append(this.html);
            this.dest.append("<div id=\"btn-action-group\" class=\"widget\">\n                    <button id=\"del-group\"><i class=\"fa fa-trash-o\"></i>\u0423\u0434\u0430\u043B\u0438\u0442\u044C \u0433\u0440\u0443\u043F\u043F\u0443</button>\n                </div>");
            $("#btn-action-group").click(function (e) {
                console.log('Delete Group');
                var idGroup = $("#group").val();
                console.log(idGroup);
                ActionBtnDeleteGroup.init({ del_group: idGroup });
                ActionBtnDeleteGroup.doDeleteGroup();
                e.preventDefault();
            });
            $("#group").select2();
        }
    };
    var ActionBtnDeleteGroup = {
        params: {},
        init: function (params) {
            this.params = params;
        },
        doDeleteGroup: function () {
            $.ajax({
                dataType: 'json',
                type: 'post',
                url: 'ajax/actionbtn_delete_group/',
                data: this.params
            })
                .done(function () {
                GroupCountRender.init(RIGTH);
                ReqestData.init(GroupCountRender, 'ajax/getgroup_all/', '', 'get');
                ReqestData.reqest();
            })
                .fail(function (result) { return alert(result.responseJSON.error); });
        }
    };
    GroupCountRender.init(RIGTH);
    ReqestData.init(GroupCountRender, 'ajax/getgroup_all/', '', 'get');
    ReqestData.reqest();
    $(".widget button").button();
});
