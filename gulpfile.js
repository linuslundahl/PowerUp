var gulp           = require('gulp'),
    mainBowerFiles = require('main-bower-files'),
    $              = require('gulp-load-plugins')();

var handleError = function (err) {
  $.notify.onError()(err);
  this.emit('end');
};

// Default
gulp.task('default', function () {
  $.livereload.listen();
  gulp.watch('assets/sass/**/*.scss', ['sass']);
  gulp.watch('assets/stylesheets/*.css').on('change', $.livereload.changed);
  gulp.watch('assets/javascripts/**/*.js', ['lint', 'scripts']).on('change', $.livereload.changed);
  gulp.watch('bower.json', ['lint', 'scripts']).on('change', $.livereload.changed);
  gulp.watch('templates/*.inc').on('change', $.livereload.changed);
});

// SASS
gulp.task('sass', function () {
  return gulp.src('assets/sass/**/*.scss')
    .pipe($.rubySass({
      compass : true,
      sourcemap : 'auto'
    }).on('error', handleError))
    .pipe($.autoprefixer())
    .pipe(gulp.dest('assets/stylesheets'))
    .pipe($.rename({ suffix: '.min' }))
    .pipe($.minifyCss({
      keepSpecialComments : 0
    }))
    .pipe(gulp.dest('assets/stylesheets'));
});

// Script linting
gulp.task('lint', function () {
  return gulp.src('assets/javascripts/custom/*.js')
    .pipe($.jshint())
    .pipe($.jshint.reporter('jshint-stylish'))
    .pipe($.notify(function (file) {
      if (file.jshint.success) {
        return false;
      }

      var errors = file.jshint.results.map(function (data) {
        if (data.error) {
          return "(" + data.error.line + ':' + data.error.character + ') ' + data.error.reason;
        }
      }).join("\n");
      return file.relative + " (" + file.jshint.results.length + " errors)\n" + errors;
    }));
});

// Script concat and uglify
gulp.task('scripts', function () {
  return gulp.src('assets/javascripts/custom/*.js')
    .pipe($.concat('scripts.js'))
    .pipe(gulp.dest('assets/javascripts'))
    .pipe($.rename({ suffix: '.min' }))
    .pipe($.uglify())
    .pipe(gulp.dest('assets/javascripts'));
});

// Plugins from bower scripts concat and uglify
gulp.task('plugins', function () {
  return gulp.src(mainBowerFiles())
    .pipe($.concat('plugins.js'))
    .pipe(gulp.dest('assets/javascripts'))
    .pipe($.rename({ suffix: '.min' }))
    .pipe($.uglify())
    .pipe(gulp.dest('assets/javascripts'));
});
