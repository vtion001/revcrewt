<?php

/**
 * CI4 sets $routes automatically via RouteCollection::loadRoutes()
 * DO NOT create new RouteCollection() here.
 */

$routes->get('/', 'Home::index');
$routes->get('/how-it-works', 'HowItWorks::index');
$routes->get('/for-employers', 'ForEmployers::index');
$routes->get('/for-talent', 'ForTalent::index');
$routes->get('/pricing', 'Pricing::index');
