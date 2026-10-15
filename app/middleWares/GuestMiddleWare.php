<?php
require_once __DIR__ . "/MiddleWare.php";

class GuestMiddleWare implements MiddleWare
{
    public function handle(...$roles): void
    {
        if (isset($_SESSION['user'])) {
            redirect('/profile');
        }
    }
}
