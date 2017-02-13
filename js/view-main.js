/**
 * Created by valik on 10.02.2017.
 */
function getUrlVars() {
    var vars = {}, hash;
    if ( location.search ) {
        var hashes = (location.search.substr( 1 )).split( '&' );
        for ( var i = 0; i < hashes.length; i++ ) {
            hash = hashes[ i ].split( '=' );
            vars[ hash[ 0 ] ] = hash[ 1 ];
        }
    }
    return vars;
}

const parseBASENAME = window.location.pathname.slice( 1 ).split( '/' );
const BASENAME = nameUrl( window.location.pathname );

var cmd_arr = {};
// var url = location.pathname;
cmd_arr = getUrlVars();
console.log( 'Testing1', cmd_arr );
// console.log(BASENAME);


function tableView( data ) {

    var nameGroup = data.nameGroup;
    var tableConst = '<table id="groupconter_t"  class="display" style="margin: 0 auto; padding: 0px 15px 10px 15px; width: 850px;" cellspacing="0" width="100%"><thead></thead><tbody></tbody></table>';
    var titleGroup = '<div style="font-size: 18pt; padding: 10px; text-align: center">' + nameGroup + '</div>'

    // table.destroy();
    $( "#table_div" ).html( '' );
    $( "#table_div" ).append( titleGroup + tableConst );
    //Таблица
    var default_options = {
        "pageLength": 25,
        aoColumnDefs: [
            // { bSortable: true, aTargets: [ 0 ] },
//            { type: 'date-dd-mmm-yyyy', atargets: 0 },
            { type: 'date-euro', targets: 0 },
            { bSortable: false, aTargets: [ '_all' ] }
        ],
        "aaData": data.calcData,
        "aoColumns": data.title,
        "scrollX": true
    };
    $( "#groupconter_t" ).dataTable( default_options );

}

function jsonGetGroup( cmd_arr ) {
    if ( Object.keys( cmd_arr ).length != 0 ) {
        $.ajax( { dataType: 'json', type: 'get', url: 'models/json/accounting_group.php', data: cmd_arr } )
            .success( function ( result ) {
                tableView( result );
                history.replaceState( cmd_arr, '', BASENAME + '?' + $.param( cmd_arr ) );
            } )
            .error( function ( result ) {
                    alert( 'Error - ' + result.responseJSON.error )
                }
            );
    }
}

function nameUrl( path ) {
    path = path.substring( path.lastIndexOf( "/" ) + 1 );
    return (path.match( /[^.]+(\.[^?#]+)?/ ) || [])[ 0 ];
}
