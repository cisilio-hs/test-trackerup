<?php

use App\Http\Controllers\Api\PecaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(
   env('API_AUTH') ? ['auth:sanctum'] : []
)
->group(function () {
    // Route::apiResource('pecas', PecaController::class);


    Route::get('pecas', [ PecaController::class,'index' ])->name('pecas.index');
    Route::post('pecas', [ PecaController::class,'store' ])->name('pecas.store');
    Route::get('pecas/{peca}', [ PecaController::class,'show' ])->name('pecas.show');
    Route::get('pecas/{codigo}/codigo', [ PecaController::class,'showByCode' ])->name('pecas.show_by_code');
    Route::post('pecas/{peca}', [ PecaController::class,'update' ])->name('pecas.update');
    Route::post('pecas/{codigo}/codigo', [ PecaController::class,'updateByCode' ])->name('pecas.update_by_code');
    Route::delete('pecas/{peca}', [ PecaController::class,'destroy' ])->name('pecas.destroy');
    Route::delete('pecas/{codigo}/codigo', [ PecaController::class,'destroyByCode' ])->name('pecas.destroye_by_code');
    Route::get('trash/pecas', [ PecaController::class,'trash' ])->name('pecas.trash');
    Route::post('trash/pecas/{peca}/restore', [ PecaController::class,'restore' ])->name('pecas.restore');
    Route::post('trash/pecas/{codigo}/codigo/restore', [ PecaController::class,'restoreByCode' ])->name('pecas.restore_by_code');


});

