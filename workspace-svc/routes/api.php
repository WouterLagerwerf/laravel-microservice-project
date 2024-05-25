<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Workspaces\WorkspaceController;
Route::group(['middleware' => 'client'], function () {
    Route::apiResource('workspaces', WorkspaceController::class);
});