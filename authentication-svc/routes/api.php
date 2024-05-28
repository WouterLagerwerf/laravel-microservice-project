<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ValidateWorkspace;
use App\Http\Controllers\UsersController;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\TransientTokenController;
use Laravel\Passport\Http\Controllers\AuthorizationController;
use Laravel\Passport\Http\Controllers\ApproveAuthorizationController;
use Laravel\Passport\Http\Controllers\DenyAuthorizationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::middleware([ValidateWorkspace::class])->group(function () {
    Route::group(['prefix' => '{workspace_endpoint}'], function () {
        Route::apiResource('users', UsersController::class);
        Route::post('users/{id}/roles', [UsersController::class, 'addRole']);
        Route::delete('users/{id}/roles', [UsersController::class, 'removeRole']);
         // redefining the passport routes we need
        Route::post('/oauth/token', [AccessTokenController::class, 'issueToken']);
        Route::post('/oauth/token/refresh', [TransientTokenController::class, 'refresh']);
        Route::get('/oauth/authorize', [AuthorizationController::class, 'authorize']);
        Route::post('/oauth/authorize', [ApproveAuthorizationController::class, 'approve']);
        Route::delete('/oauth/authorize', [DenyAuthorizationController::class, 'deny']);
    });
});
