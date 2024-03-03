<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ApiController;

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

Route::group(['prefix' => 'v1'], function () {

    /*
     * Parameters: url
     * Authentication: Bearer Token
     * Call: checks token and calls tinyurl
     * Return: shortened url
     */
    Route::post('short-urls', [ApiController::class,'shortUrls'])->name('short-urls');
});
