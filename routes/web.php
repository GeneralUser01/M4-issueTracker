<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\CommentController;

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

Route::get('/', [ProjectController::class, 'index']);
Route::resource('projects', ProjectController::class);
Route::put('projects/{project}/edit', 'App\Http\Controllers\ProjectController@update');

Route::get('projects/{project}/closed', [IssueController::class, 'closed']);
Route::get('projects/{project}/closed/{issue}', [IssueController::class, 'showClosed']);
Route::get('projects/{project}/closed/{issue}/edit', [IssueController::class, 'editClosed']);
Route::get('projects/{project}/all', [IssueController::class, 'all']);
Route::get('projects/{project}/all/{issue}', [IssueController::class, 'showAll']);
Route::get('projects/{project}/all/{issue}/edit', [IssueController::class, 'editAll']);

Route::put('projects/{project}/issues/{issue}/changeStatus', [IssueController::class, 'changeStatus']);
Route::resource('projects/{project}/issues', IssueController::class);
Route::resource('projects/{project}/issues/{issue}/comments', CommentController::class, ['only' => ['store']]);
Route::resource('projects/register', App\Http\Controllers\UsersController::class);

Route::get('/landing', [App\Http\Controllers\PageController::class, 'landing']);
Route::get('/login', [App\Http\Controllers\UsersController::class, 'logIn']);
Route::get('/register', [App\Http\Controllers\UsersController::class, 'register']);
Route::get('/landing', [App\Http\Controllers\UsersController::class, 'logOut']);