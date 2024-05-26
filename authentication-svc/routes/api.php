<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ValidateWorkspace;
use App\Http\Controllers\UsersController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::middleware([ValidateWorkspace::class])->group(function () {
    Route::group(['prefix' => '{workspace_endpoint}'], function () {
        Route::apiResource('users', UsersController::class);
        Route::post('users/{id}/roles', [UsersController::class, 'addRole']);
        Route::delete('users/{id}/roles', [UsersController::class, 'removeRole']);
    });
});

Route::get('testing', function () {
    $job = new \App\Jobs\Workspaces\CreateWorkspaceEvent([
        'endpoint' => 'asfasfasfasfqwqeqeqqqqqwefsft',
    ]);

    $job->handle(new \App\Services\DbService(), new \App\Services\ClientService());
});