<?php
use Framework\routes\Router;

Router::get('/', ['HomeController', 'index']);
Router::get('/contact', ['HomeController', 'contact']);
Router::post('/contact', ['HomeController', 'postcontact']);