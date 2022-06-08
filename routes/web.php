<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Http;
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

// Route::get('/', function () {
//     // $response = Http::post("http://localhost:8080/engine-rest/process-definition/Process_0hjh5q5:1:6e1b6a5d-e608-11ec-9291-0a0027000002/start",[
//     // ]);
//     // $response = Http::post("http://localhost:8080/engine-rest/process-definition/Process_0hjh5q5:1:6e1b6a5d-e608-11ec-9291-0a0027000002/start",[
//     //     "variables" => [
//     //         "name" => [
//     //             "value" => "John Doe",
//     //             "type" => "String"
//     //         ]
//     //     ]
//     // ]);

//     $response = Http::post("http://localhost:8080/engine-rest/process-instance", [
//         "processDefinitionId" => "Process_0hjh5q5:1:6e1b6a5d-e608-11ec-9291-0a0027000002",
//     ]);
//     $json =  $response->json();

//     $data = [];
//     foreach ($json as $js) {
//         $call = Http::get("http://localhost:8080/engine-rest/process-instance/".$js['id'] . '/activity-instances');
//         $call = $call->json();
//         $data[] = $call;
//     }
    
//     $data2 = [];
//     foreach ($json as $js) {
//         $call = Http::get("http://localhost:8080/engine-rest/task", [
//             'processInstanceId' => $js['id']
//         ]);
//         $call = $call->json();
//         $data2[] = $call;
//     }
    
//     $data3 = [];
//     foreach ($json as $js) {
//         $call = Http::get("http://localhost:8080/engine-rest/variable-instance", [
//             'processInstanceIdIn' => $js['id']
//         ]);
//         $call = $call->json();
//         $data3[] = $call;
//     }
    

//     return $data3;
//     // return view("welcome", compact("json"));
// });


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

