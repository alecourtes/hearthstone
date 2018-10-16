/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.scss');


// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
//var $ = require('jquery');
//require('bootstrap');
require( 'datatables.net-bs' );

// JS is equivalent to the normal "bootstrap" package
// no need to set this to a variable, just require it

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('#example').DataTable();
} );

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');
