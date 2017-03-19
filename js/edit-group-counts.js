/**
 * Created by valik on 09.03.2017.
 */
$( function () {
    const RIGTH = $( '#right' );
    const ReqestData = {
        render: {},
        data  : '',
        url   : '',
        type  : '',
        init  : function ( render, url, param = '', type = 'post' ) {
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
    const ReqestCount = Object.assign( {}, ReqestData );
    const GroupCountRender = {
        dest  : {},
        html  : '',
        init  : function ( dest ) {
            this.dest = dest;
        },
        doRun : function ( data ) {
            let st = '<div id="group-counter" class="widget">';
            st += '<label for="group">Выбор группы счётчиков</label>';
            st += '<select id="group" name="group" class="ui-group-counter">';
            for ( let i = 0; i < data.length; i ++ ) {
                let grp = data[ i ];
                st += `<option value="${grp.id}">${grp.name}</option>`
            }
            st += '</select>';
            st += '</div>';

            this.html = st;
        },
        render: function () {
            this.dest.find( "#group-counter" ).remove();
            this.dest.find( "#btn-action-group" ).remove();
            this.dest.append( this.html );
            // this.dest.append(
            //     `<div id="btn-action-group" class="widget">
            //         <button id="del-group"><i class="fa fa-trash-o"></i>Удалить группу</button>
            //     </div>`
            // );

            // $( "#btn-action-group" ).click( function ( e ) {
            //     console.log( 'Delete Group' );
            //     let idGroup = $( "#group" ).val();
            //     console.log( idGroup );
            //     ActionBtnDeleteGroup.init( { del_group: idGroup } );
            //     ActionBtnDeleteGroup.doDeleteGroup();
            //
            //     e.preventDefault();
            // } );
            CountRender.init( RIGTH );
            ReqestCount.init( CountRender, 'ajax/getcounter_all/', '', 'get' );
            ReqestCount.reqest();

            $( "#group" ).select2();
        }
    };
    const CountRender = {
        dest  : {},
        html  : '',
        init  : function ( dest ) {
            this.dest = dest;
        },
        doRun : function ( data ) {
            let st = ` <div class="title-counter"><div class="title-all">Ячейки</div><div class="title-plus">Ячейки расход</div><div class="title-minus">Ячейки транзит</div></div>
                    <div id="counter">
                        <ul class="ui-counter">`;
            for ( let i = 0; i < data.length; i ++ ) {
                let grp = data[ i ];
                st += `<li id="g-${grp.id}" class="counter-list"><span>${grp.name}</span></li>`
            }
            st += `    </ul>
                    </div>
                    <div id="counter-plus">
                        <ul class="ui-counter"></ul>
                    </div>
                    <div id="counter-minus">
                        <ul class="ui-counter"></ul>
                    </div>`;
            this.html = st;
        },
        render: function () {
            let heght = 50;
            this.dest.find( "#counter" ).remove()
            this.dest.append( this.html );
            $( "ul.ui-counter" ).sortable( {
                connectWith: "ul"
            } );
            //$( "#counter-plus" ).height( heght );
            //$( "#counter-minus" ).height( heght );

        }
    };

    const ActionBtnDeleteGroup = {
        params       : {},
        init         : function ( params ) {
            this.params = params;
        },
        doDeleteGroup: function () {
            $.ajax( {
                dataType: 'json',
                type    : 'post',
                url     : 'ajax/actionbtn_delete_group/',
                data    : this.params
            } )
                .done( ( result ) => {

                    GroupCountRender.init( RIGTH );
                    ReqestData.init( GroupCountRender, 'ajax/getgroup_all/', '', 'get' );
                    ReqestData.reqest();

                } )
                .fail( ( result ) => alert( result.responseJSON.error ) );

        }
    };

    GroupCountRender.init( RIGTH );
    ReqestData.init( GroupCountRender, 'ajax/getgroup_all/', '', 'get' );
    ReqestData.reqest();

    $( ".widget button" ).button();
} );
