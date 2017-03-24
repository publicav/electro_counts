var gulp = require('gulp');
var plumber = require('gulp-plumber');
var browserify = require('browserify');
var tsify = require("tsify");
var source = require('vinyl-source-stream');
//var buffer = require('vinyl-buffer');

var vendors = [
];

gulp.task('build:app', () => {
	
    browserify({
        entries: ['./ts/edit_counts.ts'],
        extensions: ['.ts', '.tsx'],
        debug: false
    })
    .external(vendors)
    .plugin(tsify, {
        typescript: require('typescript')
    })
    .bundle()
	//.pipe(plumber)
    .pipe(source('./js/edit_counts.js'))
    .pipe(gulp.dest('./'));
});

gulp
    .watch('./ts/**/*.{ts,tsx,json}', ['build:app'])
    .on('change', onchange)
    .on('error', onerror);

gulp.task('default', ['build:app']);

function onchange(event) {
    console.log('File ' + event.path + ' was ' + event.type);
}

function onerror(error) {
    console.error(
        error.toString()
    );
	this.emit('end');
}