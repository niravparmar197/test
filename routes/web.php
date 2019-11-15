<?php

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

Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home2');

Route::group(["middleware"=>"auth"],function(){
	Route::resource('agent', 'AgentController')->middleware('can:onlyAdmin');
	Route::resource('event', 'EventController')->middleware('can:onlyAdmin');
	Route::resource('guest', 'GuestController');
	Route::get('guest_listing', 'GuestController@adminIndex')->name("guest.admin.index")->middleware('can:onlyAdmin');
	Route::get('guest_view/{id}', 'GuestController@adminView')->name("guest.admin.view")->middleware('can:onlyAdmin');
	Route::get('thank_you/{ticketId}', 'GuestController@thankYou')->name("guest.thankyou")->middleware('can:guest-thank-you');
	Route::get('review/{ticketId}', 'GuestController@guestReview')->name("guest.review")->middleware('can:guest-review');
	Route::post('review/{ticketId}', 'GuestController@postGuestReview')->name("guest.review.post")->middleware('can:guest-review');
	Route::get('guest_assign/{ticketId}', 'GuestController@assign')->name("guest.assign")->middleware('can:guest-assign');
	Route::get('set_dashboard/{id}', 'HomeController@setDashboard')->name("set_dashboard");

	Route::get("guest_revisit/listing", "GuestController@guestRevisitListing")->name("guest.revisit.index");

	Route::get("guest_revisit/feedback/{ticketId}", "GuestController@guestRevisitFeedback")->name("guest.revisit.feedback");

	Route::post("guest_revisit/feedback", "GuestController@postGuestRevisitFeedback")->name("guest.revisit.feedback.post");
});
