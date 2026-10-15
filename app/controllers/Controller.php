<?php
class Controller
{
    protected function view(string $view, $data = array())
    {
        extract($data);
        require __DIR__ . "/../views/{$view}.php";
    }
}
