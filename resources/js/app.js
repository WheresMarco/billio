/**
 * First we will load all of this project's JavaScript dependencies which
 * includes React and other helpers. It's a great starting point while
 * building robust, powerful web applications using React + Laravel.
 */

require('./bootstrap');
import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()

var Turbolinks = require("turbolinks");
Turbolinks.start();
Turbolinks.setProgressBarDelay(0)
