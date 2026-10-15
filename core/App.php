<?php
session_start();
require_once __DIR__ . "/Route.php";
class App
{
    public static function run()
    {
    //session_unset();

        require_once __DIR__ . "/../routes/web.php";
        require_once __DIR__ . "/Route.php";
        require_once __DIR__ . "/../app/helpers/Helpers.php";
        require_once __DIR__ . "/Response.php";
        require_once __DIR__ . "/Request.php";
        require_once __DIR__ . "/Validation.php";

        Route::dispatch();
    }
}
