const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */


// Mix для создания и подключения общего файла стилей
mix.styles([
    'resources/assets/admin/plugins/fontawesome-free/css/all.min.css',
    'resources/assets/admin/plugins/select2/css/select2.css', /* Подключаем файл select2.css */
    'resources/assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.css', /* Подключаем файл select2-bootstrap4.css */
    'resources/assets/admin/css/adminlte.min.css',

], 'public/assets/admin/css/admin.css');

// Mix для создания и подключения общего файла скриптов
mix.scripts([
    'resources/assets/admin/plugins/jquery/jquery.min.js',
    'resources/assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js',
    'resources/assets/admin/plugins/select2/js/select2.full.js', /* Подключаем файл select2.full.js */
    'resources/assets/admin/js/adminlte.min.js',
    'resources/assets/admin/js/demo.js',

], 'public/assets/admin/js/admin.js');

// Копирование папки со шрифтами webfonts плагина fontawesome-free в папку public/assets (что копируем, куда копируем)
mix.copyDirectory('resources/assets/admin/plugins/fontawesome-free/webfonts', 'public/assets/admin/webfonts');
// Копирование папки с картинками img в папку public/assets (что копируем, куда копируем)
mix.copyDirectory('resources/assets/admin/img', 'public/assets/admin/img');

// Копирование файла adminlte.min.css.map в папку public/assets/admin/css
mix.copy('resources/assets/admin/css/adminlte.min.css.map', 'public/assets/admin/css/adminlte.min.css.map');

