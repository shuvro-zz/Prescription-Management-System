var gulp = require('gulp');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');
var cleanCSS = require('gulp-clean-css');
var install = require("gulp-install");

// Install gulp packages  CMD: gulp script
gulp.task('install', function(){
	gulp.src('package.json')
		.pipe(install());
});

gulp.task('scripts', function() {
    gulp.src([
			'js/scripts/vendors/jquery.min.js',
			'js/lib/jquery-ui.js',
			'js/scripts/vendors/bootstrap.min.js',
			'js/scripts/plugins/screenfull.js',
			'js/scripts/plugins/perfect-scrollbar.min.js',
			'js/scripts/plugins/waves.min.js',
			'js/scripts/plugins/jquery.dataTables.min.js',
			'js/scripts/plugins/bootstrap-datepicker.min.js',
			'js/scripts/app.js',
			'js/scripts/tables.init.js',
			'js/scripts/plugins/select2.min.js',
			'js/scripts/jquery-validate/jquery.validate.js',
			'js/scripts/form-elements.init.js',
			'js/admin/admin-common.js'
		])
        .pipe(concat('gradpak-admin-scripts.js'))
        .pipe(uglify())
        .pipe(gulp.dest('build'))
});

gulp.task('styles', function() {
	gulp.src([
			'css/fonts/ionicons/css/ionicons.min.css',
			'css/lib/font-awesome.min.css',
			'css/styles/plugins/waves.css',
			'css/styles/plugins/perfect-scrollbar.css',
			'css/styles/vendors/admin.bootstrap.min.css',
			'css/styles/main.min.css',
			'css/styles/admin_custom.css',
			'css/styles/plugins/select2.css',
			'css/adminCss/dev_style.css',
			'css/lib/jquery-ui.css',
			'css/styles/plugins/summernote.css'
		])
		.pipe(concat('gradpak-admin-styles.css'))
		.pipe(cleanCSS())
		.pipe(gulp.dest('build'))
});


// Default Task
gulp.task('default', [           // CMD: gulp
	'scripts',
	'styles'
]);

