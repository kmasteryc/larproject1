var elixir = require('laravel-elixir');
//
// /*
//  |--------------------------------------------------------------------------
//  | Elixir Asset Management
//  |--------------------------------------------------------------------------
//  |
//  | Elixir provides a clean, fluent API for defining some basic Gulp tasks
//  | for your Laravel application. By default, we are compiling the Sass
//  | file for our application, as well as publishing vendor resources.
//  |
//  */
elixir(function(mix) {
    // mix.browserSync({
    //     proxy: 'homestead.app'
    // });
    mix.sass('app.scss');
});
// var gulp = require('gulp');
// var cleanCSS = require('gulp-clean-css');
// var gulpSass = require('gulp-sass');
//
// gulp.task('minify-css', function() {
//     return gulp.src('resources/assets/**/*.scss')
//         .pipe(gulpSass())
//         .pipe(cleanCSS())
//         .pipe(gulp.dest('public/css/'));
// });
//
// gulp.task('watch', function(){
//    return gulp.watch('resources/assets/**/*.scss',['minify-css']);
// });