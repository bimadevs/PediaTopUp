<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/logout', 'Home::Logout');
$routes->get('/buy/(:any)', 'Home::CategoryDetail/$1');
$routes->get('/order/detail/(:any)', 'Home::detailOrder/$1');
$routes->post('/buy', 'Home::BuyProduct');

$routes->get('/deposit', 'Home::DepositIndex');
$routes->post('/deposit', 'Home::DepositCreate');
$routes->get('/deposit/detail/(:any)', 'Home::DepositDetail/$1');

$routes->get('/history', 'Home::HistoryIndex');

// Routes for Login and Register
$routes->get('/login', 'Home::LoginIndex');
$routes->post('/login', 'Home::LoginCheck');
$routes->get('/register', 'Home::RegisterIndex');
$routes->post('/register', 'Home::RegisterCheck');

$routes->get('/admin', 'Admin::index');
$routes->get('/admin/auth', 'Admin::AuthIndex');
$routes->post('/admin/auth', 'Admin::checkAccount');
$routes->get('/admin/logout', 'Admin::AdminLogout');

// Routes for Users Data
$routes->get('/admin/users', 'Admin::UsersIndex');
$routes->post('/admin/users/add', 'Admin::UsersAdd');
$routes->post('/admin/users/edit', 'Admin::UsersEdit');
$routes->get('/admin/users/delete/(:any)', 'Admin::deleteUser/$1');

// Routes for Product Data
$routes->get('/admin/product', 'Admin::ProductIndex');
$routes->post('/admin/product/add', 'Admin::ProductAdd');
$routes->post('/admin/product/edit', 'Admin::ProductEdit');
$routes->get('/admin/product/delete/(:any)', 'Admin::ProductDelete/$1');

// Routes for Category Data
$routes->get('/admin/product/category', 'Admin::CategoryIndex');
$routes->post('/admin/category/add', 'Admin::CategoryAdd');
$routes->post('/admin/category/edit', 'Admin::CategoryEdit');
$routes->get('/admin/category/delete/(:any)', 'Admin::CategoryDelete/$1');

// Routes For Bank Data
$routes->get('/admin/bank', 'Admin::BankIndex');
$routes->post('/admin/bank/add', 'Admin::BankAdd');
$routes->post('/admin/bank/edit', 'Admin::BankEdit');
$routes->get('/admin/bank/delete/(:any)', 'Admin::BankDelete/$1');

// Routes For Deposit Data
$routes->get('/admin/deposit', 'Admin::DepositIndex');
$routes->post('/admin/deposit/update', 'Admin::EditDeposit');

$routes->get('/admin/transaction', 'Admin::TransactionIndex');

// Routes for Settings
$routes->get('/admin/settings', 'Admin::SettingsIndex');
$routes->post('/admin/settings/update', 'Admin::SettingsUpdate');