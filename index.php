<?php

require 'vendor/autoload.php';
require_once 'functions.php';

use Config\Config;
use App\Controllers\PageController;

session_start();
if(!isset($_SESSION['flash'])) {
    init_session();
}

$router = new AltoRouter();

//Les routes (tut tut)
$router->map('GET', '/movie_type/[i:id_type]', function($id_type){
    $controller = new PageController();
    $controller->showMovieType($id_type);
});

$router->map('GET', '/redirect', function(){
    $controller = new PageController();
    $controller->redirect();
});

$router->map('GET', '/createPage', function(){
    $controller = new PageController();
    $controller->createPage();
});

$router->map('POST', '/create', function(){
    $controller = new PageController();
    $controller->create();
});

$router->map('POST', '/change/[i:id_movie]', function($id_movie){
    $controller = new Pagecontroller();
    $controller->change($id_movie);
});

$router->map('GET', '/changePage/[i:id_movie]', function($id_movie){
    $controller = new Pagecontroller();
    $controller->changePage($id_movie);
});

$router->map('GET', '/staff/[i:id_person]', function($id_person){
    $controller = new Pagecontroller();
    $controller->getOnePerson($id_person);
});

$router->map('POST', '/my_account/change_password', function(){
    $controller = new PageController();
    $controller->change_password();
});

$router->map('GET', '/my_account', function(){
    $controller = new PageController();
    $controller->my_account();
});

$router->map('POST', '/create_accountPage/create_account', function(){
    $controller = new PageController();
    $controller->create_account();
});

$router->map('GET', '/create_accountPage', function(){
    $controller = new PageController();
    $controller->create_accountPage();
});

$router->map('GET', '/logout', function(){
    $controller = new PageController();
    $controller->logout();
});

$router->map('POST', '/reset/[i:id_user]', function($id_user){
    $controller = new PageController();
    $controller->reset($id_user);
});

$router->map('GET', '/resetPage', function(){
    $controller = new PageController();
    $controller->resetPage();
});

$router->map('POST', '/forget', function(){
    $controller = new PageController();
    $controller->forget();
});

$router->map('GET', '/forgetPage', function(){
    $controller = new PageController();
    $controller->forgetPage();
});

$router->map('POST', '/loginPage/login', function(){
    $controller = new PageController();
    $controller->login();
});

$router->map('GET', '/loginPage', function(){
    $controller = new PageController();
    $controller->loginPage();
});

$router->map('GET', '/all_next_movies', function(){
    $controller = new PageController();
    $controller->allNextMovies();
});

$router->map('GET', '/favorite_movies', function(){
    $controller = new PageController();
    $controller->favoriteMovies();
});

$router->map('GET', '/all_movies', function(){
    $controller = new PageController();
    $controller->allMoviesReleased();
});

$router->map('POST', '/movie/[i:id_movie]/comment', function($id_movie){
    $controller = new PageController();
    $controller->addComment($id_movie);
});

$router->map('GET', '/movie/[i:id_movie]', function($id_movie){
    $controller = new PageController();
    $controller->showMovie($id_movie);
});

$router->map('POST', '/search_movies', function() {
    $controller = new PageController();
    $controller->searchMovies();
});

$router->map('POST', '/search', function() {
    $controller = new PageController();
    $controller->search();
});

$router->map('POST', '/movie/search', function() {
    $controller = new PageController();
    $controller->search();
});

$router->map('GET', '/', function(){
    $controller = new PageController();
    $controller->home();
});

$match = $router->match();

// call closure or throw 404 status
if (is_array($match) && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    // no route was matched
    header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
}