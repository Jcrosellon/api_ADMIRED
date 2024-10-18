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

    // Áreas Comunes
    $routes->post("areas_comunes/create", "AreasComunes::create");
    $routes->get("areas_comunes/show/(:num)", "AreasComunes::show/$1");
    $routes->get("areas_comunes", "AreasComunes::index");
    $routes->put("areas_comunes/update/(:num)", "AreasComunes::update/$1");
    $routes->delete("areas_comunes/delete/(:num)", "AreasComunes::delete/$1");
    $routes->options('areas_comunes', '\Dummy');
    $routes->options('areas_comunes/(:any)', '\Dummy');

    // PQR
    $routes->post("pqr/create", "Pqr::create");
    $routes->get("pqr/show/(:num)", "Pqr::show/$1");
    $routes->get("pqr", "Pqr::index");
    $routes->put("pqr/update/(:num)", "Pqr::update/$1");
    $routes->delete("pqr/delete/(:num)", "Pqr::delete/$1");
    $routes->options('pqr', '\Dummy');
    $routes->options('pqr/(:any)', '\Dummy');

    // PQR Tipo
    $routes->post("pqr_tipo/create", "PqrTipo::create");
    $routes->get("pqr_tipo/show/(:num)", "PqrTipo::show/$1");
    $routes->get("pqr_tipo", "PqrTipo::index"); // Este método obtiene todos los tipos de PQR
    $routes->put("pqr_tipo/update/(:num)", "PqrTipo::update/$1");
    $routes->delete("pqr_tipo/delete/(:num)", "PqrTipo::delete/$1");
    $routes->options('pqr_tipo', '\Dummy');
    $routes->options('pqr_tipo/(:any)', '\Dummy');

    // Cuota Administracion
    $routes->post("cuotas_administracion/create", "Cuota::create");
    $routes->get('cuotas_administracion/show/(:num)', 'Cuota::show/$1');
    $routes->get("cuotas_administracion", "Cuota::index");
    $routes->put('cuotas_administracion/update/(:num)', 'Cuota::update/$1');
    $routes->delete("cuotas_administracion/delete/(:num)", "Cuota::delete/$1");
    $routes->get('cuotas_administracion/user/(:num)', 'Cuota::showByUser/$1'); // Nueva ruta para obtener cuota por usuario
    $routes->options('cuotas_administracion', '\Dummy');
    $routes->options('cuotas_administracion/(:any)', '\Dummy');
    $routes->get('cuotas_administracion/unidad/(:num)', 'UnidadesResidenciales::getUnidadResidencialId/$1');
    $routes->get('unidades_residenciales/user/(:num)', 'UnidadesResidenciales::getByUserId/$1');
});
