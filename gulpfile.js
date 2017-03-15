var gulp = require('gulp');
var sourcemaps = require('gulp-sourcemaps');
var source = require('vinyl-source-stream');
var buffer = require('vinyl-buffer');
var browserify = require('browserify');
var watchify = require('watchify');
var babel = require('babelify');
var gutil = require('gulp-util');
var sass = require('gulp-sass');

gulp.task('sass', function () {
  return gulp.src('./dest/sass/*.scss')
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./dest/css/'));
});

gulp.task('sass:watch', function () {
  gulp.watch('./dest/sass/*.scss', ['sass']);
});

function compile(watch) {
  var bundler = watchify(browserify('./dest/js/script.js', { debug: true, exclude: './dest/js/bundle.js' }).transform(babel.configure({
    presets: ['es2015'],
  })));

  function rebundle() {
    bundler.bundle()
      .on('error', function(err) { console.error(err); this.emit('end'); })
      .pipe(source('bundle.js'))
      .pipe(buffer())
      .pipe(sourcemaps.init({ loadMaps: true }))
      .pipe(sourcemaps.write('./'))
      .pipe(gulp.dest('./dest/js'));
  }

  if (watch) {
    bundler.on('update', function() {
      console.log('-> bundling...');
      rebundle();
    });
  }

  rebundle();
}

function watch() {
  return compile(true);
};

gulp.task('build', ['sass'], function() { 
  compile();
});

gulp.task('watch', function() { 
  watch(); 
  gulp.watch('./dest/sass/*.scss', ['sass']);
  gutil.log(gutil.colors.bgGreen('Watching for changes...'));
});

gulp.task('default', ['watch']);