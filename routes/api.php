<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\GardenerController;
use App\Http\Controllers\LocationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::group(['middleware' => ['cors', 'json.response']], function () {

        Route::post('customer/register', [CustomerController::class, 'register']);
        Route::post('gardener/register', [GardenerController::class, 'register']);


        Route::middleware('auth:api')->group(function () {

            Route::get('customers', [CustomerController::class, 'getAllCustomers']);
            Route::get('customers/{location}', [CustomerController::class, 'getCustomersByLocation']);

            Route::get('locations', [LocationController::class, 'getLocations']);

            Route::get('gardeners', [GardenerController::class, 'getAllGardeners']);
            Route::get('gardeners/{country}', [GardenerController::class, 'getGardenersByCountry']);
        });
    });
});
