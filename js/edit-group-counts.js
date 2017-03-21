/**
 * Created by valik on 09.03.2017.
 */
$( function () {
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
    const ReqestCount = Object.assign( {}, ReqestData );
    const GroupCountRender = {
        dest: {},
        html: '',
        init: function ( dest ) {
            this.dest = dest;
        },
        doRun: function ( data ) {
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
            this.dest.append(
                `<div id="btn-action-create-group" class="widget">
                    <button id="create-count-group"><i class="fa fa-object-group"></i>Сформирвать группу</button>
                </div>`
            );

            $( "#create-count-group" ).click( function ( e ) {
                console.log( 'Create count group' );
                let param = {};
                param.id_group = $("#group").val();
                let groupPlus = '';
                $( "#counter-plus li" ).each( function ( index, element ) {
                    if ( index != 0 ) groupPlus += ',';
                    groupPlus += $( element ).attr( "id" ).substring( 2 );
                } )
                param.group_plus = groupPlus;
                $( "#counter-minus li" ).each( function ( index, element ) {
                    if ( index != 0 ) groupPlus += ',';
                    groupPlus += $( element ).attr( "id" ).substring( 2 );
                } )
                param.group_minus = groupPlus;

                console.log( param );
                ActionBtnCreateGroup.init(param);
                ActionBtnCreateGroup.doCreateGroup();
                e.preventDefault();
            } );
            let param = {
                id_group: $( "#group" ).val(),
            };
            CountRender.init( RIGTH );
            ReqestCount.init( CountRender, 'ajax/getcounter_all/', param, 'get' );
            ReqestCount.reqest();

            $( "#group-counter" ).change( function ( e ) {
                let param = {
                    id_group: $( "#group" ).val(),
                };
                CountRender.init( RIGTH );
                ReqestCount.init( CountRender, 'ajax/getcounter_all/', param, 'get' );
                ReqestCount.reqest();

                e.preventDefault();
            } )


            $( "#group" ).select2();
        }
    };
    const CountRender = {
        dest: {},
        html: '',
        init: function ( dest ) {
            this.dest = dest;
        },
        doRun: function ( data ) {
            //noinspection JSUnresolvedVariable
            let counter_free = data.counter_free;
            //noinspection JSUnresolvedVariable
            let counter_plus = data.counter_plus;
            //noinspection JSUnresolvedVariable
            let counter_minus = data.counter_minus;
            let st = ` <div id="list-counter">
                        <div class="title-counter"><div class="title-all">Ячейки</div><div class="title-plus">Ячейки расход</div><div class="title-minus">Ячейки транзит</div></div>
                            <div id="counter">
                                <ul class="ui-counter">`;
            for ( let i = 0; i < counter_free.length; i ++ ) {
                let grp = counter_free[ i ];
                st += `<li id="g-${grp.id}" class="counter-list"><span>${grp.name}</span></li>`
            }
            st += `    </ul>
                    </div>
                    
                    <div id="counter-plus">
                        <ul class="ui-counter">`;
            for ( let i = 0; i < counter_plus.length; i ++ ) {
                let grp = counter_plus[ i ];
                st += `<li id="g-${grp.id}" class="counter-list"><span>${grp.name}</span></li>`
            }
            st += `</ul>
                    </div>
                    
                    <div id="counter-minus">
                        <ul class="ui-counter">`;
            for ( let i = 0; i < counter_minus.length; i ++ ) {
                let grp = counter_minus[ i ];
                st += `<li id="g-${grp.id}" class="counter-list"><span>${grp.name}</span></li>`
            }

            st += `       </ul>
                        </div>
                    </div>
                    `;
            this.html = st;
        },
        render: function () {
            let heght = 50;
            this.dest.find( "#list-counter" ).remove()
            this.dest.append( this.html );

            $( "ul.ui-counter" ).sortable( {
                connectWith: "ul"
            } );
            //$( "#counter-plus" ).height( heght );
            //$( "#counter-minus" ).height( heght );

        }
    };

    const ActionBtnCreateGroup = {
        params: {},
        init: function ( params ) {
            this.params = params;
        },
        doCreateGroup: function () {
            $.ajax( {
                dataType: 'json',
                type: 'post',
                url: 'ajax/test/',
                data: this.params
            } )
                .done( ( result ) => {
                } )
                .fail( ( result ) => alert( result.responseJSON.error ) );

        }
    };

    GroupCountRender.init( RIGTH );
    ReqestData.init( GroupCountRender, 'ajax/getgroup_all/', '', 'get' );
    ReqestData.reqest();

    $( ".widget button" ).button();
} );
