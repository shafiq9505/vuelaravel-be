<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PhotoController;

// User
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');

// Photo upload
Route::post('/photos/upload', [PhotoController::class, 'uploadPhoto']);
Route::get('/photos/{filename}', [PhotoController::class, 'getPhoto']);

// Books
Route::get("/books", [BookController::class, "index"]);
Route::get("/books/{id}", [BookController::class, "show"]);
Route::post("/books", [BookController::class, "store"]);
Route::put("/books", [BookController::class, "update"]);
Route::delete("/books", [BookController::class, "destroy"]);


Route::post('/photos', [PhotoController::class, 'uploadPhoto']);
Route::get('/photos/{filename}', [PhotoController::class, 'getPhoto']);
