import { ReqestData } from "./libs/ReqestData";
import { getUrlVars1, nameUrl } from "./libs/GeturlVar";
import { iCMD_Line } from "./libs/CMD_Line";
import Select from "./libs/MySelect";
import { isetParam1, ReqestSelect } from "./libs/ReqestSelect";
import RenderTablValCounter from "./libs/RenderTablValCounter";


$( () => {

    const RIGHT = $( '#right' );
    const dt1 = $( "#dt1" );
    const dt2 = $( "#dt2" );
    const dt1_en = $( "#dt1_en" );
    const dt2_en = $( "#dt2_en" );
    const BASENAME = nameUrl( window.location.pathname );
    let cmd_line: iCMD_Line = getUrlVars1();

    let json_get_table = ( objTarget, cmd_line ) => {
        let right = document.getElementById( 'right' );
        let table = new RenderTablValCounter();
        right.innerHTML = '';
        table.render();
        right.appendChild( table.elTitle );
        right.appendChild( table.elTable );
        right.appendChild( table.elnavigator );

        const requstTable: ReqestData = new ReqestData( table, 'ajax/filterValue/', cmd_line, 'get' );
        requstTable.reqest();
        history.replaceState( cmd_line, '', BASENAME + '?' + $.param( cmd_line ) );

    };

    const selectLot = new Select( 'lot' );
    selectLot.classHTML = 'filtred_selected';
    const selectSubs = new Select( 'substation' );
    selectSubs.classHTML = 'filtred_selected';
    const selectCount = new Select( 'counter' );
    selectCount.classHTML = 'filtred_selected';
    selectLot.render();
    selectSubs.render();
    selectCount.render();

    let filter: isetParam1[] = [];
    let zero: number = 0;
    json_get_table( RIGHT, cmd_line );

    $.datepicker.setDefaults(
        $.extend( $.datepicker.regional[ "ru" ] )
    );


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

    const dependentFilters = [
        { url: 'ajax/lots_filter', 'render': selectLot },
        { url: 'ajax/subst_filter', 'render': selectSubs },
        { url: 'ajax/counter_filter', 'render': selectCount },
    ];
    console.log( filter, dependentFilters );
    const req = new ReqestSelect( dependentFilters, 1 );
    req.param = filter;
    req.reqest();


    if ( 'date_b' in cmd_line ) {
        dt1_en.attr( "checked", "checked" );
        dt2_en.prop( 'disabled', false );
        dt1.datepicker( 'enable' );
        console.log( 'date_b in cmd_line' );
    }
    if ( 'date_e' in cmd_line ) {
        dt2_en.attr( "checked", "checked" );
        dt2.datepicker( 'enable' );
        console.log( 'date_e in cmd_line' );
    }


    $( document ).on( "change", '#lot', function ( e ) {
        console.log( 'change lots' );
        let me = e.target;
        console.log( $( me ).val() );
        let val = $( me ).val();
        cmd_line.id_lot = val;
        if ( val == 0 ) {
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
        const primaer = [
            { url: 'ajax/subst_filter', 'render': selectSubs },
            { url: 'ajax/counter_filter', 'render': selectCount },
        ];
        const req = new ReqestSelect( primaer );
        req.data = val;
        req.reqest();

        json_get_table( RIGHT, cmd_line );

    } );

    $( document ).on( "change", '#substation', function ( e ) {
        console.log( 'change subs' );
        let me = e.target;
        let val = $( me ).val();
        let lot = $( '#lot' ).val();
        console.log( val );

        cmd_line.id_lot = lot;
        cmd_line.id_sub = val;

        if ( val == 0 ) {
            delete cmd_line.id_sub;
            delete cmd_line.id_counter;
            delete cmd_line.st;

        } else {
            delete cmd_line.st;
            delete cmd_line.id_counter;
        }

        const primaer = [
            { url: 'ajax/counter_filter', 'render': selectCount },
        ];
        const req = new ReqestSelect( primaer );
        req.data = val;
        req.reqest();

        json_get_table( RIGHT, cmd_line );
    } );

    $( document ).on( "change", '#counter', function ( e ) {
        console.log( 'change counter' );
        cmd_line.id_lot = $( '#lot' ).val();
        cmd_line.id_sub = $( '#substation' ).val();
        let me = e.target;
        let val = $( me ).val();
        cmd_line.id_counter = val;
        console.log( val );
        if ( cmd_line.id_counter == 0 ) {
            delete cmd_line.id_counter;
        }
        json_get_table( RIGHT, cmd_line );

    } );

    $( '.filtred_checkbox' ).on( 'click', function () {
        let checkbox_id = $( this ).attr( 'id' );
        let lot = $( '#lot' ).val();

        if ( (checkbox_id == 'dt1_en') )
            if ( dt1_en.prop( 'checked' ) ) {
                delete cmd_line.st;

                dt2_en.prop( 'disabled', false );

                dt1.datepicker( 'enable' );
                cmd_line.date_b = dt1.datepicker().val();
                json_get_table( RIGHT, cmd_line );
            } else {
                delete cmd_line.date_b;
                delete cmd_line.st;
                delete cmd_line.date_e;

                dt2_en.prop( 'disabled', true );
                dt2_en.prop( 'checked', false );


                dt1.datepicker( 'disable' );
                dt2.datepicker( 'disable' );

                json_get_table( RIGHT, cmd_line );
            }

        if ( (checkbox_id == 'dt2_en') )
            if ( $( '#dt2_en' ).prop( 'checked' ) ) {
                delete cmd_line.st;

                dt2.datepicker( 'enable' );
                cmd_line.date_e = $( "#dt2" ).datepicker().val();
                json_get_table( RIGHT, cmd_line );
            } else {
                delete cmd_line.date_e;
                delete cmd_line.st;

                dt2.datepicker( 'disable' );
                json_get_table( RIGHT, cmd_line );
            }
    } );

    dt1.datepicker( {
        changeYear: true, changeMonth: true, minDate: '2016-01-01', maxDate: '0', dateFormat: 'yy-mm-dd',
        onSelect: function ( dateText ) {
            cmd_line.date_b = dateText;
            json_get_table( RIGHT, cmd_line );
        }
    } );

    dt2.datepicker( {
        changeYear: true, changeMonth: true, minDate: '2016-01-01', maxDate: '0', dateFormat: 'yy-mm-dd',
        onSelect: function ( dateText ) {
            cmd_line.date_e = dateText;
            json_get_table( RIGHT, cmd_line );
        }
    } );

    if ( !dt1_en.prop( 'checked' ) ) dt1.datepicker( 'disable' );
    if ( !dt2_en.prop( 'checked' ) ) dt2.datepicker( 'disable' );

    RIGHT.on( 'click', 'a', function ( event ) {
        event.preventDefault();
        let param;
        let paramStr = event.target;
        param = $( paramStr ).attr( 'href' );
        console.log( $( paramStr ).attr( 'href' ) );


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
        json_get_table( RIGHT, cmd_line );
    } );
    $( document ).tooltip( {
        content: function () {
            return this.getAttribute( "title" )
        }
    } );


} );