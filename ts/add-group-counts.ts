/**
 * Created by valik on 09.03.2017.
 */
$( () => {
    const RIGTH = $( '#right' );
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
    const GroupCountRender = {
        dest: {},
        html: '',
        init: function ( dest ) {
            this.dest = dest;
        },
        doRun: function ( data ) {
            let st = '<div id="group-counter">';
            st += '<ul class="ui-group-counter">';
            for ( let i = 0; i < data.length; i++ ) {
                let grp = data[ i ];
                st += `<li id="g-${grp.id}" class="group-counter-list">${grp.name}</li>`
            }
            st += '</ul>';
            st += '</div>';
            this.html = st;
        },
        render: function () {
            this.dest.find( "#group-counter" ).remove();
            this.dest.append( this.html );
            $( "ul.ui-group-counter" ).sortable( {
                connectWith: "ul"
            } );

        }
    };
    const groupNameForm = $( "#group-counter-name-form" ).dialog( {
        title: "Добавление группы",
        autoOpen: false,
        resizable: false,
        modal: true,
        height: 170,
        width: 600,
        close: function () {
            let formRes: any = $( this )[ 0 ];
            formRes.reset();
        },
        buttons: [
            {
                text: 'Ok',
                click: function () {
                    ActionFormGroupName.doGroupName( this );

                    GroupCountRender.init( RIGTH );
                    ReqestData.init( GroupCountRender, 'ajax/getgroup_all/', '', 'get' );
                    ReqestData.reqest();

                    $( this ).dialog( "close" );
                }
            },
            {
                text: 'Cancel',
                click: function () {
                    $( this ).dialog( "close" );
                }

            }
        ]
    } );
    const ActionFormGroupName = {
        doGroupName: function ( form ) {
            let m_method = $( form ).attr( 'method' );
            let m_action = $( form ).attr( 'action' );
            let m_data = $( form ).serialize();

            //noinspection JSUnresolvedVariable
            $.ajax( { dataType: 'json', type: m_method, url: m_action, data: m_data } )
                .done( () => {
                } )
                .fail( ( result ) => alert( result.responseJSON.error ) );

        }
    };
    const ActionBtnSortingGroup = {
        sorting: '',
        init: function ( src_obj_data ) {
            let sorting = '';
            src_obj_data.each( function ( index, element ) {
                if ( index != 0 ) sorting += ',';
                sorting += $( element ).attr( "id" ).substring( 2 );
            } );
            this.sorting = sorting;
        },
        doSorting: function () {
            $.ajax( {
                dataType: 'json',
                type: 'post',
                url: 'ajax/actionbtn_sorting_group/',
                data: { 'sort': this.sorting }
            } )
                .done( () => {
                } )
                .fail( ( result ) => alert( result.responseJSON.error ) );

        }
    };
    $( RIGTH ).append(
        `<div id="btn-action-group" class="widget">
            <button id="add-group"><i class="fa fa-plus"></i>Добавить группу</button>
            <button id="sorting-group"><i class="fa fa-save"></i></i>Сохранить сортировку</button>
            
        </div>`
    );

    GroupCountRender.init( RIGTH );
    ReqestData.init( GroupCountRender, 'ajax/getgroup_all/', '', 'get' );
    ReqestData.reqest();
    $( "#add-group" ).click( function ( e ) {
        console.log( 'Add group' );
        groupNameForm.dialog( "open" );
        e.preventDefault();
    } );
    $( "#sorting-group" ).click( function ( e ) {
        console.log( 'Sorting group' );
        ActionBtnSortingGroup.init( $( "#group-counter" ).find( 'li' ) );
        ActionBtnSortingGroup.doSorting();
        e.preventDefault();
    } );

    $( ".widget button" ).button();
} );
