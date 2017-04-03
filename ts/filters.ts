import { getUrlVars1 } from "./libs/GeturlVar";
import { iCMD_Line } from "./libs/CMD_Line";
import Select from "./libs/MySelect";
import ReqestSelect from "./libs/ReqestSelect";

$( () => {
    const RIGHT = $( '#right' );
    const SELECTED_ACTIONS = 1, EDIT_ACTIONS = 2;
    const parseBASENAME = window.location.pathname.slice( 1 ).split( '/' );
    const BASENAME = parseBASENAME[ parseBASENAME.length - 1 ];
    const base_link = BASENAME;
    const objFiltred = {
        objSubstation : $( '#substation' ),
        objCounter    : $( '#counter' ),
        url_substation: 'ajax/subst_filter/',
        url_counter   : 'ajax/counter_filter/'
    };

    const selectLot = new Select( 'lot_edit' );
    selectLot.classHTML = 'filtred_selected';
    const selectSubs = new Select( 'substation_edit' );
    selectSubs.classHTML = 'filtred_selected';
    const selectCount = new Select( 'counter_edit' );
    selectCount.classHTML = 'filtred_selected';
    selectLot.render();
    selectSubs.render();
    selectCount.render();

    let cmd_line: iCMD_Line = getUrlVars1();
    json_get_table( $( '#right' ), cmd_line );

    $.datepicker.setDefaults(
        $.extend( $.datepicker.regional[ "ru" ] )
    );

    // Востанавливаем значения фильтров если была перезагрузка страницы через F5 или обновить
    if ( ('id_lot' in cmd_line) && ('id_sub' in cmd_line) && ('id_counter' in cmd_line) ) {
        // $( '#lot [value="' + cmd_line.id_lot + '"]' ).prop( "selected", true );

        get_substation( objFiltred, cmd_line.id_lot, EDIT_ACTIONS, cmd_line.id_sub, cmd_line.id_counter );

    } else {
        if ( ('id_lot' in cmd_line) && ('id_sub' in cmd_line) ) {
            // $( '#lot [value="' + cmd_line.id_lot + '"]' ).prop( "selected", true );
            get_substation( objFiltred, cmd_line.id_lot, EDIT_ACTIONS, cmd_line.id_sub );
        } else {
            if ( 'id_lot' in cmd_line ) {
                // $( '#lot [value="' + cmd_line.id_lot + '"]' ).prop( "selected", true );
                get_substation( objFiltred, cmd_line.id_lot );
            }
        }
    }

    if ( 'date_b' in cmd_line ) {
        $( "#dt1_en" ).attr( "checked", "checked" );
        $( '#dt2_en' ).prop( 'disabled', false );
        $( "#dt1" ).datepicker( 'enable' );
        console.log( 'date_b in cmd_line' );
    }
    if ( 'date_e' in cmd_line ) {
        $( "#dt2_en" ).attr( "checked", "checked" );
        $( "#dt2" ).datepicker( 'enable' );
        console.log( 'date_e in cmd_line' );
    }

    $( '#lot' ).change( function () {
        let lot = $( this ).val();
        cmd_line.id_lot = lot;
        console.log( cmd_line );
        if ( lot == 0 ) {
            delete cmd_line.id_lot;
            delete cmd_line.id_sub;
            delete cmd_line.id_counter;
            delete cmd_line.st;
        } else {
            delete cmd_line.st;
            delete cmd_line.id_sub;
            delete cmd_line.id_counter;
            $( '#substation' ).prop( 'disabled', false );
        }
        console.log( cmd_line );

        get_substation( objFiltred, lot );

        json_get_table( $( '#right' ), cmd_line );
    } );
// Изменение подстанции фильр выбора		
    $( '#substation' ).change( function () {
        let lot = $( '#lot' ).val();
        let substation = $( this ).val();
        cmd_line.id_lot = lot;
        cmd_line.id_sub = substation;

        if ( substation == 0 ) {
            delete cmd_line.id_sub;
            delete cmd_line.id_counter;
            delete cmd_line.st;

        } else {
            delete cmd_line.st;
            delete cmd_line.id_counter;
        }
        get_counter( objFiltred, substation );
        json_get_table( $( '#right' ), cmd_line );
    } );
// Изменение ячейки фильр выбора		
    $( '#counter' ).change( function () {
        cmd_line.id_lot = $( '#lot' ).val();
        cmd_line.id_sub = $( '#substation' ).val();
        cmd_line.id_counter = $( this ).val();
        if ( cmd_line.id_counter == 0 ) {
            delete cmd_line.id_counter;
        }
        json_get_table( $( '#right' ), cmd_line );
    } );

    $( '.filtred_checkbox' ).on( 'click', function ( e ) {
        let checkbox_id = $( this ).attr( 'id' );
        let lot = $( '#lot' ).val();

        if ( (checkbox_id == 'dt1_en') )
            if ( $( '#dt1_en' ).prop( 'checked' ) ) {
                delete cmd_line.st;

                $( '#dt2_en' ).prop( 'disabled', false );

                $( "#dt1" ).datepicker( 'enable' );
                cmd_line.date_b = $( "#dt1" ).datepicker().val();
                json_get_table( $( '#right' ), cmd_line );
            } else {
                delete cmd_line.date_b;
                delete cmd_line.st;
                delete cmd_line.date_e;

                $( '#dt2_en' ).prop( 'disabled', true );
                $( '#dt2_en' ).prop( 'checked', false );


                $( "#dt1" ).datepicker( 'disable' );
                $( "#dt2" ).datepicker( 'disable' );

                json_get_table( $( '#right' ), cmd_line );
            }

        if ( (checkbox_id == 'dt2_en') )
            if ( $( '#dt2_en' ).prop( 'checked' ) ) {
                delete cmd_line.st;

                $( "#dt2" ).datepicker( 'enable' );
                cmd_line.date_e = $( "#dt2" ).datepicker().val();
                json_get_table( $( '#right' ), cmd_line );
            } else {
                delete cmd_line.date_e;
                delete cmd_line.st;

                $( "#dt2" ).datepicker( 'disable' );
                json_get_table( $( '#right' ), cmd_line );
            }
    } );

    $( "#dt1" ).datepicker( {
        changeYear: true, changeMonth: true, minDate: '2016-01-01', maxDate: '0', dateFormat: 'yy-mm-dd',
        onSelect  : function ( dateText, inst ) {
            cmd_line.date_b = dateText;
            json_get_table( $( '#right' ), cmd_line );
        }
    } );

    $( "#dt2" ).datepicker( {
        changeYear: true, changeMonth: true, minDate: '2016-01-01', maxDate: '0', dateFormat: 'yy-mm-dd',
        onSelect  : function ( dateText, inst ) {
            cmd_line.date_e = dateText;
            json_get_table( $( '#right' ), cmd_line );
        }
    } );

    if ( !$( '#dt1_en' ).prop( 'checked' ) ) $( "#dt1" ).datepicker( 'disable' );
    if ( !$( '#dt2_en' ).prop( 'checked' ) ) $( "#dt2" ).datepicker( 'disable' );

    RIGHT.on( 'click', 'a', function ( event ) {
        event.preventDefault();
        // console.log(event.target.search);
        let param = event.target.search;
        if ( param != '' ) {
            let stArr = (param.substr( 1 )).split( '&' );
            for ( let i = 0; i < stArr.length; i++ ) {
                let st = stArr[ i ].split( '=' );       // массив param будет содержать
                if ( st[ 0 ] == 'st' ) {
                    if ( st[ 1 ] != 0 ) cmd_line.st = st[ 1 ]; else delete cmd_line.st;
                }
            }
        }
        console.log( cmd_line );
        json_get_table( $( '#right' ), cmd_line );
    } );
    $( document ).tooltip( {
        content: function () {
            return this.getAttribute( "title" )
        }
    } );
} );