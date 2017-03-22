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
    var ReqestCount = Object.create(ReqestData);
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
                st += "<option value=\"" + grp.id + "\">" + grp.name + "</option>";
            }
            st += '</select>';
            st += '</div>';
            this.html = st;
        },
        render: function () {
            this.dest.find("#group-counter").remove();
            this.dest.find("#btn-action-group").remove();
            this.dest.append(this.html);
            this.dest.append("<div id=\"btn-action-create-group\" class=\"widget\">\n                    <button id=\"create-count-group\"><i class=\"fa fa-object-group\"></i>\u0421\u0444\u043E\u0440\u043C\u0438\u0440\u043E\u0432\u0430\u0442\u044C \u0433\u0440\u0443\u043F\u043F\u0443</button>\n                </div>");
            $("#create-count-group").click(function (e) {
                console.log('Create count group');
                var param = {};
                param.id_group = $("#group").val();
                var groupPlus = '';
                $("#counter-plus").find('li').each(function (index, element) {
                    if (index != 0)
                        groupPlus += ',';
                    groupPlus += $(element).attr("id").substring(2);
                });
                param.group_plus = groupPlus;
                var groupMinus = '';
                $("#counter-minus").find('li').each(function (index, element) {
                    if (index != 0)
                        groupMinus += ',';
                    groupMinus += $(element).attr("id").substring(2);
                });
                param.group_minus = groupMinus;
                console.log(param);
                ActionBtnCreateGroup.init(param);
                ActionBtnCreateGroup.doCreateGroup();
                e.preventDefault();
            });
            var param = {
                id_group: $("#group").val()
            };
            CountRender.init(RIGTH);
            ReqestCount.init(CountRender, 'ajax/getcounter_all/', param, 'get');
            ReqestCount.reqest();
            $("#group-counter").change(function (e) {
                var param = {
                    id_group: $("#group").val()
                };
                CountRender.init(RIGTH);
                ReqestCount.init(CountRender, 'ajax/getcounter_all/', param, 'get');
                ReqestCount.reqest();
                e.preventDefault();
            });
            $("#group").select2();
        }
    };
    var CountRender = {
        dest: {},
        html: '',
        init: function (dest) {
            this.dest = dest;
        },
        doRun: function (data) {
            var counter_free = data.counter_free;
            var counter_plus = data.counter_plus;
            var counter_minus = data.counter_minus;
            var st = " <div id=\"list-counter\">\n                        <div class=\"title-counter\"><div class=\"title-all\">\u042F\u0447\u0435\u0439\u043A\u0438</div><div class=\"title-plus\">\u042F\u0447\u0435\u0439\u043A\u0438 \u0440\u0430\u0441\u0445\u043E\u0434</div><div class=\"title-minus\">\u042F\u0447\u0435\u0439\u043A\u0438 \u0442\u0440\u0430\u043D\u0437\u0438\u0442</div></div>\n                            <div id=\"counter\">\n                                <ul class=\"ui-counter\">";
            for (var i = 0; i < counter_free.length; i++) {
                var grp = counter_free[i];
                st += "<li id=\"g-" + grp.id + "\" class=\"counter-list\"><span>" + grp.name + "</span></li>";
            }
            st += "    </ul>\n                    </div>\n                    \n                    <div id=\"counter-plus\">\n                        <ul class=\"ui-counter\">";
            for (var i = 0; i < counter_plus.length; i++) {
                var grp = counter_plus[i];
                st += "<li id=\"g-" + grp.id + "\" class=\"counter-list\"><span>" + grp.name + "</span></li>";
            }
            st += "</ul>\n                    </div>\n                    \n                    <div id=\"counter-minus\">\n                        <ul class=\"ui-counter\">";
            for (var i = 0; i < counter_minus.length; i++) {
                var grp = counter_minus[i];
                st += "<li id=\"g-" + grp.id + "\" class=\"counter-list\"><span>" + grp.name + "</span></li>";
            }
            st += "       </ul>\n                        </div>\n                    </div>\n                    ";
            this.html = st;
        },
        render: function () {
            this.dest.find("#list-counter").remove();
            this.dest.append(this.html);
            $("ul.ui-counter").sortable({
                connectWith: "ul"
            });
        }
    };
    var ActionBtnCreateGroup = {
        params: {},
        init: function (params) {
            this.params = params;
        },
        doCreateGroup: function () {
            $.ajax({
                dataType: 'json',
                type: 'post',
                url: 'ajax/actionbtn_groupcount_create/',
                data: this.params
            })
                .done(function () {
            })
                .fail(function (result) { return alert(result.responseJSON.error); });
        }
    };
    GroupCountRender.init(RIGTH);
    ReqestData.init(GroupCountRender, 'ajax/getgroup_all/', '', 'get');
    ReqestData.reqest();
    $(".widget button").button();
});
