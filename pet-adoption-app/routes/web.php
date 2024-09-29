<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LostPetsController;
use App\Http\Controllers\PetsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\BlogController;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/home', [HomeController::class, 'mainPage'])->middleware(['auth', 'verified'])->name('home');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('posts', BlogController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);


Route::resource('pets', PetsController::class)
    ->only(['index', 'create', 'store'])
    ->middleware(['auth', 'verified']);

Route::get('/pets/{id}/edit', [PetsController::class, 'edit'])->name('pets.edit');
Route::put('/pets/{id}', [PetsController::class, 'update'])->name('pets.update');

Route::delete('/pets/{id}', [PetsController::class, 'destroy'])->name('pets.destroy');
Route::get('/pets/{id}', [PetsController::class, 'show'])->name('pets.show');

require __DIR__.'/auth.php';

Route::resource('lost-pets', LostPetsController::class)
    ->only(['index', 'create', 'store'])
    ->middleware(['auth', 'verified']);

Route::get('/lost-pets/{id}/edit', [LostPetsController::class, 'edit'])->name('lost-pets.edit');
Route::put('/lost-pets/{id}', [LostPetsController::class, 'update'])->name('lost-pets.update');

Route::delete('/lost-pets/{id}', [LostPetsController::class, 'destroy'])->name('lost-pets.destroy');
Route::get('/lost-pets/{id}', [LostPetsController::class, 'show'])->name('lost-pets.show');

Route::resource('donations', DonationController::class)
    ->only(['index', 'create', 'store'])
    ->middleware(['auth', 'verified']);

Route::get('/donations/{id}/edit', [DonationController::class, 'edit'])->name('donations.edit');
Route::put('/donations/{id}', [DonationController::class, 'update'])->name('donations.update');

Route::delete('/donations/{id}', [DonationController::class, 'destroy'])->name('donations.destroy');


Route::resource('faqs', FaqController::class)
    ->only(['index', 'create', 'store'])
    ->middleware(['auth', 'verified']);


Route::get('/application/{petId}', [ApplicationController::class, 'create'])->name('application.form');
Route::post('/application/{petId}', [ApplicationController::class, 'store'])->name('application.store');


Route::get('/applications', [ApplicationController::class, 'showApplications'])->name('pets.applications');
Route::get('/applications/inbox', [ApplicationController::class, 'inbox'])->name('pets.inbox');
Route::get('/pets/{id}/application/{appId}', [ApplicationController::class, 'show'])->name('application.show');

Route::get('/pets/{id}/adopt/{appId}', [PetsController::class, 'markAsAdopted'])->name('pets.adopt');

Route::get('/profile/{id}', [ProfileController::class, 'showUser'])->name('profile.showUser');
