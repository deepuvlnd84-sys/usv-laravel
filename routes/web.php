<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScrollingMessageController;
use App\Models\ScrollingMessage;

use App\Http\Controllers\TournamentController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;

// Home Page Route
Route::get('/', function () {
    $activeMessages = ScrollingMessage::where('is_active', true)->latest()->get();
    return view('welcome', compact('activeMessages'));
});

// Club About Routes (Public View, Admin Edit & Update)
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/about/edit', [AboutController::class, 'edit'])->name('about.edit');
Route::put('/about', [AboutController::class, 'update'])->name('about.update');

// Contact Page & Management Routes
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/contact/manage', [ContactController::class, 'manage'])->name('contact.manage');
Route::post('/contact/settings', [ContactController::class, 'updateSettings'])->name('contact.settings.update');
Route::post('/contact/persons', [ContactController::class, 'storePerson'])->name('contact.persons.store');
Route::put('/contact/persons/{id}', [ContactController::class, 'updatePerson'])->name('contact.persons.update');
Route::delete('/contact/persons/{id}', [ContactController::class, 'destroyPerson'])->name('contact.persons.destroy');



// Scrolling Message Routes (Admin only)
Route::get('/scrolling-messages', [ScrollingMessageController::class, 'edit'])->name('scrolling-messages.edit');
Route::get('/scrolling-messages/edit', [ScrollingMessageController::class, 'edit']);
Route::post('/scrolling-messages', [ScrollingMessageController::class, 'store'])->name('scrolling-messages.store');
Route::patch('/scrolling-messages/{id}/toggle', [ScrollingMessageController::class, 'toggle'])->name('scrolling-messages.toggle');
Route::delete('/scrolling-messages/{id}', [ScrollingMessageController::class, 'destroy'])->name('scrolling-messages.destroy');

// Authentication Routes (Player OTP & Admin)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login/send-otp', [AuthController::class, 'sendOtp'])->name('login.send-otp');
Route::get('/login/verify', [AuthController::class, 'showVerifyForm'])->name('login.verify');
Route::post('/login/verify', [AuthController::class, 'verifyOtp'])->name('login.verify.post');
Route::get('/login/admin', [AuthController::class, 'showAdminLoginForm'])->name('login.admin');
Route::post('/login/admin', [AuthController::class, 'adminLogin'])->name('login.admin.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard Route
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

// Tournaments Routes (View for all, Add/Edit/Delete for Admin)
Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
Route::get('/tournaments/{id}', [TournamentController::class, 'show'])->name('tournaments.show');
Route::post('/tournaments', [TournamentController::class, 'store'])->name('tournaments.store');
Route::put('/tournaments/{id}', [TournamentController::class, 'update'])->name('tournaments.update');
Route::delete('/tournaments/{id}', [TournamentController::class, 'destroy'])->name('tournaments.destroy');

// Gallery Route
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery');

// Player / Member Routes (List, Profile, Add, Edit, Delete, Search)
Route::get('/players', [PlayerController::class, 'index'])->name('players.index');
Route::get('/members', [PlayerController::class, 'index'])->name('members');
Route::get('/members/search', [PlayerController::class, 'search'])->name('members.search');
Route::get('/members/{sl_no}/profile', [PlayerController::class, 'profile'])->name('members.profile');
Route::get('/members/{sl_no}', [PlayerController::class, 'profile']);
Route::post('/members', [PlayerController::class, 'store'])->name('members.store');
Route::put('/members/{id}', [PlayerController::class, 'update'])->name('members.update');
Route::delete('/members/{id}', [PlayerController::class, 'destroy'])->name('members.destroy');

// Backward compatibility aliases for players
Route::get('/players/search', [PlayerController::class, 'search'])->name('players.search');
Route::get('/players/create', [PlayerController::class, 'create'])->name('players.create');
Route::post('/players', [PlayerController::class, 'store'])->name('players.store');
Route::put('/players/{id}', [PlayerController::class, 'update'])->name('players.update');
Route::delete('/players/{id}', [PlayerController::class, 'destroy'])->name('players.destroy');