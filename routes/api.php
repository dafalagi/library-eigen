<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\MemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::apiResources([
    'books' => BookController::class,
    'members' => MemberController::class,
    'borrows' => BorrowController::class,
]);
