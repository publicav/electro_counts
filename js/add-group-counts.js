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
    const GroupRender = {
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
                st += `<li id="g"${grp.id} class="group-counter-list">${grp.name}</li>`
            }
            st += '</ul>'
            st += '</div>';
            this.html = st;
        },
        render: function () {
            this.dest.html( this.html );
            $( "ul.ui-group-counter" ).sortable( {
                connectWith: "ul"
            } );

        }
    };
    GroupRender.init( RIGTH );
    ReqestData.init( GroupRender, 'ajax/getgroup_all/', '', 'get' );
    ReqestData.reqest();
} )
