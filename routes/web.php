<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Guest\PageController;
use App\Http\Controllers\Admin\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\Admin\ProjectsController;
use App\Http\Controllers\Admin\TypesController;
use App\Http\Controllers\Admin\TechnologiesController;

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

Route::get('/', [PageController::class, 'index'])->name('home');

route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        //qui dentro tutte le rotte che voglio proteggere
        route::get('/', [DashboardController::class, 'index'])->name('home');
        route::resource('projects', ProjectsController::class);
        route::resource('types', TypesController::class);
        route::resource('technologies', TechnologiesController::class);
        //sono rotte custom che non fanno parte del crud
        Route::get('order/{direction}/{column}', [ProjectsController::class, 'order'])->name('projects.order');
    });
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
