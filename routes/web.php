<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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
    return redirect('employee/login');
});

Route::get('/coba', function () {
    try {
        DB::connection()->getPdo();
        echo "tes";
    } catch (\Exception $e) {
        die("Could not connect to the database.  Please check your configuration. error:" . $e );
    }
});

Route::prefix('employee')->middleware('guest')->group(function () {
    Route::view('login', 'login');
    Route::post('login', [LoginController::class, 'Login']);
});

Route::middleware('login')->group(function () {
    Route::get('home', function () {
        return redirect('employee/chart');
    });

    Route::prefix('employee')->group( function () {
        Route::post('logout', [LoginController::class, 'Logout']);

        Route::middleware('viewer')->group(function () {
            Route::get('employee', [EmployeeController::class,'index']);
            Route::get('getEmployee', [EmployeeController::class, 'getEmployee']);
        });
        
        Route::get('chart', [EmployeeController::class, 'chart']);
        Route::get('getChart', [EmployeeController::class, 'getChartEmployee']);
    });
});
