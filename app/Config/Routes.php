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
$routes->get('/employer/discover', 'Employer::index');
$routes->get('/employer/talent/(:num)', 'Employer::talent/$1');
$routes->get('/talent/profile', 'Talent::index');
$routes->post('/api/profile/talent', 'Profile::updateTalent');

// Auth
$routes->get('/auth/login', 'Auth::login');
$routes->get('/auth/register', 'Auth::register');
$routes->post('/auth/login', 'Auth::attemptLogin');
$routes->post('/auth/register', 'Auth::attemptRegister');
$routes->get('/auth/logout', 'Auth::logout');

// API — Talents
$routes->post('api/waitlist', 'Api::waitlist');
$routes->get('api/waitlist/stats', 'Api::waitlistStats');
$routes->get('api/talents', 'Api::talents');
$routes->get('api/talents/(:num)', 'Api::talent/$1');

// API — Offers
$routes->post('api/offers', 'Offers::create');
$routes->get('api/offers/sent', 'Offers::sent');
$routes->get('api/offers/incoming', 'Offers::incoming');
$routes->post('api/offers/(:num)/accept', 'Offers::accept/$1');
$routes->post('api/offers/(:num)/decline', 'Offers::decline/$1');

// API — Notifications
$routes->get('api/notifications', 'Notifications::index');
$routes->get('api/notifications/unread-count', 'Notifications::unreadCount');
$routes->post('api/notifications/read-all', 'Notifications::markAllRead');
$routes->post('api/notifications/(:num)/read', 'Notifications::markRead/$1');

return $routes;
