<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

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

Route::get('/login', [DashboardController::class, "login"])->middleware("guest");
Route::post('/login', [DashboardController::class, "loginPost"]);
Route::get('/logout', [DashboardController::class, "logout"]);

Route::middleware(['login'])->group(function () {
  Route::get('/', [DashboardController::class, "home"]);

  Route::post('/start-instance', [DashboardController::class, "startInstance"]);
  Route::post('/delete-instance', [DashboardController::class, "deleteInstance"]);
  Route::get('/activity/{idInstance}', [DashboardController::class, "activity"]);

  Route::get('/activity/{idInstance}/mempertimbangkan-permohonan-cuti', [DashboardController::class, "activityMempertimbangkanPermohonanCuti"]);
  Route::post('/mempertimbangkan-permohonan-cuti', [DashboardController::class, "mempertimbangkanPermohonanCutiPost"]);

  Route::get('/activity/{idInstance}/memberikan-tanda-tangan', [DashboardController::class, "activityMemberikanTandaTangan"]);
  Route::post('/memberikan-tanda-tangan', [DashboardController::class, "memberikanTandaTanganPost"]);

  Route::get('/activity/{idInstance}/memberikan-pengesahan-tanda-tangan', [DashboardController::class, "activityMemberikanPengesahanTandaTangan"]);
  Route::post('/memberikan-pengesahan-tanda-tangan', [DashboardController::class, "memberikanPengesahanTandaTanganPost"]);
});
