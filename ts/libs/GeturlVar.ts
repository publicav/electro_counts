/**
 * Created by valik on 30.03.2017.
 */
const getUrlVars1 = () => {
    let vars = {}, hash;
    if ( location.search ) {
        let hashes = (location.search.substr( 1 )).split( '&' );
        for ( let i = 0; i < hashes.length; i++ ) {
            hash = hashes[ i ].split( '=' );
            vars[ hash[ 0 ] ] = hash[ 1 ];
        }
    }
    return vars;
};
function nameUrl( path ) {
    path = path.substring( path.lastIndexOf( "/" ) + 1 );
    return (path.match( /[^.]+(\.[^?#]+)?/ ) || [])[ 0 ];
}

export { getUrlVars1,nameUrl };
