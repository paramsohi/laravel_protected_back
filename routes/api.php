<?php

use Illuminate\Http\Request;

Route::post('login', 'LoginController@login');

// Route::post('/userregister', 'Api\RegisterController@store');

// Route::post('/adminregister', 'Admin\AdminRegisterController@store');

Route::post('/userregisteration', 'Front\PetUserController@store');

Route::get('/frontproductcatlist', 'Front\FrontOrderController@frontProductCatList');
Route::get('/frontproductlist/{id}/{user_id}', 'Front\FrontOrderController@frontProductList');

Route::post('/reportlost', 'Front\PetChipController@reportLost');

Route::post('/registerpetuser', 'FrontRegisterController@store');
Route::get('/missingpostergenrate', 'Front\PetUserController@missingPosterGenratePDF');



//**user api**//
 Route::group(['middleware' => 'auth:api'], function() {


 Route::get('/getuser/{id}', 'Api\RegisterController@show');

 Route::get('/userhistory', 'Front\PetUserController@userHistory');
 Route::post('/userchangepassword', 'Front\PetUserController@changePassword');
 Route::resource('/frontuser', 'Front\PetUserController');
 Route::post('/changeowner/{pet_id}', 'Front\PetUserController@changeOwner');
 Route::get('/ownerhistory', 'Front\PetUserController@ownerHistory');
 Route::get('/petownerdetailgenerate/{id}', 'Front\PetUserController@petOwnerDetailGeneratePDF');
 Route::post('/changeownergenrate', 'Front\PetUserController@changeOwnerGenratePDF');



 Route::resource('/contact', 'Front\ContactController');


 Route::get('/oldchiplist', 'Front\PetChipController@oldChipList');
 Route::get('/petfrontchiplist', 'Front\PetChipController@petFrontChipList');
 Route::get('/petfrontchiplistview/{chip_number}', 'Front\PetChipController@petFrontChipListView');
 Route::post('/petfrontchiplistviewupdate/{chip_number}', 'Front\PetChipController@petFrontChipListViewUpdate');
 Route::post('/chiplistviewreport/{chip_number}', 'Front\PetChipController@chipListViewReport');
 Route::post('/chiplistviewdeceased/{pet_id}', 'Front\PetChipController@chipListViewDeceased');
 // Route::get('/accountchiplist', 'Front\PetChipController@accountChipList');
 Route::post('/registeranotherpet', 'Front\PetChipController@registerAnotherPet');
 // Route::post('/reportlost', 'Front\PetChipController@reportLost');
 Route::get('/documentlist', 'Front\PetChipController@documentList');
 Route::get('/petfrontchipmicrochips', 'Front\PetChipController@petFrontChipMicrochips');
 // Route::post('/updatechipbreeder', 'Front\PetChipController@updateChipBreeder');
 Route::get('/petdocument/{pet_id}', 'Front\PetChipController@petDocumentPdf');
 
 
 Route::post('/applydiscount/{code}', 'Api\DiscountController@frontDiscountList');
 

 // Route::post('/frontupdateorder/{product_id}', 'Front\FrontOrderController@frontOrderList');

 Route::resource('/frontorder', 'Front\FrontOrderController');
 Route::get('/frontorderlist', 'Front\FrontOrderController@frontOrderList');
 // Route::get('/frontcustomerorderlist', 'Front\FrontOrderController@frontCustomerOrderList');
 Route::post('/checkchip/{chip_number}', 'Front\FrontOrderController@checkChip');
 Route::post('/storeusercurrency/{Currency_id}', 'Front\FrontOrderController@storeUserCurrency');
 Route::post('/updateorderitems/{id}/{order_id}', 'Front\FrontOrderController@updateOrderItems');
 Route::get('/frontordergenerate/{id}', 'Front\FrontOrderController@frontOrderGeneratePDF');



Route::get('/lostfound/{pet_id}', 'Api\LostFoundController@getLostFound');



});


//**admin api **//
Route::group(['middleware' => 'auth:admin'], function() {

Route::get('/userlists', 'Api\RegisterController@list');
 // Route::resource('/user', 'Api\RegisterController');
Route::post('/userregister', 'Api\RegisterController@store');
Route::get('/user/{id}', 'Api\RegisterController@show');
Route::post('/userupdate/{id}', 'Api\RegisterController@update');
Route::post('/userdelete/{id}', 'Api\RegisterController@destroy');
Route::get('/getallusers', 'Api\RegisterController@getAllUsers');
Route::post('/searchusers', 'Api\RegisterController@searchUsers');


Route::resource('/updateadmin', 'Admin\AdminRegisterController');
Route::post('/adminchangepassword', 'Admin\AdminRegisterController@changePasswordAdmin');




Route::post('/addpettype', 'Api\PetController@petType');
Route::get('/pettypeshow/{id}', 'Api\PetController@petTypeShow');
Route::post('/pettypedelete/{id}', 'Api\PetController@petTypeDelete');
Route::post('/pettypeupdate/{id}', 'Api\PetController@petTypeUpdate');
Route::get('pettypelist', 'Api\PetController@petTypeList');
Route::get('getallpettypes', 'Api\PetController@getAllPetTypes');
Route::resource('/pet', 'Api\PetController');
Route::get('/petlist', 'Api\PetController@petList');
Route::post('/updatepetowner/{id}', 'Api\PetController@updatePetOwner');
Route::post('/updatechipowner/{id}', 'Api\PetController@updateChipOwner');
Route::post('/updateownerholidayaddress/{id}', 'Api\PetController@updateOwnerHolidayAddress');
Route::get('/pethistory/{id}', 'Api\PetController@petHistory');
Route::post('/updatebreeder/{id}', 'Api\PetController@updateBreeder');
Route::post('/updatedealer/{id}', 'Api\PetController@updateDealer');
Route::get('requestownerlist', 'Api\PetController@requestOwnerList');
Route::post('requestownerapprove/{id}', 'Api\PetController@requestOwnerApprove');
Route::post('requestownerdecline/{id}', 'Api\PetController@requestOwnerDecline');
Route::get('petstat', 'Api\PetController@petStat');


Route::resource('/vendor', 'Api\VendorController');
Route::get('/vendorlist', 'Api\VendorController@vendorList');


Route::resource('/product', 'Api\ProductController');
Route::post('/productupdate/{id}', 'Api\ProductController@update');
Route::get('/productlist', 'Api\ProductController@productList');


Route::resource('/categories', 'Api\CategoriesController');
Route::get('/productcatlist', 'Api\CategoriesController@productCatList');

Route::resource('/order', 'Api\OrdersController');
Route::get('/orderlist', 'Api\OrdersController@orderList');
Route::get('/generate/{id}', 'Api\OrdersController@orderGeneratePDF');

Route::resource('/chpis', 'Api\ChipsController');
Route::get('/chiplist', 'Api\ChipsController@chipList');
Route::get('/petchiplist', 'Api\ChipsController@petChipList');


Route::resource('/discount', 'Api\DiscountController');
Route::get('/discountlist', 'Api\DiscountController@discountList');


Route::resource('/lostfound', 'Api\LostFoundController');
Route::get('/lostfoundlist', 'Api\LostFoundController@lostFoundList');
Route::get('/approveruserslist', 'Api\LostFoundController@approverUsersList');
Route::post('/approverusers/{id}', 'Api\LostFoundController@approverUsers');
Route::post('/declineusers/{id}', 'Api\LostFoundController@declineUsers');
Route::post('/searchlostfound', 'Api\LostFoundController@searchLostFound');
Route::post('/searchapproverusers', 'Api\LostFoundController@searchApproverUsers');

Route::resource('/sitesetting', 'Api\SiteSettingController');
Route::get('/sitesettinglist', 'Api\SiteSettingController@siteSettingList');
Route::get('/currencieslist', 'Api\SiteSettingController@currenciesList');
Route::post('/currenciesget/{id}', 'Api\SiteSettingController@currenciesGet');




});
Route::get('/countrieslist', 'Api\SiteSettingController@countriesList');
Route::get('/statelist/{id}', 'Api\SiteSettingController@stateList');
Route::get('/citieslist/{id}', 'Api\SiteSettingController@citiesList');

Route::get('/chipnumber/{id}', 'Front\PetChipController@chipNumber');
Route::get('/checkchipnumber/{id}/{bypasscode}', 'Front\PetChipController@checkChipNumber');
Route::get('/reportfound/{id}/{LFdetails}', 'Front\PetChipController@reportFound');