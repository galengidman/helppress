var autoprefixer  = require('autoprefixer');
var del           = require('del');
var fs            = require('fs');
var gulp          = require('gulp');
var perfectionist = require('perfectionist');
var postcss       = require('gulp-postcss');
var sass          = require('gulp-sass');
var shell         = require('gulp-shell');
var wpPot         = require('gulp-wp-pot');
var zip           = require('gulp-zip');

var pkg = JSON.parse(fs.readFileSync('package.json'));

// DEV ------------------------------------------------------------------------

gulp.task('scss', function() {
  return gulp.src('assets/scss/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss([
    	autoprefixer(),
    	perfectionist(),
    ]))
    .pipe(gulp.dest('assets/css'));
});

gulp.task('dev', function() {
  gulp.watch('assets/scss/**/*.scss', ['scss']);
});

gulp.task('default', ['dev']);

// RELEASE --------------------------------------------------------------------

gulp.task('translate', function() {
	return gulp.src('**/*.php')
		.pipe(wpPot({
			domain: 'hpkb',
			package: 'HelpPress',
		}))
		.pipe(gulp.dest(`languages/${pkg.name}.pot`));
});

gulp.task('copy', ['translate'], function() {
	return gulp.src('**')
		.pipe(gulp.dest(pkg.name));
});

gulp.task('zip', ['copy'], function() {
	shell.task(`zip -r ${pkg.name}-${pkg.version}.zip ${pkg.name}`);
});

gulp.task('export', ['zip'], function() {
	shell.task(`mv ${pkg.name}-${pkg.version}.zip ~/Desktop/`);
});

gulp.task('clean', ['export'], function() {
	return del(pkg.name);
});

gulp.task('release', ['translate', 'copy', 'zip', 'export', 'clean']);
