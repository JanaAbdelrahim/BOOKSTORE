<?php

require_once __DIR__ . "/../core/Route.php";
require_once __DIR__ . "/../app/controllers/web/homeController.php";
require_once __DIR__ . "/../app/controllers/web/auth/loginController.php";
require_once __DIR__ . "/../app/controllers/web/auth/registerController.php";
require_once __DIR__ . "/../app/controllers/web/profile/profileController.php";
require_once __DIR__ . "/../app/controllers/web/user/userController.php";
require_once __DIR__ . "/../app/controllers/web/author/AuthorController.php";
require_once __DIR__ . "/../app/controllers/web/book/BookController.php";
require_once __DIR__ . "/../app/controllers/web/orders/OrderController.php";
require_once __DIR__ . "/../app/middleWares/AuthMiddleWare.php";
require_once __DIR__ . "/../app/middleWares/GuestMiddleWare.php";
require_once __DIR__ . "/../app/middleWares/RegisterMiddleWare.php";

const ADMIN_ONLY ="AuthMiddleWare:admin";
const CUSTOMER_ONLY = "AuthMiddleWare:customer";


Route::get("", HomeController::class, "index");

Route::get("/auth/login", loginController::class, "index", [GuestMiddleWare::class]);
Route::post("/auth/login", loginController::class, "login", [GuestMiddleWare::class]);
Route::get("/auth/logout", loginController::class, "logout", [AuthMiddleWare::class]);

Route::get("/auth/register", registerController::class, "index", [RegisterMiddleWare::class]);
Route::post("/auth/register", registerController::class, "register", [RegisterMiddleWare::class]);


Route::get("/profile", profileController::class, "index", [AuthMiddleWare::class]);

Route::post("/profile/editName", userController::class, "editName", [AuthMiddleWare::class]);
Route::post("/profile/editEmail", userController::class, "editEmail", [AuthMiddleWare::class]);
Route::post("/profile/editPhone", userController::class, "editPhone", [AuthMiddleWare::class]);
Route::post("/profile/editPassword", userController::class, "editPassword", [AuthMiddleWare::class]);
Route::post("/profile/editGender", userController::class, "editGender", [AuthMiddleWare::class]);

Route::post("/profile/banUser", userController::class, "banUser", [ADMIN_ONLY]);
Route::post("/profile/unbanUser", userController::class, "unbanUser", [ADMIN_ONLY]);


Route::post("/profile/addAuthor", AuthorController::class, "addAuthor", [ADMIN_ONLY]);

Route::post("/profile/filterBooks", BookController::class, "filterBooks", [AuthMiddleWare::class]);
Route::post("/profile/addBook", BookController::class, "addBook", [ADMIN_ONLY]);

Route::post("/profile/cancelOrder", OrderController::class, "cancelOrder", [ADMIN_ONLY]);
Route::post("/profile/doneOrder", OrderController::class, "doneOrder", [ADMIN_ONLY]);

Route::post("/profile/addToCart", OrderController::class, "addToCart", [CUSTOMER_ONLY]);
Route::post("/profile/getOrderItems", OrderController::class, "getOrderItems", [CUSTOMER_ONLY]);

Route::get("/profile/totalItemsInCart", OrderController::class, "totalItemsInCart", [CUSTOMER_ONLY]);
Route::post("/profile/updateCartQuantity", OrderController::class, "updateCartQuantity", [CUSTOMER_ONLY]);
Route::post("/profile/removeCartItem", OrderController::class, "removeCartItem", [CUSTOMER_ONLY]);
Route::post("/profile/orderNow", OrderController::class, "orderNow", [CUSTOMER_ONLY]);
Route::post("/profile/orderDetails", OrderController::class, "orderDetails", [AuthMiddleWare::class]);
