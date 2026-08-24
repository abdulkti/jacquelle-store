<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');
$routes->get('/products', 'Products::index');
$routes->get('/featured-products', 'Products::index');
$routes->get('/discounts', 'Products::index');
$routes->get('/bundles', 'Products::index');
$routes->get('/products/(:num)/(:segment)', 'Products::detail/$1/$2');
$routes->get('/categories/(:num)/(:segment)', 'Products::index/$1/$2');
$routes->get('/wishlist', 'Shop::wishlist');
$routes->post('/wishlist/toggle', 'Shop::wishlistToggle');
$routes->post('/wishlist/remove', 'Shop::wishlistRemove');
$routes->post('/wishlist/move-to-cart', 'Shop::wishlistMoveToCart');
$routes->get('/cart', 'Shop::cart');
$routes->post('/cart/add', 'Shop::cartAdd');
$routes->post('/cart/update', 'Shop::cartUpdate');
$routes->post('/cart/remove', 'Shop::cartRemove');
$routes->get('/cart/checkout', 'Shop::checkout');
$routes->post('/cart/checkout', 'Shop::checkoutSubmit');
$routes->get('/orders', 'Shop::orders');
$routes->get('/orders/(:num)', 'Shop::orderDetail/$1');
$routes->get('/auth/login', 'Auth::login');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/auth/register', 'Auth::register');
$routes->post('/auth/register', 'Auth::register');
$routes->get('/auth/logout', 'Auth::logout');
$routes->get('/account', 'Auth::account');
$routes->get('/admin', 'Admin::index');
$routes->get('/admin/products', 'Admin::products');
$routes->get('/admin/products/new', 'Admin::productForm');
$routes->get('/admin/products/edit/(:num)', 'Admin::productForm/$1');
$routes->post('/admin/products/save', 'Admin::productSave');
$routes->post('/admin/products/delete/(:num)', 'Admin::productDelete/$1');
$routes->get('/admin/categories', 'Admin::categories');
$routes->get('/admin/categories/new', 'Admin::categoryForm');
$routes->get('/admin/categories/edit/(:num)', 'Admin::categoryForm/$1');
$routes->post('/admin/categories/save', 'Admin::categorySave');
$routes->post('/admin/categories/delete/(:num)', 'Admin::categoryDelete/$1');
$routes->get('/admin/orders', 'Admin::orders');
$routes->post('/admin/orders/status', 'Admin::orderStatus');
$routes->get('/admin/data-export', 'Admin::dataExport');
$routes->get('/admin/users', 'Admin::users');
$routes->post('/admin/users/save', 'Admin::userSave');
$routes->post('/admin/users/delete/(:num)', 'Admin::userDelete/$1');

