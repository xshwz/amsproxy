gulp       = require 'xgulp'
less       = require 'gulp-less'
sourcemaps = require 'gulp-sourcemaps'
using      = require 'gulp-using'
# concat     = require 'gulp-concat'
uglify     = require 'gulp-uglify'

gulp.task 'less', ->
  gulp.src
    'src/less/': [
      'common.less'
      'site.less'
      'proxy.less'
      'admin.less'
      'ie.less'
    ]
  .plumber()
  .pipe sourcemaps.init()
  .pipe less
    compress: true
  #.pipe sourcemaps.write './'
  .pipe gulp.dest 'public/css'

gulp.task 'bower', ->
  gulp.src
    'bower_components/': [
      'bootstrap/dist/css/bootstrap.min.css'
    ]
  .pipe using()
  .pipe gulp.dest 'public/css'

  gulp.src
    'bower_components/': [
      'jquery-form/jquery.form.js'
    ]
  .pipe using()
  .pipe uglify()
  .pipe gulp.dest 'public/js/libs'

  gulp.src
    'bower_components/': [
      'bootstrap/dist/js/bootstrap.min.js'
      'bootstrap/dist/js/bootstrap.min.js'
      'highcharts/highcharts.js'
      'html5shiv/dist/html5shiv.min.js'
      'jquery/dist/jquery.min.js'
      'jquery-easing/jquery.easing.min.js'
      'respond/dest/respond.min.js'
    ]
  .pipe using()
  .pipe gulp.dest 'public/js/libs'

  gulp.src
    'bower_components/': [
      'bootstrap/dist/fonts/*'
    ]
  .pipe using()
  .pipe gulp.dest 'public/fonts'

gulp.task 'watch', ->
  gulp.watch 'src/less/**/*.less', ['less']

gulp.task 'default', ['less', 'watch']
