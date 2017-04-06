var plumber = require( 'gulp-plumber' );
var gulp = require( 'gulp' );
var browserify = require( 'browserify' );
var tsify = require( "tsify" );
var source = require( 'vinyl-source-stream' );
var gutil = require( "gulp-util" );
var uglify = require( 'gulp-uglify' );

var buffer = require( 'vinyl-buffer' );

var vendors = [];

gulp.task( 'build:edit_counts', () => {

    browserify( {
        entries: [ './ts/edit_counts.ts' ],
        extensions: [ '.ts', '.tsx' ],
        debug: false
    } )
    //.external(vendors)
        .plugin( tsify, {
            typescript: require( 'typescript' )
        } )
        .bundle()
        .on( 'error', onerror )
        .pipe( plumber() )
        .pipe( source( './js/edit_counts.js' ) )
        .pipe( buffer() )
        //.pipe( uglify() )
        .pipe( gulp.dest( './' ) );
} );

gulp.task( 'build:test', () => {

    browserify( {
        entries: [ './ts/test.ts' ],
        extensions: [ '.ts', '.tsx' ],
        debug: false
    } )
    //.external(vendors)
        .plugin( tsify, {
            typescript: require( 'typescript' )
        } )
        .bundle()
        .on( 'error', onerror )
        .pipe( plumber() )
        .pipe( source( './js/test.js' ) )
        .pipe( buffer() )
        //.pipe( uglify() )
        .pipe( gulp.dest( './' ) );
} );

gulp.task( 'build:filters', () => {

    browserify( {
        entries: [ './ts/filters.ts' ],
        extensions: [ '.ts', '.tsx' ],
        debug: false
    } )
    //.external(vendors)
        .plugin( tsify, {
            typescript: require( 'typescript' )
        } )
        .bundle()
        .on( 'error', onerror )
        .pipe( plumber() )
        .pipe( source( './js/filters.js' ) )
        .pipe( buffer() )
        //.pipe( uglify() )
        .pipe( gulp.dest( './' ) );
} );
gulp.task( 'bld:filters-calc', () => {

    browserify( {
        entries: [ './ts/filters-calc.ts' ],
        extensions: [ '.ts', '.tsx' ],
        debug: false
    } )
    //.external(vendors)
        .plugin( tsify, {
            typescript: require( 'typescript' )
        } )
        .bundle()
        .on( 'error', onerror )
        .pipe( plumber() )
        .pipe( source( './js/filters-calc.js' ) )
        .pipe( buffer() )
        //.pipe( uglify() )
        .pipe( gulp.dest( './' ) );
} );

gulp
    .watch( './ts/**/*.{ts,tsx,json}',
        [
            'build:edit_counts',
            'build:test',
            'build:filters',
            'bld:filters-calc'
        ] )
    .on( 'change', onchange )
    .on( 'error', onerror );

gulp.task( 'default', [ 'build:edit_counts', 'build:test', 'build:filters', 'bld:filters-calc' ] );

function onchange( event ) {
    console.log( 'File ' + event.path + ' was ' + event.type );
}

function onerror( error ) {
    gutil.log( error.message );
    this.emit( 'end' );
}