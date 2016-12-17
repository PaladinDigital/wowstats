const elixir = require('laravel-elixir');

elixir.config.sourcemaps = false;

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix.sass('app.scss')
    mix.sass('alliance.scss')
    mix.sass('horde.scss');
    mix.scripts([
        'characters.js',
        'claim.js',
        'fightlock.js',
    ]);
});
