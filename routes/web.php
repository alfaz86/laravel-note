<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;


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

Route::get('/', [NoteController::class, 'index'])->name('index');

// prefix note
Route::prefix('note')->group(function () {
    Route::get(
        '/new', 
        [NoteController::class, 'new']
    )->name('note.new');
    Route::post(
        '/store', 
        [NoteController::class, 'store']
    )->name('note.store');
    Route::get(
        '/{id}', 
        [NoteController::class, 'edit']
    )->name('note.edit');
    Route::put(
        '/{id}/update', 
        [NoteController::class, 'update']
    )->name('note.update');
    Route::delete(
        '/delete', 
        [NoteController::class, 'delete']
    )->name('note.delete');
});
