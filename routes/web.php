<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['namespace'	=>	"Frontend"], function(){
	Route::get("/", 'FrontController@index');
	Route::get("/services", 'FrontController@services');
	Route::get("/service/{id}", 'FrontController@service');

	Route::get("/blogs", 'FrontController@blogs');
	Route::get("/blog/{id}", 'FrontController@blog');

	Route::get("/videos", 'FrontController@videos');

	

	Route::get("/contact", 'FrontController@contact');
	Route::get("/video", 'FrontController@video');

	Route::get("/groupe", 'FrontController@teamMember');
	Route::get("/about", 'FrontController@about');
	Route::get("/travail", 'FrontController@travail');
	Route::get("/structure", 'FrontController@structure');
	Route::get("/don", 'FrontController@don');
	Route::get("/partenariat", 'FrontController@partenariat');

	Route::get("/galeryphoto", 'FrontController@galeryphoto');


	Route::post("/sendMessage", 'FrontController@sendMessage')->name("sendMessage");
	
	
});





Route::get('/dashbord', function () {
    return view('backend.dashbord');
});

Route::get('/login', function () {
    return view('frontend.connexion');
});

Route::get('/register', function () {
    return view('frontend.connexion');
});

Route::get('/registerEntreprise', function () {
    return view('frontend.register');
});

Route::get('/forgot', function () {
    return view('frontend.forgot');
});

Route::get('resete', function () {
    return view('frontend.resete');
});








Route::group(['namespace'	=>	"Connexion"], function(){
	Route::post("checkLogin", 'ConnexionController@checkLogin');
	Route::post("register_count", 'ConnexionController@createCount');
	Route::get("logout", 'ConnexionController@logout');
	
	
});

Route::group(['namespace'	=>	"User"], function(){
	Route::post("insert_personne", 'UserController@insert_user');
	
});



// Route::post('/register_count', function(Request $request){
// 	 $data = DB::insert('insert into users (name, email,password,remember_token,id_role,sexe,avatar, telephone, adresse) values (:name, :email,:password,:remember_token,:id_role,:sexe,:avatar,:telephone,:adresse)', [
//             ':name'             =>  $request->name, 
//             ':email'            =>  $request->email,
//             ':telephone'        =>  $request->telephone,
//             ':adresse'          =>  $request->adresse,
//             ':password'         =>  Hash::make($request->password),
//             ':remember_token'   =>  Hash::make(rand(0,10)),
//             ':id_role'          =>  2,
//             ':sexe'             =>  $request->sexe,
//             ':avatar'           =>  "avatar.png"
//         ]);

// 	 return response()->json([
// 	 	'data'		=>	"insertion avec succès",
// 	 	'success'	=>	$data
// 	 ]);
// });


Route::group(['namespace'	=>	"User"], function(){
	Route::post('/reset_password_without_token', 'UserController@validatePasswordRequest');
	Route::get('/reset/{token}/{email}', 'UserController@reset_password');
	
    Route::post('/reset_password_with_token', 'UserController@resetPassword');
	
});


/*
* messages routes
*===============
*
*/
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/private', 'HomeController@private')->name('private');
Route::get('/users', 'HomeController@users')->name('users');

Route::get('messages', 'MessageController@fetchMessages');
Route::post('messages', 'MessageController@sendMessage');
Route::get('/private-messages/{user}', 'MessageController@privateMessages')->name('privateMessages');
Route::post('/private-messages/{user}', 'MessageController@sendPrivateMessage')->name('privateMessages.store');



/*
* messages routes
*===============
*
*/









Route::get('/{any}', function () {
    return view('backend.dashbord');
})->where('any', '.*');

