$( function () {
    const objEditUser = {
        objUser: $( '#user_edit' ),
        objPassword: $( '#pass_edit' ),
        objConfirmPassword: $( '#pass_repeat_edit' ),
        objUserFamily: $( '#family_edit' ),
        objUserName: $( '#name_edit' ),
        objId: $( '#edit_user_id' )
    };

    const ReqestData = {
        render: {},
        data: '',
        url: '',
        type: '',
        init: function ( render, url, param = '', type = 'post' ) {
            this.data = param;
            this.render = render;
            this.url = url;
            this.type = type;
        },
        reqest: function () {
            let me = this;
            //noinspection JSUnresolvedVariable
            $.ajax( { dataType: 'json', type: me.type, url: me.url, data: me.data } )
                .done( ( result ) => {
                    console.log( result );
                    this.render.doRun( result.data );
                    this.render.render();
                } )
                .fail( ( result ) => alert( result.responseJSON.error ) );

        },
    };
    const userRender = {
        dest: {},
        html: '',
        init: function ( dest ) {
            this.dest = dest;
        },
        doRun: function ( data ) {
            let count = 0, class_e, st;
            st = this.doUserBtnAdd();
            st += `<div class="title_table_user">
                        <div class="title_user">Пользователь</div>
                        <div class="title_family">Фамилия</div>
                        <div class="title_name">Имя</div>
                   </div>`;
            for ( let key in data ) {
                if ( count % 2 != 0 ) class_e = 'counter_str_odd'; else class_e = 'counter_str_even';
                //noinspection JSUnresolvedVariable
                st += `
                <div id="id_${data[ key ].id}" class="${class_e}"  title="Редактировать параметры пользователя">
                    <div class="col_user">${data[ key ].users}</div>
                    <div class="col_family">${data[ key ].family}</div>
                    <div class="col_name">${data[ key ].name}</div>
               </div>`;
                count ++;
            }
            this.html = st;
        },
        doUserBtnAdd: function () {
            return `
            	<div id="add_user_btn">
                    <div class="btn-ico"><img src="img/web/add_user.png" width="32" height="32" alt="add_user"></div>
                    <div class="btn-text">Добавить пользователя</div>
                </div>`;

        },
        render: function () {
            this.dest.html( this.html );
        }
    };
    const loadFormUser = {
        dest: {},
        init: function ( dest ) {
            this.dest = dest;
        },
        doRun: function ( data ) {
            //noinspection JSUnresolvedVariable
            this.dest.objUser.val( data.users );
            this.dest.objPassword.val( '' );
            this.dest.objConfirmPassword.val( '' );
            //noinspection JSUnresolvedVariable
            this.dest.objUserFamily.val( data.family );
            this.dest.objUserName.val( data.name );
            this.dest.objId.val( data.id );
        },
        render: function () {
        }
    };
    const loadFormPrivege = {
        dest: {},
        html: '',
        init: function ( dest ) {
            this.dest = dest;
        },
        doRun: function ( data ) {
            console.log( data );
            let st = '<ol>';
            for ( let i = 0; i < data.length; i ++ ) {
                //noinspection JSUnresolvedVariable
                st += `<li>${data[ i ].name}
								    <input id="check_${data[ i ].id_a}" class="privilege_checkbox" type="checkbox" ${data[ i ].checked}/>
							    </li>`;
            }
            st += '</ol>';
            this.html = st;

        },
        render: function () {
            this.dest.html( this.html );
        }
    };

    userRender.init( $( '#right' ) );
    ReqestData.init( userRender, 'ajax/getuser_all/', '', 'get' );
    ReqestData.reqest();


    const user_form_actions = ( form ) => {
        let m_method = $( form ).attr( 'method' );
        let m_action = $( form ).attr( 'action' );
        let m_data = $( form ).serialize(); // input1=value1&input2=value2..., только input=text
        //noinspection JSUnresolvedVariable
        $.ajax( { dataType: 'json', type: m_method, url: m_action, data: m_data } )
            .done( ( result ) => {
                if ( result.success == true ) {
                    let data = result;
                } else  alert( result.error );
            } )
            .fail( ( result ) => alert( result.responseJSON.error ) );
    }

    const edit_privilege = () => {
        var m_data = { 'id_user': $( '#edit_user_id' ).val() }
        $.ajax( { dataType: 'json', type: 'post', data: m_data, url: 'ajax/loadform_privelege/' } )
            .done( ( result_menu ) => {
                var menu_v = result_menu.data;
                var mainfile = '<ol>';
                for ( let i = 0; i < menu_v.length; i ++ )
                    mainfile += `<li>${menu_v[ i ].name}
    						    <input id="check_${menu_v[ i ].id_a}" class="privilege_checkbox" type="checkbox" ${menu_v[ i ].checked}/>
    					    </li>`;
                mainfile += '</ol>';
                $( '#user_form_privelege' ).html( mainfile );

            } )
            .fail( ( result ) => alert( result.error ) );
    }


    const privilege_user_form_actions = ( obj_form ) => {
        var sList = '';
        var form = obj_form.view.user_form_privilege_submit;
        var workForm = obj_form.view.user_form_privilege;
        var m_method = $( form ).attr( 'method' ); //берем из формы метод передачи данных
        var m_action = $( form ).attr( 'action' ); //получаем адрес скрипта на сервере, куда нужно отправить форму

        var m_checkbox = form.find( 'input[type=checkbox]' );	// запомнить !!!

        $( m_checkbox ).each( function () {
            var sThisVal = (this.checked ? "1" : "0");
            sList += (sList == "" ? sThisVal : "," + sThisVal);
        } );

        var m_data = {
            data: sList,
            id_user: $( '#edit_user_id' ).val()
        };
        $.ajax( { dataType: 'json', type: m_method, url: m_action, data: m_data } )
            .done( ( result ) => {
            } )
            .fail( ( result ) => alert( result.error ) );
        workForm.dialog( "close" );
    }

    const user_form_add = $( "#user_form_add" ).dialog( {
        title: "Добавление пользователя",
        autoOpen: false,
        resizable: false,
        modal: true,
        height: 430,
        width: 500,
        close: function () {
        },
        buttons: {
            "Ok": {
                text: 'Ok',
                click: function ( event ) {
                    user_form_actions( this );
                    userRender.init( $( '#right' ) );
                    ReqestData.init( userRender, 'ajax/getuser_all/', '', 'get' );
                    ReqestData.reqest();
                    user_form_add.dialog( "close" );

                }
            },
            Cancel: function () {
                user_form_add.dialog( "close" );
            }
        }
    } );

    $( document ).on( "submit", '#user_form_add', function ( event ) {
        event.preventDefault();
        user_form_actions( this );
        userRender.init( $( '#right' ) );
        ReqestData.init( userRender, 'ajax/getuser_all/', '', 'get' );
        ReqestData.reqest();
        user_form_add.dialog( "close" );
    } );

    const user_form_edit = $( "#user_form_edit" ).dialog( {
        title: "Редактирование пользователя",
        autoOpen: false,
        resizable: false,
        modal: true,
        height: 430,
        width: 500,
        buttons: {
            "edit_privilege_btn": {
                class: 'ui-button-left',
                text: 'Привелегии...',
                click: function () {
                    // let param = { 'id_user': $( '#edit_user_id' ).val() };
                    // loadFormPrivege.init( $( '#user_form_privelege' ) );
                    // ReqestData.init( loadFormPrivege, 'ajax/loadform_privelege/', param );
                    // ReqestData.reqest();
                    edit_privilege();
                    user_form_edit.dialog( "close" );
                    user_form_privilege.dialog( "open" );
                }
            },
            "Ok": {
                text: 'Ok',
                click: function ( event ) {
                    user_form_actions( this );
                    userRender.init( $( '#right' ) );
                    ReqestData.init( userRender, 'ajax/getuser_all/', '', 'get' );
                    ReqestData.reqest();
                    user_form_edit.dialog( "close" );
                }
            },
            Cancel: function () {
                user_form_edit.dialog( "close" );
            }
        }
    } );

    $( document ).on( "submit", '#user_form_edit', function ( event ) {
        event.preventDefault();
        user_form_actions( this );
        userRender.init( $( '#right' ) );
        ReqestData.init( userRender, 'ajax/getuser_all/', '', 'get' );
        ReqestData.reqest();
        user_form_edit.dialog( "close" );
    } );

    const user_form_privilege = $( "#user_form_privelege" ).dialog( {
        title: "Редактирование привелегий",
        autoOpen: false,
        resizable: false,
        modal: true,
        height: 350,
        width: 350,
        buttons: {
            "Ok": privilege_user_form_actions,
            Cancel: function () {
                user_form_privilege.dialog( "close" );
            }
        }
    } );

    const user_form_privilege_submit = user_form_privilege.find( "form" ).on( "submit", function ( event ) {
        event.preventDefault();
    } );


    $( '#right' ).on( 'click', '#add_user_btn', function ( event ) {
        $( '#user_add' ).val( '' );
        $( '#pass_add' ).val( '' );
        $( '#pass_repeat_add' ).val( '' );
        $( '#family_add' ).val( '' );
        $( '#name_add' ).val( '' );
        $( '#edit_user_id' ).val( '' );

        user_form_add.dialog( "open" );
        event.preventDefault();
    } );

    $( '#right' ).on( 'click', '.counter_str_even, .counter_str_odd', function () {
        var edit_user_id = $( this ).attr( 'id' );
        let param = { 'id': edit_user_id.slice( 3 ) };

        loadFormUser.init( objEditUser );
        ReqestData.init( loadFormUser, 'ajax/loadform_user/', param );
        ReqestData.reqest();

        user_form_edit.dialog( "open" );
    } );


    $( document ).tooltip();
    $( "#right button" )
        .button()
        .click( function ( event ) {
            event.preventDefault();
        } );
} );