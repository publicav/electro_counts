import { RenderCounter }  from "./libs/RenderCounter";
import { RenderSubstation } from "./libs/RenderSubstation"
import { ReqestData } from "./libs/ReqestData";
import { LoadFormValue } from "./libs/LoadFormValue";
import { ActionForm } from "./libs/ActionForm";
import { FormSelectValueField } from "./libs/FormSelectValueField";
//import Select from './libs/MySelect';


$( () => {
    const RIGTH = $( '#right' );
    const LOT_EDIT = $( '#lot_edit' );
    const SUBSTATION_EDIT = $( '#substation_edit' );
    const COUNTER_EDIT = $( '#counter_edit' );
    const DATE_AIRING_BEGIN_EDIT = $( '#date_airing_begin_edit' );
    const TIME_AIRING_BEGIN_EDIT = $( '#time_airing_begin_edit' );

    const renderCounter: RenderCounter = new RenderCounter( COUNTER_EDIT );
    const renderSubststion: RenderSubstation = new RenderSubstation( SUBSTATION_EDIT, renderCounter );
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

    DATE_AIRING_BEGIN_EDIT.datepicker( { changeYear: true, dateFormat: 'dd-mm-yy' } );

    $.mask.definitions[ 'H' ] = '[012]';
    $.mask.definitions[ 'M' ] = '[012345]';
    $.mask.definitions[ 'F' ] = '[0-9.]+';

    TIME_AIRING_BEGIN_EDIT.mask( 'H9:M9' );

    LOT_EDIT.change( function () {
        let lot = $( this ).val();
        renderSubststion.Value1 = 0;
        const ReqestLot: ReqestData = new ReqestData( renderSubststion, 'ajax/subst/', { data: lot }, 'get' );
        ReqestLot.reqest();
    } );

    SUBSTATION_EDIT.change( function () {
        let substation = $( this ).val();
        const ReqestSubstation: ReqestData = new ReqestData( renderCounter, 'ajax/counter/', { data: substation }, 'get' );
        ReqestSubstation.reqest();
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
                    editFormActions.setModeAction = 'edit';
                    editFormActions.doActions();
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
        editFormActions.setModeAction = 'edit';
        editFormActions.doActions();
        // json_get_table( RIGTH, cmd_arr );
        edit_form.dialog( "close" );
    } );

    RIGTH.on( 'click', '.counter_str_even, .counter_str_odd', function ( event ) {
        let edit_id = $( this ).attr( 'id' );
        let param = { 'id': edit_id.slice( 3 ) };


        const loadFormVal: LoadFormValue = new LoadFormValue( renderSubststion, objEditForm );
        const reqestLoadForm: ReqestData = new ReqestData( loadFormVal, 'ajax/loadform_value/', param );
        reqestLoadForm.reqest();

        edit_form.dialog( "open" );
        event.preventDefault();
    } );

} );