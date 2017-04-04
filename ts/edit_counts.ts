import { ReqestData } from "./libs/ReqestData";
import { LoadFormValue } from "./libs/LoadFormValue";
import { ActionForm } from "./libs/ActionForm";
import { FormSelectValueField } from "./libs/FormSelectValueField";
import Select from "./libs/MySelect";
import ReqestSelect from "./libs/ReqestSelect";
import RenderTablValCounter from "./libs/RenderTablValCounter";
import { getUrlVars1 } from "./libs/GeturlVar";

$( () => {
    // const form = $( 'edit_counter' );
    const RIGHT = $( '#right' );
    const LOT_EDIT = $( '#lot_edit' );
    const SUBSTATION_EDIT = $( '#substation_edit' );
    const COUNTER_EDIT = $( '#counter_edit' );
    const DATE_AIRING_BEGIN_EDIT = $( '#date_airing_begin_edit' );
    const TIME_AIRING_BEGIN_EDIT = $( '#time_airing_begin_edit' );

    const objEditForm: FormSelectValueField =
        new FormSelectValueField(
            LOT_EDIT,
            SUBSTATION_EDIT,
            COUNTER_EDIT,
            DATE_AIRING_BEGIN_EDIT,
            TIME_AIRING_BEGIN_EDIT,
            $( '#counter_val_edit' ),
            $( '#edit_id1' )
        );
    const selectLot = new Select( 'lot_edit' );
    selectLot.classHTML = 'input_selected';
    const selectSubs = new Select( 'substation_edit' );
    selectSubs.classHTML = 'input_selected';
    const selectCount = new Select( 'counter_edit' );
    selectCount.classHTML = 'input_selected';
    selectLot.render();
    selectSubs.render();
    selectCount.render();
    DATE_AIRING_BEGIN_EDIT.datepicker( { changeYear: true, dateFormat: 'dd-mm-yy' } );

    $.mask.definitions[ 'H' ] = '[012]';
    $.mask.definitions[ 'M' ] = '[012345]';
    $.mask.definitions[ 'F' ] = '[0-9.]+';

    TIME_AIRING_BEGIN_EDIT.mask( 'H9:M9' );

    $( document ).on( "change", '#lot_edit', function ( e ) {
        console.log( 'change lots' );
        let me = e.target;
        console.log( $( me ).val() );
        let val = $( me ).val();
        const primaer = [
            { url: 'ajax/subst', 'render': selectSubs },
            { url: 'ajax/counter', 'render': selectCount },
        ];
        const req = new ReqestSelect( primaer );
        req.data = val;
        req.reqest();

    } );

    $( document ).on( "change", '#substation_edit', function ( e ) {
        console.log( 'change subs' );
        let me = e.target;
        let val = $( me ).val();
        console.log( val );
        const primaer = [
            { url: 'ajax/counter', 'render': selectCount },
        ];
        const req = new ReqestSelect( primaer );
        req.data = val;
        req.reqest();
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
                    const editFormActions: ActionForm = new ActionForm( this );


                    let right = document.getElementById( 'right' );
                    right.innerHTML = '';

                    let table = new RenderTablValCounter();
                    table.render();
                    right.appendChild( table.elTitle );
                    right.appendChild( table.elTable );
                    right.appendChild( table.elnavigator );

                    const requstTable: ReqestData = new ReqestData( table, 'ajax/filterValue/', getUrlVars1(), 'get' );
                    // requstTable.reqest();
                    editFormActions.doActions( requstTable );
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
        const editFormActions: ActionForm = new ActionForm( this );


        let right = document.getElementById( 'right' );
        right.innerHTML = '';
        let table = new RenderTablValCounter();
        table.render();
        right.appendChild( table.elTitle );
        right.appendChild( table.elTable );
        right.appendChild( table.elnavigator );

        const requstTable: ReqestData = new ReqestData( table, 'ajax/filterValue/', getUrlVars1(), 'get' );
        // requstTable.reqest();
        editFormActions.doActions( requstTable );
        // json_get_table( RIGTH, cmd_arr );
        edit_form.dialog( "close" );
    } );


    RIGHT.on( 'click', '.counter_str_even, .counter_str_odd', function ( event ) {
        let edit_id = $( this ).attr( 'id' );
        let param = { 'id': edit_id.slice( 3 ) };
        const dependentFilters = [
            { url: 'ajax/lots', 'render': selectLot },
            { url: 'ajax/subst', 'render': selectSubs },
            { url: 'ajax/counter', 'render': selectCount },
        ];
        const req = new ReqestSelect( dependentFilters, 1 );

        const loadFormVal: LoadFormValue = new LoadFormValue( req, objEditForm );
        const reqestLoadForm: ReqestData = new ReqestData( loadFormVal, 'ajax/loadform_value/', param );
        reqestLoadForm.reqest();
        console.log( 'Param = ', getUrlVars1() );

        edit_form.dialog( "open" );
        event.preventDefault();

    } );

} );