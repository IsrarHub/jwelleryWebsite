<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Admin');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override( function(){
    echo view('views/error404');
}

);
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Admin::index');
$routes->get('/login','Admin::login');

$routes->get('/customers','Customers::index');
$routes->post('/saveCustomer','Customers::saveCustomer');
$routes->get('/getallcustomers','Customers::getAllCustomers');
$routes->post('/editCustomer','Customers::editCustomer');
$routes->get('/getCustomer','Customers::getCustomer');
$routes->post('/deleteCustomer','Customers::deleteCustomer');

$routes->get('/goldrates','Goldrate::index');
$routes->get('/getAllGoldRates','Goldrate::getAllGoldRates');
$routes->post('/savegoldRate','Goldrate::savegoldRate');
$routes->post('/getGoldRate','Goldrate::getGoldRate');
$routes->post('/editGoldRate','Goldrate::editGoldRate');
$routes->post('/deleteGoldRate','Goldrate::deleteGoldRate');



$routes->get('/sale','Sale::index');
$routes->get('/addSale','Sale::addSale');
$routes->post('/saveSale','Sale::saveSale');
$routes->get('/editSale/{:any}','Sale::editSale');
$routes->post('/updateSale','Sale::updateSale');
$routes->get('/viewSale/{:any}','Sale::viewSale');



// //Routes Company
// $routes->get('/company',"Company::index",['filters'=>'Auth']);
// $routes->post('/saveComapny',"Company::saveCompany",['filters'=>'Auth']);



//routes for jobsites
// $routes->get('/jobsites',"Jobsite::index");
// $routes->post('/savejobsite',"Jobsite::savejobsite");
// $routes->get('/getJobsites','Jobsite::getJobsites');
// $routes->post('/getJobsite','Jobsite::getJobsite');
// $routes->post('/editJobsite','Jobsite::editJobsite');
// $routes->delete('/deleteJobsite',"Jobsite::deleteJobsite");

// //routes for users
// $routes->get('/users',"Users::index");
// $routes->get('/getUsers','USers::getUsers');
// $routes->post('/saveuser',"Users::savesaveUser");
// $routes->get('/getUser','User::getUser');
// $routes->post('/editUser',"User::editUser");
// $routes->delete('/deleteUser','User::deleteUser');



// //routes for roles

// $routes->get('/roles',"Roles::index",['filters'=>'Auth']);
// $routes->post('/saverole',"Roles::saveRole");
// $routes->get('/getRole','Roles::getRole');
// $routes->post('/editRole',"Roles::editRole");
// $routes->post('/deleteRole',"Roles::deleteRole");

// //routes for screens
// $routes->get('/screens',"Screens::index");
// $routes->post('/saveScreen',"Screen::saveScreen");
// $routes->get('/getScreens','Screens::getScreens');
// $routes->post('/getScreen',"Screens::getScreen");
// $routes->post('/editScreen','Screens::editScreen');
// $routes->delete('/deleteScreen','Screens::deleteScreen');


// $routes->get('/comapnies',"Company::index");
// $routes->post('/saveCompany',"Company::saveCompany");
// $routes->get('/getCompanies','Company::getCompanies');
// $routes->post('/getComapany',"Company::getComapany");
// $routes->post('/editCompany','Company::editCompany');
// $routes->delete('/deleteCompany','Company::deleteCompany');


// $routes->get('/purchases','Purchases::index');
// $routes->post('/savePurchases','Purchases::savePurchases');
// $routes->get('/getPurchases','Purchases::getPurchases');
// $routes->get('/getPurchase','Purchases::getPurshcase');
// $routes->post('/editPurchases','Purchases::editPurchases');
// $routes->delete('/deletePurchase',"Purchases::deletePurchase");




// $routes->get('/sites','Sites::index');
// $routes->post('/savesite','Sites::saveSite');
// $routes->get('/getSites','Sites::getSites');
// $routes->get('/getSite','Sites::getSite');
// $routes->post('/editSite','Sites::editSite');
// $routes->delete('/deleteSite',"Sites::deleteSite");


// $routes->get('/trucks','Trucks::index');
// $routes->post('/saveTruck','Trucks::saveTruck');
// $routes->get('/getTrucks','Trucks::getTrucks');
// $routes->get('/getTruck','Trucks::getTruck');
// $routes->post('/editTruck','Trucks::editTruck');
// $routes->delete('/deleteTruck',"Trucks::deleteTruck");


// $routes->get('/tickets','Tickets/index');
// $routes->get('/gettickets','Tickets/getTickets');
// $routes->post('/saveTicket','Tickets/saveTicket');
// $routes->get('/getticket','Tickets/getTicket');
// $routes->post('/editTicket','Tickets/editTicket');
// $routes->get('/deleteTicket','Tickets/deleteTicket');

// $routes->get('/label','Label/index');
// $routes->get('/labelGeneatorpdf','Label/labelGeneatorpdf');

// $routes->get('/reports','Reports/index');

// $routes->get('/generate','Reports/generate');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
