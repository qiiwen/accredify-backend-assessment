<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::post('/createpatient',  [PatientController::class, 'createPatient'])->middleware(['auth']);

# test routes
Route::post('/testNric',  [PatientController::class, 'testNric']);
Route::post('/testNationality',  [PatientController::class, 'testNationality']);
Route::post('/testGender',  [PatientController::class, 'testGender']);
Route::post('/testBirthdate',  [PatientController::class, 'testBirthdate']);

require __DIR__ . '/auth.php';
