<?php

use App\Models\Listings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing

//All listing
Route::get('/', [ListingController::class, 'index'])->name('listing.index');
//show create form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth')->name('listing.create');
//store listing data
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth')->name('listing.store');
//show edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth')->name('listing.edit');
//Update lisiting
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth')->name('listings.update');
//delete lisiting
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth')->name('listings.destroy');
//manage lisiting
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth')->name('listing.manage');
//show single listing
Route::get('/listings/{id}', [ListingController::class, 'show'])->name('listing.show');

//show registeration/create form
Route::get('/register', [UserController::class, 'create'])->middleware('guest')->name('user.create');
//create new user
Route::post('/users', [UserController::class, 'store'])->name('user.store');
//log user out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth')->name('user.logout');
//Show login form
Route::get('/login', [UserController::class, 'login'])->middleware('guest')->name('login');
//log user in
Route::post('/users/authenticate', [UserController::class, 'authenticate'])->name('user.authenticate');

