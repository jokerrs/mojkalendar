<?php
use app\Controllers\CommentsController;
use app\Controllers\Controller;
use app\Controllers\ProductsController;
use app\Controllers\UsersController;
use app\Router;
new Router(__DIR__);

//Router::post('/', [Controller::class, 'testp']);
//Router::get('/test', function (){
//    print_r(Router::$routes);
//});
//Router::get('/testa', function (){
//    print_r(Router::$routes);
//});
Router::get('/', 'pocetna');

Router::get('/login', 'admin/login');

Router::post('/login', function(){
  echo 'Login is disabled temporary!';
  //header("Location: /");
});

Router::run();