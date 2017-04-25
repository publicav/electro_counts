import { getUrlVars1, nameUrl } from "./libs/GeturlVar";
import { iCMD_Line } from "./libs/CMD_Line";
import Select from "./libs/MySelect";
import { isetParam1, ReqestSelectLastVal } from "./libs/ReqestSelectLastVal";
$( () => {

    let gl_add_counts = 0, buttonpressed;
    let edit_arr = [];
    let objSelected = {
        objLot: $( '#lot' ),
        objSubstation: $( '#substation' ),
        objCounter: $( '#counter' ),
        objCounterLastVal: $( '#counter_last_val' ),
        url_substation: 'ajax/subst/',
        url_counter: 'ajax/counter/',
        editCounter: 0
    };

    // const BASENAME = nameUrl( window.location.pathname );
    let cmd_line: iCMD_Line = getUrlVars1();
    // const SELECTED_ACTIONS = 1, EDIT_ACTIONS = 2;
    const ADD_COUNTER_BTN_NAME = 'ok_f', EDIT_COUNTER_BTN_NAME = 'edit_f';

    const find_arr_id = ( arr, find_id ) => {
        let ret = -1;
        for ( let i = 0; i < arr.length; i++ )
            if ( arr[ i ].id == find_id ) {
                ret = i;
                break;
            }
        return ret;
    };

    let get_last_val = ( { objCounterLastVal, param } ) => {
        $.ajax( { dataType: 'json', type: 'post', url: 'ajax/lastvalue_counter/', data: param } )
            .done( ( result ) => {
                let data = result.data;
                objCounterLastVal.val( data.value );
            } )
            .fail( ( result ) => alert( 'Error' ) );
    };

    /**
     * Возвращает отформатированую строку введенных данных.
     * данные передаются ввиде одного объекта.
     * @param {string} name_lot строка содержащая участок ввода.
     * @param {string} name_substation строка содержащая подстанцию ввода.

     * @param {string} date  дата ввода.
     * @param {string} time  время ввода.
     * @param {number} value значение счётчика.
     * @param {number} id счётчика в базе.
     * @param {object} name_counter  массив объектов.

     * @return {string} row_add возвращает строку введенных данных.
     */
    let print_add_record = ( { name_lot, name_substation, name_counter, date, time, value, id } ) => {
        return `
			<div class="col_lots">${name_lot}</div>
			<div class="col_substation">${name_substation}</div> 
			<div class="col_counts">${name_counter}</div> 
			<div class="col_date">${date} ${time}</div> 
			<div class="col_value">${value}</div> 
			<a id="${id}">Правка</a>	
			`;

    };


    let add_form_actions = ( { form, objLot, objSubstation, objCounter, objBtnOk, objBtnEdit, objListRec, btnPress, gl_add_counts, edit_arr } ) => {
        let lot = objLot.val();
        let substation = objSubstation.val();
        let counts = objCounter.val();
        let m_method = $( form ).attr( 'method' );
        let m_action = $( form ).attr( 'action' );
        let m_data = $( form ).serialize(); // input1=value1&input2=value2..., только input=text

        m_data += `&lot=${lot}&counter=${counts}&substation=${substation}`;
        if ( btnPress.id == ADD_COUNTER_BTN_NAME ) m_data += '&actions=add';
        if ( btnPress.id == EDIT_COUNTER_BTN_NAME ) m_data += '&actions=edit';

        $.ajax( { dataType: 'json', type: m_method, url: m_action, data: m_data } )
            .done( ( result ) => {
                if ( result.success ) {
                    let data = result.data;
                    gl_add_counts++;

                    let row_edit = print_add_record( data );
                    let row_add = `<li>${row_edit}</li>`;

                    if ( btnPress.id == ADD_COUNTER_BTN_NAME ) ok_btn( data, row_add );
                    if ( btnPress.id == EDIT_COUNTER_BTN_NAME ) edit_btn( data, row_edit );


                }
                else  alert( result.error );
            } )
            .fail( ( result ) => alert( result.responseJSON.error ) );

        let ok_btn = ( data, row_add ) => {
            if ( gl_add_counts <= 10 ) {
                edit_arr.unshift( data );
                objListRec.prepend( row_add );
            } else {
                edit_arr.unshift( data );
                edit_arr.pop();
                objListRec.find( 'li:last' ).remove();
                objListRec.prepend( row_add );
            }
        };
        let edit_btn = ( data, row_edit ) => {
            let index = find_arr_id( edit_arr, data.id );
            edit_arr[ index ] = data;
            objBtnOk.button( "option", "disabled", false ); // - блокировка элемента с id=ADD_COUNTER_BTN_NAME
            objBtnEdit.button( "option", "disabled", true ); // - разблокировка элемента с id=EDIT_COUNTER_BTN_NAME
            objListRec.find( 'li:nth-child(' + ( index + 1 ) + ')' ).html( row_edit );
        }

    };

    let filter: isetParam1[] = [];
    let zero: number = 1;

    if ( 'id_lot' in cmd_line ) {
        filter.push( { setparam: cmd_line.id_lot } );
    } else {
        filter.push( { setparam: zero } );
    }
    if ( 'id_sub' in cmd_line ) {
        filter.push( { setparam: cmd_line.id_sub } );
    } else {
        filter.push( { setparam: zero } );
    }
    if ( 'id_counter' in cmd_line ) {
        filter.push( { setparam: cmd_line.id_counter } );
    } else {
        filter.push( { setparam: zero } );
    }

    // let edit_id = $( this ).attr( 'id' );
    console.log( 'cmd array ->', cmd_line );
    console.log( 'filter ->', filter );

    const selectLot = new Select( 'lot' );
    selectLot.classHTML = 'input_selected';
    const selectSubs = new Select( 'substation' );
    selectSubs.classHTML = 'input_selected';
    const selectCount = new Select( 'counter' );
    selectCount.classHTML = 'input_selected';
    selectLot.render();
    selectSubs.render();
    selectCount.render();

    const dependentFilters = [
        { url: 'ajax/lots', 'render': selectLot },
        { url: 'ajax/subst', 'render': selectSubs },
        { url: 'ajax/counter', 'render': selectCount },
    ];
    const req = new ReqestSelectLastVal( dependentFilters, 1 );
    req.lastEl = $( '#counter_last_val' );
    req.param = filter;
    req.reqestMod();
    console.log( 'Param = ', getUrlVars1() );

    $( '#date_airing_begin' ).datepicker( { changeYear: true, dateFormat: 'dd-mm-yy' } );

    $.mask.definitions[ 'H' ] = '[012]';
    $.mask.definitions[ 'M' ] = '[012345]';
    $.mask.definitions[ 'F' ] = '[0-9.]+';
    $( '#time_airing_begin' ).mask( 'H9:M9' );
    console.log( objSelected );
//	get_substation(objSelected, $('#lot').val());

    $( document ).on( "change", '#lot', function ( e ) {
        console.log( 'change lots' );
        let me = e.target;
        console.log( $( me ).val() );
        let val = $( me ).val();
        const primaer = [
            { url: 'ajax/subst', 'render': selectSubs },
            { url: 'ajax/counter', 'render': selectCount },
        ];
        const req = new ReqestSelectLastVal( primaer );
        req.lastEl = $( '#counter_last_val' );
        req.data = val;
        req.reqestMod();
        let counter = objSelected.objCounter.val();
    } );
    $( document ).on( "change", '#substation', function ( e ) {
        console.log( 'change subs' );
        let me = e.target;
        let val = $( me ).val();
        console.log( val );
        const primaer = [
            { url: 'ajax/counter', 'render': selectCount },
        ];
        const req = new ReqestSelectLastVal( primaer );
        req.lastEl = $( '#counter_last_val' );
        req.data = val;
        req.reqestMod();
        $( '#counter_val' ).val( '' );
    } );
    $( document ).on( "change", '#counter', function ( e ) {
        let me = e.target;
        let val = $( me ).val();
        console.log( val );

        $( '#counter_val' ).val( '' );
    } );

    $( '#counter_val' ).keydown( function ( event ) {
        // Разрешаем: backspace, delete, tab и escape
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 ||
            // Разрешаем: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) || (event.keyCode == 188) || (event.keyCode == 190) ||
            (event.keyCode == 116 && event.ctrlKey === true) || (event.keyCode == 110) ||
            // Разрешаем: home, end, влево, вправо
            (event.keyCode >= 35 && event.keyCode <= 39) ) {
            // Ничего не делаем
            return;
        }
        else {
            // Обеждаемся, что это цифра, и останавливаем событие keypress
            if ( (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 ) ) {
                event.preventDefault();
            }
        }
    } );

    $( '#counter_val' ).keyup( function () {
        let counterVal = $( this ).val();
        let counterLastVal = $( '#counter_last_val' ).val();
        if ( objSelected.editCounter == 0 ) {
            if ( counterVal.length > 0 ) {
                counterVal = counterVal.replace( ',', '.' );
                let dtVal = +counterVal - +counterLastVal;
                if ( dtVal >= 0 ) {
                    $( this ).removeClass( 'bad_cell' ).addClass( 'good_cell' );
                } else {
                    $( this ).removeClass( 'good_cell' ).addClass( 'bad_cell' );
                }
                console.log( 'This - > ', counterVal, typeof(counterVal), dtVal );
            }
        } else    $( '#counter_last_val' ).removeClass( 'good_cell' ).removeClass( 'bad_cell' ).addClass( 'norm_cell' );
    } );

    $( '#list_counts' ).on( 'click', 'a', function ( event ) {
        let arr_id = $( this ).attr( 'id' );
        let index = find_arr_id( edit_arr, arr_id );
        let lot_value = edit_arr[ index ].lot;
        let substation_value = edit_arr[ index ].substation;
        let couner_value = edit_arr[ index ].counter;
        objSelected.editCounter = 1;
        $( '#counter_last_val' ).val( '' );
        $( '#counter_val' ).removeClass( 'good_cell' ).removeClass( 'bad_cell' ).addClass( 'norm_cell' );

        // $( '#lot' ).find( '[value="' + lot_value + '"]' ).prop( "selected", true );
        //
        // get_substation( objSelected, lot_value, EDIT_ACTIONS, substation_value, couner_value );

        $( '#date_airing_begin' ).val( edit_arr[ index ].date );
        $( '#time_airing_begin' ).val( edit_arr[ index ].time );
        $( '#counter_val' ).val( edit_arr[ index ].value );
        $( '#edit_id' ).val( arr_id );

        $( '#ok_f' ).button( "option", "disabled", true ); // - блокировка элемента с id=ok_f
        $( '#edit_f' ).button( "option", "disabled", false ); // - блокировка элемента с id=edit_f

        event.preventDefault();

    } );

    $( 'input[type=submit], a, button' ).button().click( function () {
        buttonpressed = $( this ).attr( 'id' );
    } );

    $( '#add_value_counts_form' ).submit( function ( event ) {
        event.preventDefault();
        let me = this;
        const btn = { id: buttonpressed };
        buttonpressed = '';
        const obj = {
            form: me,
            objBtnOk: $( '#ok_f' ),
            objBtnEdit: $( '#edit_f' ),
            btnPress: btn,
            objListRec: $( '#list_counts' ),
            gl_add_counts,
            edit_arr,
            __proto__: objSelected
        }

        // add_form_actions( obj );
        objSelected.editCounter = 0;

    } );

} );