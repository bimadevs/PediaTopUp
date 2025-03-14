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

// Routes for Withdrawal
$routes->get('/withdrawal', 'Home::WithdrawalIndex');
$routes->post('/withdrawal', 'Home::WithdrawalCreate');
$routes->get('/withdrawal/detail/(:any)', 'Home::WithdrawalDetail/$1');
$routes->post('/remove-notification', 'Home::removeNotification');

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

// Routes For Bank Withdrawal Data
$routes->get('/admin/bank/withdrawal', 'Admin::BankWithdrawalIndex');
$routes->post('/admin/bank/withdrawal/add', 'Admin::BankWithdrawalAdd');
$routes->post('/admin/bank/withdrawal/edit', 'Admin::BankWithdrawalEdit');
$routes->get('/admin/bank/withdrawal/delete/(:any)', 'Admin::BankWithdrawalDelete/$1');

// Routes For Deposit Data
$routes->get('/admin/deposit', 'Admin::DepositIndex');
$routes->post('/admin/deposit/update', 'Admin::EditDeposit');

// Routes For Deposit Amount Data
$routes->get('/admin/deposit/amount', 'Admin::DepositAmountIndex');
$routes->post('/admin/deposit/amount/add', 'Admin::DepositAmountAdd');
$routes->post('/admin/deposit/amount/edit', 'Admin::DepositAmountEdit');
$routes->get('/admin/deposit/amount/delete/(:any)', 'Admin::DepositAmountDelete/$1');

// Routes For Withdrawal Data
$routes->get('/admin/withdrawal', 'Admin::WithdrawalIndex');
$routes->post('/admin/withdrawal/edit', 'Admin::EditWithdrawal');

// Routes For Withdrawal Amount Data
$routes->get('/admin/withdrawal/amount', 'Admin::WithdrawalAmountIndex');
$routes->post('/admin/withdrawal/amount/add', 'Admin::WithdrawalAmountAdd');
$routes->post('/admin/withdrawal/amount/edit', 'Admin::WithdrawalAmountEdit');
$routes->get('/admin/withdrawal/amount/delete/(:any)', 'Admin::WithdrawalAmountDelete/$1');

// Routes For Transaction Data
$routes->get('/admin/transaction', 'Admin::TransactionIndex');
$routes->post('/admin/transaction/update', 'Admin::TransactionUpdate');

// Routes For Notification Data
$routes->get('/admin/notification', 'Admin::NotificationIndex');
$routes->post('/admin/notification/add', 'Admin::NotificationAdd');
$routes->get('/admin/notification/delete/(:any)', 'Admin::NotificationDelete/$1');

// Routes for Settings
$routes->get('/admin/settings', 'Admin::SettingsIndex');
$routes->post('/admin/settings/update', 'Admin::SettingsUpdate');
$routes->get('/admin/add-fee-withdrawal', 'Admin::AddFeeWithdrawal');

// Routes for Change Password 
$routes->post('/admin/change-password', 'Admin::changePassword');