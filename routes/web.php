<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\http\Controllers\StudentController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\IncriptionsController;
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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('people', PersonController::class);
    Route::resource('professors', ProfessorController::class);
    Route::resource('incriptions', IncriptionsController::class);
    Route::get('/students',[StudentController::class,'index'])->name('students.index');
});
//la primera es la direccion de la pagina \about la segunda es el nombre del archivo respectivo vue que esta dentro de la carpeta pages
Route::inertia('about','about');

require __DIR__.'/auth.php';
