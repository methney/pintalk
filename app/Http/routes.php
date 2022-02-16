<?php

use App\Exceptions\CustomException;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/', function(){
    Session::set('name', Auth::check()?Auth::user()->name:'Guest');
    Session::set('email', Auth::check()?Auth::user()->email:'');

    if(!(Session::get('lat') && Session::get('lng'))){
        Session::set('lat', Auth::check()?Auth::user()->lat:'');
        Session::set('lng', Auth::check()?Auth::user()->lng:'');
    }    
    return View::make('indexGuest');
});

Route::get('indexHost', function(){
    return View::make('indexHost');
});

Route::get('indexHost/{pin_id}', ['uses'=>'PinController@modifyHostPin']);
Route::post('indexHost/{pin_id}', ['uses'=>'PinController@modifyHostPin']);

Route::get('indexGuest', ['as'=> 'indexGuest', function(){
    return View::make('indexGuest');
}]);

Route::get('indexMap', function(){
    return View::make('indexMap');
});

Route::get('fourPinForIndexHost','PinController@fourPinForIndexHost');

Route::post('entry',function(){
    return View::make('indexMap')->withInput(Input::all());
});


Route::get('home',function(){
    return View::make('indexGuest');
});


Route::get('commonCode', function(){
    return View::make('commonCode');
});

Route::get('register', function(){
    return View::make('auth/register');
});

// profile
Route::get('profile', function(){
    return View::make('profile')->withInput(Input::all());
});
Route::post('modifyProfile', "UserController@updateUserInfo");
Route::post('profileImgUpload',"UserController@uploadProfileImg");


// direct to chat
Route::get('direct/{pin_id}', ['uses'=>'PinController@directAccess']);

// but direct without pin_id 
Route::get('direct',function(){
    return View::make('indexGuest');
});


// direct to page
Route::get('pin/{pin_id}', ['uses'=>'PinController@directPage']);


// tour 사용여부 update
Route::post('guideUpdate', "UserController@updateGuide");


// pin register
Route::get('pinRegister', function(){
    return View::make('pin/pinRegister');
});
Route::post('addPin', 'PinController@insertPin');
Route::post('addPinFile', 'PinController@insertPinRepFile');
Route::get('callPins', 'PinController@selectPins');
Route::post('callPinUserInfo', 'PinController@selectPinUserInfo'); // + 채팅룸 히스토리 등록까지 동시에
Route::get('pinGridList', 'PinController@selectPinList');
Route::get('callPinDetail', 'PinController@selectPinDetail');
Route::post('modPin', 'PinController@updatePin');
Route::post('delPin', 'PinController@deletePin');
Route::get('indexGuestWithKey/{key}', array('as'=>'indexGuestWithKey', function($key){
    return View::make('indexGuest')->with('key',$key);
}));


Route::get('pinList', function(){
    return View::make('pin/pinList');
});
Route::get('pinDetail', 'PinController@selectPinForDetail');

// review
Route::post('addReview','PinController@insertReview');
// floorAlert profile
Route::post('subscriberInfo','PinController@selectUserInfo');
Route::post('subscriberPinInfo','PinController@selectPinUserHas');

// chat receive request.
Route::post('chat', function(){
    Session::set('chat', Input::get('chat'));
    Session::set('name', Auth::user()->name);
    return View::make('indexMap')->withInput(Input::all());
});

// config pop
Route::post('cfg', 'UserController@updateCfg'); 
Route::post('cfg_close', function(){
    Session::put('cfg', 'true');
}); 


// map use count update
Route::post('mapUseCnt', 'UserController@updateMapUse');


// check user
Route::get('checkUser', function(){
    dd(Auth::id());
});


// logout
Route::get('logout', 'Auth\AuthController@getLogout');

// facebook link test 
Route::get('facebooklink', 'FacebookController@linktest');

// Code 
Route::post('saveCode', 'CodeController@insertCode');
Route::get('callGrpCd', 'CodeController@selectGrpCode');
Route::get('callCdList', 'CodeController@selectCodeList');
Route::get('callCdListByLevel', 'CodeController@selectCodeListByLevel');
Route::get('callCdListByGrp', 'CodeController@selectCodeListByGrp');
Route::get('callSingleCd', 'CodeController@selectSingleCode');
Route::get('deleteCd', 'CodeController@deleteCode');

// User
Route::post('callUserInfo', 'UserController@selectUser');

// password reset
Route::post('password/sendPassMail', 'CustomPasswordController@sendMailForPass');
Route::get('password/reset/{token?}', 'CustomPasswordController@showResetForm');
Route::post('password/reset', 'CustomPasswordController@reset');
Route::post('password/changePassword', 'CustomPasswordController@updatePassword');


// Auth check
Route::get('authCheck', function(){
    dd(Auth::check()); 
});


// file single upload
Route::post('singleUpload', 'PinController@insertSingleFile');


/*
// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');


// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');

Route::get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
Route::post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
Route::post('password/reset','Auth\PasswordController@reset');
*/


Route::controllers([
    'auth' => 'Auth\AuthController',
    //'password' => 'Auth\PasswordController',
]);

// mail 
Route::get('mailTest', 'MailController@sendMail');


// facebook login
Route::post('facebook', 'FacebookController@redirectToProvider');
Route::get('facebook/callback', 'FacebookController@handleProviderCallback');
Route::get('checkFbSession', 'FacebookController@checkUserFromHead');

// Redis Test
Route::get('socket', 'SocketController@index');
Route::post('sendmessage', 'SocketController@sendMessage');
Route::get('writemessage', 'SocketController@writemessage');


// foursquare pins
Route::get('fourPins', 'FoursquareController@fourPins');

// foursquare categories
Route::get('fourCategories', 'FoursquareController@fourCategories');

// test categories
Route::get('fourTest', 'FoursquareController@fourTest');

// foursquare explore
Route::get('fourExplore', 'FoursquareController@fourExplore');

// foursquare pin venue (single one)
Route::get('fourPinVenue', 'FoursquareController@fourPinVenue');

// single pin from db 
Route::get('fourSinglePin', 'FoursquareController@selectSinglePin');


// error page 
Route::get('pageNotFound', ['as'=> 'notfound', 'uses'=>'HomeController@pagenotfound']);
Route::get('exception/error', function(){
    return view('errors/error', ['msg'=>'NO PIN CODE SEARCHED AT THIS TIME!']);
});
Route::get('500',['as'=> 'somethingWrong', 'uses'=>'HomeController@somethingWrong']);

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});







// ================================= mobile ======================================

Route::get('m_getSlider','PinController@selectPins');

Route::get('autocomplete', function(){
    return view('autocomplete');
});

Route::get('indexGuest_autocomplete', function(){
    return view('indexGuest_autocomplete');
});
