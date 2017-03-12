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
    const GroupCountRender = {
        dest: {},
        html: '',
        init: function ( dest ) {
            this.dest = dest;
        },
        doRun: function ( data ) {
            let st = '<div id="group-counter">';
            st += '<ul class="ui-group-counter">';
            for ( let i = 0; i < data.length; i ++ ) {
                let grp = data[ i ];
                st += `<li id="g-${grp.id}" class="group-counter-list">${grp.name}</li>`
            }
            st += '</ul>'
            st += '</div>';
            this.html = st;
        },
        render: function () {
            this.dest.append( this.html );
            $( "ul.ui-group-counter" ).sortable( {
                connectWith: "ul"
            } );

        }
    };
    $( RIGTH ).append(
        `<div id="btn-action-group" class="widget">
            <button id="add-group"><i class="fa fa-plus"></i>Добавить группу</button>
            <button id="sorting-group"><i class="fa fa-save"></i></i>Сохранить сортировку</button>
            
        </div>`
    )

    GroupCountRender.init( RIGTH );
    ReqestData.init( GroupCountRender, 'ajax/getgroup_all/', '', 'get' );
    ReqestData.reqest();

    $( ".widget button" ).button();
    $("#add-group").click(function ( e ) {
        console.log('Add group');
        e.preventDefault();
    })
} )
