<?php
require_once __DIR__ ."/../core/Route.php";
require_once __DIR__ ."/./../App/controllers/api/UserController.php";
Route::get("/api/v1/getAllUsers", UserController::class, 'getAllUsers');