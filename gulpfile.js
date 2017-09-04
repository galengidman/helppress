var del   = require('del');
var fs    = require('fs');
var gulp  = require('gulp');
var shell = require('gulp-shell');
var wpPot = require('gulp-wp-pot');
var zip   = require('gulp-zip');

var pkg = JSON.parse(fs.readFileSync('package.json'));

gulp.task('translate', function() {
	return gulp.src('**/*.php')
		.pipe(wpPot({
			domain: 'hpkb',
			package: 'HelpPress',
		}))
		.pipe(gulp.dest('languages/' + pkg.name + '.pot'));
});

gulp.task('copy', ['translate'], function() {
	return gulp.src('**')
		.pipe(gulp.dest(pkg.name));
});

gulp.task('zip', ['copy'], function() {
	shell.task('zip -r ' + pkg.name + '-' + pkg.version + '.zip ' + pkg.name);
});

gulp.task('export', ['zip'], function() {
	shell.task('mv ' + pkg.name + '-' + pkg.version + '.zip ~/Desktop/');
});

gulp.task('clean', ['export'], function() {
	return del(pkg.name);
});

gulp.task('default', ['translate', 'copy', 'zip', 'export', 'clean']);
