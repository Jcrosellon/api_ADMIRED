<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group("api", function ($routes) {
    // Routes for users
    $routes->post("users/register", "Register::index");
    $routes->post("users/login", "Login::index");
    $routes->get("users", "User::index", ['filter' => 'authFilter']);
    $routes->get('users/show/(:num)', 'User::show/$1');
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

    // Unidades Residenciales
    $routes->post("unidades_residenciales/create", "Unidades::create");
    $routes->get('unidades_residenciales/show/(:num)', 'Unidades::show/$1');
    $routes->get("unidades_residenciales", "Unidades::index");
    $routes->put('unidades_residenciales/update/(:num)', 'Unidades::update/$1');
    $routes->delete("unidades_residenciales/delete/(:num)", "Unidades::delete/$1");

    // Residents
    $routes->post("resident/create", "Resident::create");
    $routes->get('resident/show/(:num)', 'Resident::show/$1');
    $routes->get("resident", "Resident::index");
    $routes->put("resident/update/(:num)", "Resident::update/$1");
    $routes->delete("resident/delete/(:num)", "Resident::delete/$1");
});


