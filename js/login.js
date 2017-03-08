$( function () {
    menuLeftInit();
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
    const MainMenu = {
        dest: {},
        html: '',
        init: function ( dest ) {
            this.dest = dest;
        },
        doRun: function ( data ) {
            let st = '';
            st += '<ul>';
            for ( let i = 0; i < data.length; i ++ ) { //noinspection JSUnresolvedVariable
                st += `	<li class="menu_childs1">
                                <a id="${data[ i ].id_a}" href="${data[ i ].id_a}">${data[ i ].name}</a>
                            </li>
            `;
            }
            st += '</ul>';
            this.html = st;
        },
        render: function () {
            this.dest.html( this.html );
        }
    };
    const LeftMenu = {
        dest: {},
        html: '',
        init: function ( dest ) {
            this.dest = dest;
        },
        doRun: function ( data ) {
            let st = '';
            let li_id = '';
            st += '<nav id="navbar"><ul id="left-menu">';
            for ( let i = 0; i < data.length; i ++ ) {
                let lm = data[ i ][ 0 ];
                //noinspection JSUnresolvedVariable
                if ( lm.li_id !== null ) li_id = " class=" + lm.li_id; else li_id = '';
                //noinspection JSUnresolvedVariable
                st += `	<li${li_id}>
    			<a id="${lm.id_a}" href="${lm.id_a}">
    				<i class="${lm.icon}"></i>
    				${lm.name}
    			</a>
    		</li>`;
                if ( data[ i ].length > 1 ) {
                    let j = 1;
                    st += `<ul class="submenu hide-submenu">`;
                    while ( j < data[ i ].length ) {
                        var subLm = data[ i ][ j ];
                        st +=
                            `<li>
                            <a  id="${subLm.id_a}" href="${subLm.id_a}">
                                <i class="${subLm.icon}"></i>
                                ${subLm.name}
                            </a>
                        </li>`;
                        j ++;
                    }
                    st += "</ul>";
                }
            }

            st += '</ul></nav>';
            this.html = st;
        },
        render: function () {
            this.dest.html( this.html );
        }
    };
    const login_form = $( '#loginmodal' ).dialog( {
        title: "Регистрация пользователя",
        autoOpen: false,
        resizable: false,
        modal: true,
        height: 250,
        width: 400
    } );
    const unregistration = () => {
        $.ajax( { dataType: 'json', type: 'post', url: 'ajax/unregistration/' } )
            .done( () => {
                MainMenu.init( $( '#menu' ) );
                ReqestData.init( MainMenu, 'json/menu.json' );
                ReqestData.reqest();

                $( '#left' ).html( '' );
                $( '#right' ).html( '' );
            } )
            .fail( () => alert( 'Error' ) );
    }
    const registration = ( form ) => {
        var m_method = $( form ).attr( 'method' );
        var m_action = $( form ).attr( 'action' );
        var m_data = $( form ).serialize();

        //noinspection JSUnresolvedVariable
        $.ajax( { dataType: 'json', type: m_method, url: m_action, data: m_data } )
            .done( ( result ) => {
                let userName = '';
                MainMenu.init( $( '#menu' ) );
                ReqestData.init( MainMenu, 'json/menu_registration.json' );
                ReqestData.reqest();

                LeftMenu.init( $( "#left" ) );
                ReqestData.init( LeftMenu, 'ajax/menuleft/' );
                ReqestData.reqest();

                if ( result.id != 0 )
                    userName = `<div class="user"><div class="title_user">Вы зашли как:</div>${result.name} ${result.family}</div>`;
                $( '#menu' ).find( 'ul' ).append( userName );

            } )
            .fail( ( result ) => alert( result.responseJSON.error ) );
    }

    $( '#loginform' ).submit( function ( e ) {
        e.preventDefault();
        registration( this );
        login_form.dialog( "close" );
    } );
    $( '#menu' ).on( 'click', '#login', function ( e ) {
        login_form.dialog( "open" );
        e.preventDefault();
    } );
    $( '#menu' ).on( 'click', '#logout', function ( e ) {
        unregistration();
        e.preventDefault();
    } );


} );