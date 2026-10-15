<?php

require_once __DIR__ . "/../../Controller.php";
require_once __DIR__ . "/../../../models/UserModel.php";
class RegisterController extends Controller
{
    public function index()
    {
        $this->view("auth/register");
    }
    public function register()
    {
        $errors = Request::validate([
            "name" => ["required"],
            "email" => ["required", "email", "unique:users,email"],
            "password" => ["required", "min:8"],
            "gender" => ["required", "in:male,female"],
            "role" => ["required", "in:admin,customer"],
            "phone" => ["required", "EGPhone", "unique:users,phone"]
        ]);

        if (!empty($errors)) {
            back();
        }
        if (Request::input("role") == "admin" && !isAuth('admin')) {
            Response::error('forBidden', 403);
        }

        UserModel::CreateUser();
        $_SESSION['_old'] = [];
        if (isAuth('admin')) {
            redirect('/profile?admins-page=1');
        }
        $_SESSION['successfully'] = 'Account created successfully, you can login now';
        redirect('/auth/login');
    }
}
