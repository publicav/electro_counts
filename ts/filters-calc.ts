import { getUrlVars1, nameUrl } from "./libs/GeturlVar";
import { iCMD_Line } from "./libs/CMD_Line";
import Select from "./libs/MySelect";
import { isetParam1, ReqestSelect } from "./libs/ReqestSelect";

$( () => {

    const RIGHT = $( '#right' );
    const dt1 = $( "#dt1" );
    const dt2 = $( "#dt2" );
    const dt1_en = $( "#dt1_en" );
    const dt2_en = $( "#dt2_en" );
    const BASENAME = nameUrl( window.location.pathname );
    let cmd_line: iCMD_Line = getUrlVars1();

    let print_t_calc = ( data ) => {
        let count = 0, class_e;
        let title = data.title;
        let counter = data.Data;
        let st = `	<div class="title_table_counter">
					<div class="title_calc_counter">Ячейка</div>
					<div class="title_calc_date">Дата</div>
					<div class="title_calc_value">Значение</div>
				</div>`;

        for ( let key in counter ) {
            if ( count % 2 != 0 ) class_e = 'counter_str_odd'; else class_e = 'counter_str_even';
            if ( counter[ key ].rare < 0 ) class_e = 'counter_str_err';
            st += `	<div class="${class_e}" title="Расчёт">
					<div class="colum_calc_counter">${title}</div>
					<div class="colum_calc_date">${counter[ key ][ 0 ]}</div>
					<div class="colum_calc_value">${counter[ key ][ 1 ]}</div>
				</div>`;
            count++;
        }
        return st;
    };

    let json_get_t_calc = ( objTarget, cmd_line ) => {
        $.ajax( { dataType: 'json', type: 'get', url: 'ajax/calculation_counter/', data: cmd_line } )
            .done( ( result ) => {
                if ( result.success ) {
                    // let data = result.data;
                    objTarget.html( print_t_calc( result ) );
                    objTarget.append( result.navigator );
                    history.replaceState( cmd_line, '', BASENAME + '?' + $.param( cmd_line ) );
                } else  alert( result.error );
            } )
            .fail( ( result ) => alert( 'Error' ) );
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


    json_get_t_calc( RIGHT, cmd_line );

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
            delete cmd_line.date_b;
        } else {
            delete cmd_line.date_b;
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

        json_get_t_calc( RIGHT, cmd_line );

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
            delete cmd_line.date_b;
        } else {
            delete cmd_line.date_b;
            delete cmd_line.id_counter;
        }

        const primaer = [
            { url: 'ajax/counter_filter', 'render': selectCount },
        ];
        const req = new ReqestSelect( primaer );
        req.data = val;
        req.reqest();

        json_get_t_calc( RIGHT, cmd_line );
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
        json_get_t_calc( RIGHT, cmd_line );

    } );

    RIGHT.on( 'click', 'a', function ( event ) {
        event.preventDefault();
        let paramAll, param;
        let paramStr = event.target;
        paramAll = $( paramStr ).attr( 'href' );
        paramAll = paramAll.split( '?' );
        param = '?' + paramAll[ 1 ];
        console.log( param );
        if ( param != '' ) {
            let stArr = (param.substr( 1 )).split( '&' );
            console.log( stArr );
            for ( let i = 0; i < stArr.length; i++ ) {
                let st = stArr[ i ].split( '=' );       // массив param будет содержать
                if ( st[ 0 ] == 'date_b' ) {
                    console.log( st[ 0 ] );
                    if ( st[ 1 ] != 0 ) cmd_line.date_b = st[ 1 ]; else delete cmd_line.date_b;
                    break;
                }
            }
        }

        console.log( cmd_line );
        json_get_t_calc( RIGHT, cmd_line );
    } );

    // Переход со страницы расход на страницу редактирования
    $( '#edit_count' ).on( 'click', function ( e ) {
        const mount = [ '31', '28', '31', '30', '31', '30', '31', '31', '30', '31', '30', '31' ];
        const param = cmd_line;
        if ( 'date_b' in cmd_line ) {
            let dtBg = cmd_line.date_b;
            let dtArr = dtBg.split( '-' );
            if ( !(Number( dtArr[ 0 ] ) % 4) ) mount[ 1 ] = '29';
            param.date_e = dtArr[ 0 ] + '-' + dtArr[ 1 ] + '-' + mount[ Number( dtArr[ 1 ] ) - 1 ];
            param.date_b = dtArr[ 0 ] + '-' + dtArr[ 1 ] + '-' + '01';
            console.log( param );
        }
        window.location.href = $( '#edit_count' ).attr( 'href' ) + '?' + $.param( param );
        e.preventDefault();
    } );

    $( document ).tooltip( {
        content: function () {
            return this.getAttribute( "title" )
        }
    } );
} );