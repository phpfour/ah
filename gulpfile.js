var elixir = require('laravel-elixir');

var bowerDir = './resources/assets/vendor/';

var lessPaths = [
    bowerDir + "bootstrap/less",
    bowerDir + "font-awesome/less",
    bowerDir + "bootstrap-select/less"
];

elixir(function (mix) {
    mix.less('app.less', 'public/css', {paths: lessPaths})
        .scripts([
            'jquery/dist/jquery.min.js',
            'bootstrap/dist/js/bootstrap.min.js',
            'bootstrap-select/dist/js/bootstrap-select.min.js',
            'bootstrap3-typeahead/bootstrap3-typeahead.min.js'
        ], 'public/js/vendor.js', bowerDir)
        .copy('resources/assets/js/app.js', 'public/js/app.js')
        .copy(bowerDir + 'font-awesome/fonts', 'public/fonts')
        .copy(bowerDir + 'bootstrap/fonts', 'public/fonts')
    ;
});