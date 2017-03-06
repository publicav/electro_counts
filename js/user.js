$( function () {
    var objEditUser = {
        objUser: $( '#user_edit' ),
        objPassword: $( '#pass_edit' ),
        objConfirmPassword: $( '#pass_repeat_edit' ),
        objUserFamily: $( '#family_edit' ),
        objUserName: $( '#name_edit' ),
        objId: $( '#edit_user_id' )
    };

    const jsonData = {
        url: '',
        resultJson: {},
        init: function ( url ) {
            this.url = url;
        },
        reqest: function () {
            var me = this;
            $.ajax( { dataType: 'json', type: 'get', url: me.url } )
                .done( ( result ) => {
                    me.resultJson.data = result.data;
                } )
                .fail( ( result, b, c ) => alert( result.responseJSON.error ) );

        },
        getDataAll: function () {
            return this.resultJson;
        },
    };
    jsonData.init( 'ajax/getuser_all/' );
    jsonData.reqest();
    let rrr =  jsonData.getDataAll();
    console.log( jsonData.resultJson );
    // console.log('data' in )

    // const user_render = {
    //     data: {},
    //     init: function ( data ) {
    //         this.data = data;
    //     },
    //     reqest: function () {
    //         this.data.reqest();
    //     },
    //     render: function () {
    //         var count = 0, class_e;
    //         var st = `<div class="title_table_user">
    // 		<div class="title_user">Пользователь</div>
    // 		<div class="title_family">Фамилия</div>
    // 		<div class="title_name">Имя</div>
    // 	  </div>`;
    //         let data1 = this.data.getDataAll();
    //         for (let key in this.data.getDataAll()){
    //             console.log('rrrrr',key);
    //         }
    //         //data1 = data1.data;
    //         console.log(  data1 );
    //         for ( let key in data1 ) {
    //             if ( count % 2 != 0 ) class_e = 'counter_str_odd'; else class_e = 'counter_str_even';
    //             st += `<div id="id_${data1[ key ].id}" class="${class_e}"  title="Редактировать параметры пользователя">
    // 		<div class="col_user">${data1[ key ].users}</div>
    // 		<div class="col_family">${data1[ key ].family}</div>
    // 		<div class="col_name">${data1[ key ].name}</div>
    // 	   </div>`;
    //             count ++;
    //
    //         }
    //         return st;
    //
    //     }
    // };

    // user_render.init( jsonData );
    // user_render.reqest();
    // console.log( user_render.render() );

    // console.log( jsonData.getDataAll() );

    /**
     * Возвращает отформатированую таблицу всех пользователей.
     *
     * @param {object} data  массив объектов.
     * @return {string} st возвращает отформатированую таблицу всех пользователей.
     */
    const print_table_user = ( data ) => {
        var count = 0, class_e;
        var st = `<div class="title_table_user">
				<div class="title_user">Пользователь</div>
				<div class="title_family">Фамилия</div>
				<div class="title_name">Имя</div>
			  </div>`;
        for ( let key in data ) {
            if ( count % 2 != 0 ) class_e = 'counter_str_odd'; else class_e = 'counter_str_even';
            st += `<div id="id_${data[ key ].id}" class="${class_e}"  title="Редактировать параметры пользователя">
				<div class="col_user">${data[ key ].users}</div>
				<div class="col_family">${data[ key ].family}</div>
				<div class="col_name">${data[ key ].name}</div>
			   </div>`;
            count ++;

        }
        return st;
    }

    const json_get_user = ( objTarget ) => {
        $.ajax( { dataType: 'json', type: 'get', url: 'ajax/getuser_all/' } )
            .done( ( result ) => {
                var data = result.data;
                $( objTarget ).html( print_table_user( data ) );
                $( objTarget ).prepend( add_user_btn() );
            } )
            .fail( ( result, b, c ) => alert( result.responseJSON.error ) );

        function add_user_btn() {
            let st = `	<div id="add_user_btn">
						<div class="btn-ico"><img src="img/web/add_user.png" width="32" height="32" alt="add_user"></div>
						<div class="btn-text">Добавить пользователя</div>
					</div>`;
            return st;
        }
    }

    // json_get_user( $( '#right' ) );

    const user_form_actions = ( obj_form ) => {
        var form, workForm, actions;
        if ( obj_form.actionsCmd == ADD_USER_ACTIONS ) {
            form = obj_form.view.user_form_add_submit;
            workForm = obj_form.view.user_form_add;
            actions = '&actions=add';
        }
        if ( obj_form.actionsCmd == EDIT_USER_ACTIONS ) {
            form = obj_form.view.user_form_edit_submit;
            workForm = obj_form.view.user_form_edit;
            actions = '&actions=edit';
        }
        var m_method = $( form ).attr( 'method' );
        var m_action = $( form ).attr( 'action' );
        var m_data = $( form ).serialize(); // input1=value1&input2=value2..., только input=text
        m_data += actions;

        $.ajax( { dataType: 'json', type: m_method, url: m_action, data: m_data } )
            .done( ( result ) => {
                if ( result.success == true ) {
                    var data = result;
                    workForm.dialog( "close" );
                    json_get_user( obj_form.objTarget );
                } else  alert( result.error );
            } )
            .fail( ( result ) => alert( result.responseJSON.error ) );
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

    const user_form_add = $( "#user_div_add" ).dialog( {
        title: "Добавление пользователя",
        autoOpen: false,
        resizable: false,
        modal: true,
        height: 430,
        width: 500,
        buttons: {
            "Ok": {
                text: 'Ok',
                click: function ( obj_form ) {
                    var obj = {
                        objTarget: $( '#right' ),
                        actionsCmd: ADD_USER_ACTIONS,
                        __proto__: obj_form
                    };
                    user_form_actions( obj );
                }
            },
            Cancel: function () {
                user_form_add.dialog( "close" );
            }
        }
    } );

    user_form_add_submit = user_form_add.find( "form" ).on( "submit", function ( event ) {
        event.preventDefault();
    } );

    const user_form_edit = $( "#user_div_edit" ).dialog( {
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
                    edit_privilege();
                    user_form_edit.dialog( "close" );
                    user_form_privilege.dialog( "open" );
                }
            },
            "Ok": {
                text: 'Ok',
                click: function ( obj_form ) {
                    var obj = {
                        objTarget: $( '#right' ),
                        actionsCmd: EDIT_USER_ACTIONS,
                        __proto__: obj_form
                    };
                    user_form_actions( obj );
                }
            },
            Cancel: function () {
                user_form_edit.dialog( "close" );
            }
        }
    } );

    user_form_edit_submit = user_form_edit.find( "form" ).on( "submit", function ( event ) {
        event.preventDefault();
    } );

    const user_form_privilege = $( "#user_div_privelege" ).dialog( {
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

    user_form_privilege_submit = user_form_privilege.find( "form" ).on( "submit", function ( event ) {
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

    $( '#right' ).on( 'click', '.counter_str_even', function ( event ) {
        var edit_user_id = $( this ).attr( 'id' );
        objEditUser.param = { 'id': edit_user_id.slice( 3 ) };
        l_form_edit_user( objEditUser )
        user_form_edit.dialog( "open" );
    } );

    $( '#right' ).on( 'click', '.counter_str_odd', function ( event ) {
        var edit_user_id = $( this ).attr( 'id' );
        objEditUser.param = { 'id': edit_user_id.slice( 3 ) };
        l_form_edit_user( objEditUser )
        user_form_edit.dialog( "open" );
    } );


    const edit_privilege = () => {
        var m_data = { 'id_user': $( '#edit_user_id' ).val() }
        $.ajax( { dataType: 'json', type: 'post', data: m_data, url: 'ajax/loadform_privelege/' } )
            .done( ( result_menu ) => {
                var menu_v = result_menu;
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


    const l_form_edit_user = ( { objUser, objPassword, objConfirmPassword, objUserFamily, objUserName, objId, param } ) => {
        $.ajax( { dataType: 'json', type: 'post', url: 'ajax/loadform_user/', data: param } )
            .done( ( result ) => {
                var data = result.data;
                if ( data == null ) return;
                objUser.val( data.users );
                objPassword.val( '' );
                objConfirmPassword.val( '' );
                objUserFamily.val( data.family );
                objUserName.val( data.name );
                objId.val( data.id );
            } )
            .fail( () => alert( result.responseJSON.error ) );
    }


    $( document ).tooltip();
    $( "#right button" )
        .button()
        .click( function ( event ) {
            event.preventDefault();
        } );
} );