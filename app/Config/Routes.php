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

    // Routes for usuarios
    $routes->post('usuarios/create', 'Usuarios::create');
    $routes->get('usuarios/show/(:num)', 'Usuarios::show/$1');
    $routes->put('usuarios/update/(:num)', 'Usuarios::update/$1');
    $routes->delete('usuarios/delete/(:num)', 'Usuarios::delete/$1');

    // PQR
    $routes->post("pqr/create", "Pqr::create");
    $routes->get("pqr/show/(:num)", "Pqr::show/$1");
    $routes->get("pqr", "Pqr::index");
    $routes->put("pqr/update/(:num)", "Pqr::update/$1");
    $routes->delete("pqr/delete/(:num)", "Pqr::delete/$1");

    // Cuota Administracion
    $routes->post("cuotas_administracion/create", "CuotaController::create");
    $routes->get('cuotas_administracion/show/(:num)', 'CuotaController::show/$1');
    $routes->get("cuotas_administracion", "CuotaController::index");
    $routes->put('cuotas_administracion/update/(:num)', 'CuotaController::update/$1');
    $routes->delete("cuotas_administracion/delete/(:num)", "CuotaController::delete/$1");

    // Residents
    $routes->post("resident/create", "Resident::create");
    $routes->get('resident/show/(:num)', 'Resident::show/$1');
    $routes->get("resident", "Resident::index");
    $routes->put("resident/update/(:num)", "Resident::update/$1");
    $routes->delete("resident/delete/(:num)", "Resident::delete/$1");
});


