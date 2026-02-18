<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\MeetingController as AdminMeetingController;
use App\Http\Controllers\Admin\MunicipalityController as AdminMunicipalityController;
use App\Http\Controllers\Admin\InterestingPlaceController as AdminInterestingPlaceController;
use App\Http\Controllers\Admin\TrekController as AdminTrekController;
use Illuminate\Support\Facades\Route;

// Página de bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (solo usuarios autenticados y verificados)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Perfil de usuario autenticado
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Panel de administración (solo admin)
Route::middleware(['auth', 'check.role.admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        // Usuarios
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::get('/users/{admin_user}', [AdminUserController::class, 'show'])
            ->whereNumber('admin_user')
            ->name('users.show');
        Route::get('/users/{admin_user}/edit', [AdminUserController::class, 'edit'])
            ->whereNumber('admin_user')
            ->name('users.edit');
        Route::patch('/users/{admin_user}', [AdminUserController::class, 'update'])
            ->whereNumber('admin_user')
            ->name('users.update');
        Route::patch('/users/{admin_user}/deactivate', [AdminUserController::class, 'deactivate'])
            ->whereNumber('admin_user')
            ->name('users.deactivate');
        Route::patch('/users/{admin_user}/activate', [AdminUserController::class, 'activate'])
            ->whereNumber('admin_user')
            ->name('users.activate');

        // Comentarios
        Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments.index');
        Route::get('/comments/{admin_comment}', [AdminCommentController::class, 'show'])
            ->whereNumber('admin_comment')
            ->name('comments.show');
        Route::get('/comments/{admin_comment}/edit', [AdminCommentController::class, 'edit'])
            ->whereNumber('admin_comment')
            ->name('comments.edit');
        Route::patch('/comments/{admin_comment}', [AdminCommentController::class, 'update'])
            ->whereNumber('admin_comment')
            ->name('comments.update');
        Route::patch('comments/{admin_comment}/deactivate', [AdminCommentController::class, 'deactivate'])->name('comments.deactivate');
        Route::patch('comments/{admin_comment}/activate', [AdminCommentController::class, 'activate'])->name('comments.activate');

        // Excursiones (CRUD)
        Route::get('/treks', [AdminTrekController::class, 'index'])->name('treks.index');
        Route::get('/treks/create', [AdminTrekController::class, 'create'])->name('treks.create');
        Route::post('/treks', [AdminTrekController::class, 'store'])->name('treks.store');
        Route::get('/treks/{admin_trek}', [AdminTrekController::class, 'show'])
            ->whereNumber('admin_trek')
            ->name('treks.show');
        Route::get('/treks/{admin_trek}/edit', [AdminTrekController::class, 'edit'])
            ->whereNumber('admin_trek')
            ->name('treks.edit');
        Route::patch('/treks/{admin_trek}', [AdminTrekController::class, 'update'])
            ->whereNumber('admin_trek')
            ->name('treks.update');
        Route::patch('/treks/{trek}/deactivate', [AdminTrekController::class, 'deactivate'])
            ->whereNumber('trek')
            ->name('treks.deactivate');
        Route::patch('/treks/{trek}/activate', [AdminTrekController::class, 'activate'])
            ->whereNumber('trek')
            ->name('treks.activate');   
           


        // Meetings (CRUD)
        Route::get('/meetings', [AdminMeetingController::class, 'index'])->name('meetings.index');
        Route::get('/meetings/create', [AdminMeetingController::class, 'create'])->name('meetings.create');
        Route::post('/meetings', [AdminMeetingController::class, 'store'])->name('meetings.store');
        Route::get('/meetings/{admin_meeting}', [AdminMeetingController::class, 'show'])
            ->whereNumber('admin_meeting')
            ->name('meetings.show');
        Route::get('/meetings/{admin_meeting}/edit', [AdminMeetingController::class, 'edit'])
            ->whereNumber('admin_meeting')
            ->name('meetings.edit');
        Route::patch('/meetings/{admin_meeting}', [AdminMeetingController::class, 'update'])
            ->whereNumber('admin_meeting')
            ->name('meetings.update');
        Route::delete('/meetings/{admin_meeting}', [AdminMeetingController::class, 'destroy'])
            ->whereNumber('admin_meeting')
            ->name('meetings.destroy');
        Route::post('/meetings/{admin_meeting}/guides', [AdminMeetingController::class, 'addGuide'])
            ->whereNumber('admin_meeting')
            ->name('meetings.guides.add');
        Route::delete('/meetings/{admin_meeting}/guides/{user}', [AdminMeetingController::class, 'removeGuide'])
            ->whereNumber('admin_meeting')
            ->whereNumber('user')
            ->name('meetings.guides.remove');

        // Municipios (CRUD)
        Route::get('/municipalities', [AdminMunicipalityController::class, 'index'])->name('municipalities.index');
        Route::get('/municipalities/create', [AdminMunicipalityController::class, 'create'])->name('municipalities.create');
        Route::post('/municipalities', [AdminMunicipalityController::class, 'store'])->name('municipalities.store');
        Route::get('/municipalities/{admin_municipality}', [AdminMunicipalityController::class, 'show'])
            ->whereNumber('admin_municipality')
            ->name('municipalities.show');
        Route::get('/municipalities/{admin_municipality}/edit', [AdminMunicipalityController::class, 'edit'])
            ->whereNumber('admin_municipality')
            ->name('municipalities.edit');
        Route::patch('/municipalities/{admin_municipality}', [AdminMunicipalityController::class, 'update'])
            ->whereNumber('admin_municipality')
            ->name('municipalities.update');

        // Places (CRUD)
        Route::get('/places', [AdminInterestingPlaceController::class, 'index'])->name('places.index');
        Route::get('/places/create', [AdminInterestingPlaceController::class, 'create'])->name('places.create');
        Route::post('/places', [AdminInterestingPlaceController::class, 'store'])->name('places.store');
        Route::get('/places/{admin_place}', [AdminInterestingPlaceController::class, 'show'])
            ->whereNumber('admin_place')
            ->name('places.show');
        Route::get('/places/{admin_place}/edit', [AdminInterestingPlaceController::class, 'edit'])
            ->whereNumber('admin_place')
            ->name('places.edit');
        Route::patch('/places/{admin_place}', [AdminInterestingPlaceController::class, 'update'])
            ->whereNumber('admin_place')
            ->name('places.update');
        Route::patch('places/{admin_place}/deactivate', [AdminInterestingPlaceController::class, 'deactivate'])->name('places.deactivate');
        Route::patch('places/{admin_place}/activate', [AdminInterestingPlaceController::class, 'activate'])->name('places.activate');
        Route::delete('admin/places/{admin_place}', [AdminInterestingPlaceController::class, 'destroy'])->name('places.destroy');


    });

// Rutas de autenticación Breeze
require __DIR__.'/auth.php';
