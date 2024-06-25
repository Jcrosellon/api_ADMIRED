<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group("api", ['filter' => 'cors'], function ($routes) {
    // Routes for users
    $routes->post("users/register", "Register::index");
    $routes->post("users/login", "Login::index");
    $routes->get("users", "User::index", ['filter' => 'authFilter']);
    $routes->get('users/show/(:num)', 'User::show/$1', ['filter' => 'authFilter']);
    $routes->put('users/update/(:num)', 'User::update/$1');
    $routes->delete('users/delete/(:num)', 'User::delete/$1');
    $routes->options('users', '\Dummy');
    $routes->options('users/(:any)', '\Dummy');

    // Routes for usuarios
    $routes->post('usuarios/create', 'Usuarios::create');
    $routes->get('usuarios/show/(:num)', 'Usuarios::show/$1');
    $routes->put('usuarios/update/(:num)', 'Usuarios::update/$1');
    $routes->delete('usuarios/delete/(:num)', 'Usuarios::delete/$1');
    $routes->options('usuarios', '\Dummy');
    $routes->options('usuarios/(:any)', '\Dummy');

    // PQR
    $routes->post("pqr/create", "Pqr::create");
    $routes->get("pqr/show/(:num)", "Pqr::show/$1");
    $routes->get("pqr", "Pqr::index");
    $routes->put("pqr/update/(:num)", "Pqr::update/$1");
    $routes->delete("pqr/delete/(:num)", "Pqr::delete/$1");
    $routes->options('pqr', '\Dummy');
    $routes->options('pqr/(:any)', '\Dummy');
    

    // Cuota Administracion
    $routes->post("cuotas_administracion/create", "Cuota::create");
    $routes->get('cuotas_administracion/show/(:num)', 'Cuota::show/$1');
    $routes->get("cuotas_administracion", "Cuota::index");
    $routes->put('cuotas_administracion/update/(:num)', 'Cuota::update/$1');
    $routes->delete("cuotas_administracion/delete/(:num)", "Cuota::delete/$1");
    $routes->options('cuotas_administracion', '\Dummy');
    $routes->options('cuotas_administracion/(:any)', '\Dummy');


    // Residents
    $routes->post("resident/create", "Resident::create");
    $routes->get('resident/show/(:num)', 'Resident::show/$1');
    $routes->get("resident", "Resident::index");
    $routes->put("resident/update/(:num)", "Resident::update/$1");
    $routes->delete("resident/delete/(:num)", "Resident::delete/$1");
    $routes->options('resident', '\Dummy');
    $routes->options('resident/(:any)', '\Dummy');
});


$routes->options('api', '\Dummy');
    $routes->options('api/(:any)', '\Dummy');