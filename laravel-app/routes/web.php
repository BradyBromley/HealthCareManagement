<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\AppointmentController;

// Auth Routes
Route::get('/auth/login', function () {
    return view('auth.login');
});

Route::get('/auth/register', function () {
    return view('auth.register');
});

Route::post('/auth/register', 'App\Http\Controllers\AuthController@register');
Route::post('/auth/login', 'App\Http\Controllers\AuthController@authenticate');
Route::post('/auth/logout', 'App\Http\Controllers\AuthController@logout');

Route::middleware('auth')->group(function () {
    // Base Route
    Route::get('/', function () {
        return view('index');
    });

    // User Routes
    Route::get('/users/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('user.update');

    Route::middleware('permission:userListing')->group(function () {
        Route::get('/users', [UserController::class, 'index'])->name('user.index');
        Route::get('/users/{user}/updateAvailability', [AvailabilityController::class, 'updateAvailability'])->name('user.updateAvailability');
        Route::post('/users/{user}/updateEndTime', [AvailabilityController::class, 'updateEndTime'])->name('user.updateEndTime');
    });

    Route::middleware('permission:admin')->group(function ()  {
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    });

    // Appointment Routes
    Route::middleware('permission:appointmentListing')->group(function () {
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointment.index');
        Route::get('/appointments/{appointment}/changeStatus/{status}', [AppointmentController::class, 'changeStatus'])->name('appointment.changeStatus');
    });

    Route::middleware('permission:bookAppointment')->group(function () {
        Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointment.create');
        Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointment.store');
        Route::post('/appointments/updateAppointmentAvailability', [AppointmentController::class, 'updateAppointmentAvailability'])->name('appointment.updateAppointmentAvailability');
    });

    Route::middleware('permission:admin')->group(function ()  {
        Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointment.destroy');
    });
});


