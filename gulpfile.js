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
			package: 'HelpPress',
			domain:  'helppress',
		}))
		.pipe(gulp.dest('languages/helppress.pot'));
});

gulp.task('copy', ['translate'], function() {
	return gulp.src([
			'**',
			'!composer.json',
			'!composer.lock',
			'!gulpfile.js',
			'!includes/vendor/autoload.php',
			'!includes/vendor/composer/',
			'!includes/vendor/composer/**',
			'!node_modules/',
			'!node_modules/**',
			'!package.json',
		])
		.pipe(gulp.dest('helppress'));
});

gulp.task('zip', ['copy'], shell.task(`zip -r helppress-${pkg.version}.zip helppress`));

gulp.task('export', ['zip'], shell.task(`mv helppress-${pkg.version}.zip ~/Desktop/`));

gulp.task('clean', ['export'], function() {
	return del('helppress');
});

gulp.task('release', ['translate', 'copy', 'zip', 'export', 'clean']);
