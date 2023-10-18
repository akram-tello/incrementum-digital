// Requires Gulp v4.
// $ npm uninstall --global gulp gulp-cli
// $ rm /usr/local/share/man/man1/gulp.1
// $ npm install --global gulp-cli
// $ npm install
const { src, dest, watch, series, parallel } = require('gulp');
const browsersync = require('browser-sync').create();
const sass = require('gulp-dart-sass');
const autoprefixer = require('gulp-autoprefixer');
const sourcemaps = require('gulp-sourcemaps');
const plumber = require('gulp-plumber');
const sasslint = require('gulp-sass-lint');
const cache = require('gulp-cached');
const notify = require('gulp-notify');
const beeper = import('beeper');

// Compile CSS from Sass.
function buildStyles() {
  return src('static/scss/style.scss')
    .pipe(plumbError()) // Global error handler through all pipes.
    .pipe(sourcemaps.init())
    .pipe(sass({ 
      outputStyle: 'compressed',
      errLogToConsole: true, 
    }))
    .pipe(autoprefixer(['last 15 versions', '> 1%', 'ie 8', 'ie 7']))
    .pipe(sourcemaps.write())
    .pipe(dest('static/css/'))
    .pipe(browsersync.reload({ stream: true }));
}

// Watch changes on all *.scss files, lint them and
// trigger buildStyles() at the end.
function watchFiles() {
  watch(
    ['static/scss/*.scss', 'static/scss/**/*.scss'],
    { events: 'all', ignoreInitial: false },
    series(sassLint, buildStyles)
  );
}

// Init BrowserSync.
function browserSync(done) {
  browsersync.init({
    // proxy: 'http://incrementum.local/'// Change this value to match your local URL.
    socket: {
      domain: 'localhost:3000'
    }
    // server: true
  });
  done();
}

// Init Sass linter.
function sassLint() {
  return src(['static/scss/*.scss', 'static/scss/**/*.scss'])
    .pipe(cache('sasslint'))
    .pipe(sasslint({
      configFile: 'sass-lint.yml'
    }))
    .pipe(sasslint.format())
    // .pipe(sasslint.failOnError());
}

// Error handler.
function plumbError() {
  return plumber({
    errorHandler: function(err) {
      notify.onError({
        templateOptions: {
          date: new Date()
        },
        title: "Gulp error in " + err.plugin,
        message:  err.formatted
      })(err);
      beeper();
      this.emit('end');
    }
  })
}

// Export commands.
exports.default = parallel(browserSync, watchFiles); // $ gulp
exports.sass = buildStyles; // $ gulp sass
exports.watch = watchFiles; // $ gulp watch
exports.build = series(buildStyles); // $ gulp build
