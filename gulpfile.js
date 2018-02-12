var autoprefixer  = require('autoprefixer');
var cssnano       = require('cssnano');
var del           = require('del');
var fs            = require('fs');
var gulp          = require('gulp');
var perfectionist = require('perfectionist');
var postcss       = require('gulp-postcss');
var rename        = require('gulp-rename');
var sass          = require('gulp-sass');
var shell         = require('gulp-shell');
var uglify        = require('gulp-uglify');
var zip           = require('gulp-zip');

var pkg = JSON.parse(fs.readFileSync('package.json'));

// DEV -------------------------------------------------------------------------

gulp.task('scss', function() {
	return gulp.src('assets/scss/*.scss')
		.pipe(sass().on('error', sass.logError))
		.pipe(postcss([
			autoprefixer(),
			perfectionist(),
		]))
		.pipe(gulp.dest('assets/dist'))
		.pipe(postcss([
			cssnano(),
			perfectionist({ format: 'compressed' })
		]))
		.pipe(rename({ suffix: '.min' }))
		.pipe(gulp.dest('assets/dist'));
});

gulp.task('js', function() {
	return gulp.src('assets/js/*.js')
		.pipe(gulp.dest('assets/dist'))
		.pipe(uglify())
		.pipe(rename({ suffix: '.min' }))
		.pipe(gulp.dest('assets/dist'));
});

gulp.task('dev', function() {
	gulp.watch('assets/scss/**/*.scss', ['scss']);
	gulp.watch('assets/scsjss/**/*.js', ['js']);
});

gulp.task('default', ['dev']);

// RELEASE ---------------------------------------------------------------------

gulp.task('copy', function() {
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
		.pipe(gulp.dest(`${pkg.name}`));
});

gulp.task('zip', ['copy'], shell.task(`zip -r ${pkg.name}-${pkg.version}.zip ${pkg.name}`));

gulp.task('export', ['zip'], shell.task(`mv ${pkg.name}-${pkg.version}.zip ~/Desktop/`));

gulp.task('clean', ['export'], function() {
	return del(`${pkg.name}`);
});

gulp.task('release', ['translate', 'copy', 'zip', 'export', 'clean']);
