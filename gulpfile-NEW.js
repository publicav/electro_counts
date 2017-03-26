var plumber = require( 'gulp-plumber' );
var gulp = require( 'gulp' );
var browserify = require( 'browserify' );
var tsify = require( "tsify" );
var source = require( 'vinyl-source-stream' );
//var buffer = require('vinyl-buffer');

var sourcemaps = require( 'gulp-sourcemaps' );
var gutil = require( "gulp-util" );

var watchify = require( "watchify" );
var uglify = require( 'gulp-uglify' );

var browserSync = require( 'browser-sync' );

var source = require( 'vinyl-source-stream' );
var buffer = require( 'vinyl-buffer' );
var del = require( 'del' );

var paths = {
    basedir: '.',
    src    : 'ts',
    entry  : '/edit_counts.ts',
    bundle : './dist/edit_counts.js',
    out    : 'dist'
};

var bundler = browserify( {
    basedir     : paths.basedir,
    debug       : false,
    entries     : [ paths.src + paths.entry ],
    transform   : [
        [ 'babelify',
            {
                presets: [ 'es2015' ],
                ignore : [ '/src/libs/**' ]
            }
        ]
    ],
    plugin      : [ watchify, [ tsify, { typescript: require( 'typescript' ) } ] ],
    ignore      : [ './src/libs/**' ],
    cache       : {},
    packageCache: {}
} );

bundler.on( 'log', gutil.log );

gulp.task( 'clean', function () {
    try {
        del.sync( paths.out + '/**/*' );
    } catch ( err ) {
    }
} );

gulp.task( 'libs', function () {
    return gulp.src( [ paths.src + '/libs/**' ] )
        .pipe( plumber() )
        .pipe( gulp.dest( paths.out + '/libs' ) )
} );

gulp.task( 'pages', [ 'libs' ], function () {
    return gulp.src( [ paths.src + '/**/*.html' ] )
        .pipe( plumber() )
        .pipe( gulp.dest( paths.out ) );
} );

gulp.task( 'bundle', function () {
    return bundler.bundle()
        .on( 'error', function ( err ) {
            gutil.log( err.message );
            browserSync.notify( err.message, 3000 );
            this.emit( 'end' );
        } )
        .pipe( plumber() )
        .pipe( source( paths.bundle ) )
        .pipe( buffer() )
        .pipe( sourcemaps.init( {
            loadMaps: false
        } ) )
        .pipe( uglify() )
        .pipe( sourcemaps.write( './' ) )
        .pipe( gulp.dest( paths.out ) );
} );

gulp.task( 'refresh', [ 'bundle' ], browserSync.reload );

gulp.task( 'watch', [ 'pages', 'bundle' ], function () {
    var watcher = gulp.watch( paths.src + '/**/*', [ 'refresh' ] );
    watcher.on( 'change', function ( event ) {
        console.log( 'File ' + event.path + ' was ' + event.type + ', running tasks...' );
    } );
} );

gulp.task( 'browser-sync', [ 'watch' ], function () {
    return browserSync( {
        server: {
            baseDir: paths.out
        }
    } );
} );

gulp.task( 'default', [ 'browser-sync' ] );
