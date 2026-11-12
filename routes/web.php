<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminController::class, 'login'])->name('login.submit');

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
        Route::resource('projects', ProjectController::class);
        Route::resource('certificates', CertificateController::class);
        Route::resource('experiences', ExperienceController::class)->except(['show']);
        Route::resource('skills', SkillController::class)->except(['show']);
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::resource('messages', MessageController::class)->only(['index', 'show', 'destroy']);
        Route::resource('feedback', FeedbackController::class)->only(['index', 'show', 'destroy']);
    });
});
