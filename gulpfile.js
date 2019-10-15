var gulp = require('gulp');
var rename = require('gulp-rename');
var pkg = JSON.parse(require('fs').readFileSync('package.json'));

// DEV -------------------------------------------------------------------------

function css() {
	var perfectionist = require('perfectionist');
	var postcss = require('gulp-postcss');
	var sass = require('gulp-sass');

	return gulp.src('assets/scss/*.scss')
		.pipe(sass().on('error', sass.logError))
		.pipe(postcss([
			require('autoprefixer')(),
			perfectionist(),
		]))
		.pipe(gulp.dest('assets/dist'))
		.pipe(postcss([
			require('cssnano')(),
			perfectionist({ format: 'compressed' })
		]))
		.pipe(rename({ suffix: '.min' }))
		.pipe(gulp.dest('assets/dist'));
}

function js() {
	return gulp.src('assets/js/*.js')
		.pipe(gulp.dest('assets/dist'))
		.pipe(require('gulp-uglify')())
		.pipe(rename({ suffix: '.min' }))
		.pipe(gulp.dest('assets/dist'));
}

function watch() {
	gulp.watch('assets/scss/**/*.scss', css);
	gulp.watch('assets/js/**/*.js', js);
}

exports.css = css;
exports.js = js;
exports.default = watch;

// RELEASE ---------------------------------------------------------------------

gulp.task('release', require('gulp-shell').task(`zip -r ${pkg.name}-${pkg.version}.zip ${pkg.name} assets/* includes/* templates/* demo-content/* *.php *.txt && mv ${pkg.name}-${pkg.version}.zip ~/Desktop`))
