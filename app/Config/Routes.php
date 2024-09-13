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
    $routes->get('usuarios/show', 'Usuarios::show');
    $routes->get('usuarios/show/(:num)', 'Usuarios::show/$1');
    $routes->put('usuarios/update/(:num)', 'Usuarios::update/$1');
    $routes->delete('usuarios/delete/(:num)', 'Usuarios::delete/$1');
    $routes->options('usuarios', '\Dummy');
    $routes->options('usuarios/(:any)', '\Dummy');

    // Reservas
    $routes->post("reservas/create", "Reservas::create");
    $routes->get("reservas/show/(:num)", "Reservas::show/$1");
    $routes->get("reservas", "Reservas::index");
    $routes->put("reservas/update/(:num)", "Reservas::update/$1");
    $routes->delete("reservas/delete/(:num)", "Reservas::delete/$1");
    $routes->options('reservas', '\Dummy');
    $routes->options('reservas/(:any)', '\Dummy');

    // Zonas Comunes
    $routes->post("zonas_comunes/create", "ZonasComunes::create");
    $routes->get("zonas_comunes/show/(:num)", "ZonasComunes::show/$1");
    $routes->get("zonas_comunes", "ZonasComunes::index");
    $routes->put("zonas_comunes/update/(:num)", "ZonasComunes::update/$1");
    $routes->delete("zonas_comunes/delete/(:num)", "ZonasComunes::delete/$1");
    $routes->options('zonas_comunes', '\Dummy');
    $routes->options('zonas_comunes/(:any)', '\Dummy');

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
});
