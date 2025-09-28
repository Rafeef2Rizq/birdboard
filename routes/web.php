<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectTasksController;
use App\Models\Activity;
use App\Models\Project;
use Illuminate\Support\Facades\Route;






Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



Route::get('/', function () {
    return view('welcome');
});


// Project::create(request(key: ['title','description']));
Route::group(['middleware'=>'auth'],function(){
Route::post('/projects', [ProjectController::class,'store']);
Route::get('/projects',[ProjectController::class,'index']); 
Route::get('/projects/create',[ProjectController::class,'create']); 
Route::get('/projects/{project}',[ProjectController::class,'show']);
Route::get('/projects/{project}/edit',[ProjectController::class,'edit']);

Route::patch('/projects/{project}',[ProjectController::class,'update']);

Route::post( '/projects/{project}/tasks',[ProjectTasksController::class,'store']);
Route::patch( '/projects/{project}/tasks/{task}',[ProjectTasksController::class,'update']);


});