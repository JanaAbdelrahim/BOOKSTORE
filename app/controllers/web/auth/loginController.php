<?php
require_once __DIR__ . "/../../Controller.php";
require_once __DIR__ . "/../../../models/UserModel.php";
class LoginController extends Controller
{
    public function  index()
    {
        $this->view("auth/login");
    }
    public function login()
    {
        $error = Request::validate([
            "email" => ["required", "email"],
            "password" => ["required"]
        ]);
        $email = Request::input("email");
        $password = Request::input("password");
        if (!empty($error)) {
            back();
        } else {
            $userModel = new UserModel();

            $user = $userModel->findByEmail($email);

            if (!$user || !password_verify($password, $user["password"])) {
                back("invalidAccount", "invalid Account");
            }

            if ($user['is_banned']) {
                back("invalidAccount", "This account is banned");
            }

            unset($user['password']);
            session("user", $user);
            redirect("/profile");
        }
    }
    public function logout()
    {
        $_SESSION = [];
        redirect("");
    }
}
