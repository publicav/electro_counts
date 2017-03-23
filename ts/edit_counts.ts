import { RenderCounter }  from "./RenderCounter";
$( () => {
    const RIGTH = $( '#right' );
    const LOT_EDIT = $( '#lot_edit' );
    const SUBSTATION_EDIT = $( '#substation_edit' );
    const ReqestData = {
        render: {},
        data: '',
        url: '',
        type: '',
        init: function ( render, url, param = {}, type = 'post' ) {
            this.data = param;
            this.render = render;
            this.url = url;
            this.type = type;
        },
        reqest: function () {
            let me = this;
            $.ajax( { dataType: 'json', type: me.type, url: me.url, data: me.data } )
                .done( ( result ) => {
                    console.log( result );
                    this.render.doRun( result.data );
                    this.render.render();
                } )
                .fail( ( result ) => alert( result.responseJSON.error ) );

        },
    };
    const renderCounter: RenderCounter = new RenderCounter( $( '#counter_edit' ) );
    const loadFormValue = {
        dest: {},
        init: function ( dest ) {
            this.dest = dest;
        },
        doRun: function ( data ) {
            this.dest.objLot.find( '[value="' + data.lot_id + '"]' ).prop( "selected", true );

//            get_substation( obj, data.lot_id, 2, data.sub_id, data.counter_id );
            this.dest.objDate.val( data.date1 );
            this.dest.objTime.val( data.time1 );
            this.dest.objValEdit.val( data.value );
            this.dest.objId.val( data.id );
        },
        render: function () {
        }
    };

    // interface objEditForm {
    //     objDate?: object;
    //     objTime?: object;
    //     objValEdit?: object;
    //     objId?: object;
    //     param?: object;
    // }
    class ObjSelected {
        objLot?: object;
        objSubstation?: object;
        objCounter?: object;
        url_substation?: string;
        url_counter?: string;

        constructor( objLot: object, objSubstation: object, objCounter: object,
                     url_substation: string, url_counter?: string ) {
            this.objLot = objLot;
            this.objSubstation = objSubstation;
            this.objCounter = objCounter;
            this.url_substation = url_substation;
            this.url_counter = url_counter;
        }
    }
    const objSelected: ObjSelected =
        new ObjSelected(
            LOT_EDIT,
            SUBSTATION_EDIT,
            $( '#counter_edit' ),
            'ajax/subst/',
            'ajax/counter/'
        );

    const objEditForm = {
        objDate: $( '#date_airing_begin_edit' ),
        objTime: $( '#time_airing_begin_edit' ),
        objValEdit: $( '#counter_val_edit' ),
        objId: $( '#edit_id1' ),
        param: {},
        __proto__: objSelected
    };

    const edit_form_actions = ( form ) => {
        let formActions = $( form );

        let m_method = formActions.attr( 'method' );
        let m_action = formActions.attr( 'action' );
        let m_data = formActions.serialize();

        $.ajax( { dataType: 'json', type: m_method, url: m_action, data: m_data } )
            .done( ( result ) => {
                if ( result.success ) {
                } else  alert( result.error );
            } )
            .fail( ( result ) => alert( result.responseJSON.error ) );
    };

    $( "#date_airing_begin_edit" ).datepicker( { changeYear: true, dateFormat: 'dd-mm-yy' } );

    // $.mask.definitions[ 'H' ] = '[012]';
    // $.mask.definitions[ 'M' ] = '[012345]';
    // $.mask.definitions[ 'F' ] = '[0-9.]+';
    $( '#time_airing_begin_edit' ).mask( 'H9:M9' );

    LOT_EDIT.change( function () {
        let lot = $( this ).val();
        get_substation( objSelected, lot );
    } );

    SUBSTATION_EDIT.change( function () {
        let substation = $( this ).val();
        ReqestData.init( renderCounter, 'ajax/counter/', { data: substation }, 'get' );
        ReqestData.reqest();

        // get_counter( objSelected, substation );
    } );


    const edit_form = $( "#edit_value_counts_form" ).dialog( {
        title: "Редактирование значения счётчика",
        autoOpen: false,
        resizable: false,
        height: 350,
        width: 620,
        modal: true,
        close: function () {
            let formRes: any = $( this )[ 0 ];
            formRes.reset();
        },
        buttons: [
            {
                text: 'Ok',
                click: function () {
                    edit_form_actions( this );
                    // json_get_table( RIGTH, cmd_arr );
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

    $( document ).on( "submit", '#edit_value_counts_form', function ( event ) {
        event.preventDefault();
        edit_form_actions( this );
        // json_get_table( RIGTH, cmd_arr );
        edit_form.dialog( "close" );
    } );

    RIGTH.on( 'click', '.counter_str_even, .counter_str_odd', function ( event ) {
        let edit_id = $( this ).attr( 'id' );
        let param = { 'id': edit_id.slice( 3 ) };

        loadFormValue.init( objEditForm );
        ReqestData.init( loadFormValue, 'ajax/loadform_value/', param );
        ReqestData.reqest();

        edit_form.dialog( "open" );
        event.preventDefault();
    } );

} );