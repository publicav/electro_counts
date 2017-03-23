$(function () {
    var menu = $('#menu');
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
            $.ajax({
                dataType: 'json',
                type: me.type,
                url: me.url,
                data: me.data
            })
                .done(function (result) {
                _this.render.doRun(result.data);
                _this.render.render();
            })
                .fail(function (result) { return alert(result.responseJSON.error); });
        },
    };
    var ReqestLeftMenu = Object.create(ReqestData);
    var MainMenu = {
        dest: {},
        user: {},
        html: '',
        init: function (dest, user) {
            if (user === void 0) { user = {}; }
            this.dest = dest;
            this.user = user;
        },
        doRun: function (data) {
            var st = '';
            st += '<ul>';
            for (var i = 0; i < data.length; i++) {
                st += "\t<li class=\"menu_childs1\">\n                                <a id=\"" + data[i].id_a + "\" href=\"" + data[i].id_a + "\">" + data[i].name + "</a>\n                            </li>\n            ";
            }
            st += '</ul>';
            this.html = st;
        },
        render: function () {
            var userName;
            this.dest.html(this.html);
            if ((this.user.id != 0) && (Object.keys(this.user).length != 0)) {
                userName = "<div class=\"user\"><div class=\"title_user\">\u0412\u044B \u0437\u0430\u0448\u043B\u0438 \u043A\u0430\u043A:</div>" + this.user.name + " " + this.user.family + "</div>";
            }
            this.dest.find('ul').append(userName);
        }
    };
    var LeftMenu = {
        dest: {},
        html: '',
        init: function (dest) {
            this.dest = dest;
        },
        doRun: function (data) {
            var st = '';
            var li_id = '';
            var subLm;
            var lm;
            st += '<nav id="navbar"><ul id="left-menu">';
            for (var i = 0; i < data.length; i++) {
                lm = data[i][0];
                if (lm.li_id !== null) {
                    li_id = " class=" + lm.li_id;
                }
                else
                    li_id = '';
                st += "\t<li" + li_id + ">\n    \t\t\t<a id=\"" + lm.id_a + "\" href=\"" + lm.id_a + "\">\n    \t\t\t\t<i class=\"" + lm.icon + "\"></i>\n    \t\t\t\t" + lm.name + "\n    \t\t\t</a>\n    \t\t</li>";
                if (data[i].length > 1) {
                    var j = 1;
                    st += "<ul class=\"submenu hide-submenu\">";
                    while (j < data[i].length) {
                        subLm = data[i][j];
                        st +=
                            "<li>\n                            <a  id=\"" + subLm.id_a + "\" href=\"" + subLm.id_a + "\">\n                                <i class=\"" + subLm.icon + "\"></i>\n                                " + subLm.name + "\n                            </a>\n                        </li>";
                        j++;
                    }
                    st += "</ul>";
                }
            }
            st += '</ul></nav>';
            this.html = st;
        },
        render: function () {
            this.dest.html(this.html);
        }
    };
    var login_form = $('#loginmodal').dialog({
        title: "Регистрация пользователя",
        autoOpen: false,
        resizable: false,
        modal: true,
        height: 250,
        width: 400
    });
    var Auth = {
        mMenuTarget: '',
        lMenuTarget: '',
        init: function (mMenuTarget, lMenuTarget) {
            this.mMenuTarget = mMenuTarget;
            this.lMenuTarget = lMenuTarget;
        },
        logout: function () {
            var _this = this;
            $.ajax({ dataType: 'json', type: 'post', url: 'ajax/unregistration/' })
                .done(function () {
                MainMenu.init(_this.mMenuTarget);
                ReqestData.init(MainMenu, 'json/menu.json');
                ReqestData.reqest();
                _this.lMenuTarget.html('');
                $('#right').html('');
            })
                .fail(function () { return alert('Error'); });
        },
        login: function (form) {
            var _this = this;
            var m_method = $(form).attr('method');
            var m_action = $(form).attr('action');
            var m_data = $(form).serialize();
            $.ajax({ dataType: 'json', type: m_method, url: m_action, data: m_data })
                .done(function (result) {
                MainMenu.init(_this.mMenuTarget, result);
                ReqestData.init(MainMenu, 'json/menu_registration.json');
                ReqestData.reqest();
                LeftMenu.init(_this.lMenuTarget);
                ReqestLeftMenu.init(LeftMenu, 'ajax/menuleft/');
                ReqestLeftMenu.reqest();
            })
                .fail(function (result) { return alert(result.responseJSON.error); });
        }
    };
    $('#loginform').submit(function (e) {
        e.preventDefault();
        Auth.login(this);
        login_form.dialog("close");
    });
    menu.on('click', '#logout', function (e) {
        Auth.logout();
        e.preventDefault();
    });
    menu.on('click', '#login', function (e) {
        login_form.dialog("open");
        e.preventDefault();
    });
    Auth.init(menu, $("#left"));
});
