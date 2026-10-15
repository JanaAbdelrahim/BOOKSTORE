<?php
require_once __DIR__ . "/../../Controller.php";
require_once __DIR__ . "/../../../../core/Request.php";
require_once __DIR__ . "/../../../models/UserModel.php";



// "name" => ["required"],
// "email" => ["required","email","unique:users,email"],
// "password" => ["required","min:6"],
// "gender" => ["required","in:male,female"],
// "phone" => ["required","unique:users,phone"]
class UserController extends Controller
{
    public static function editName()
    {
        $errors = Request::validate([

            "name" => ["required"],
        ]);
        if (!empty($errors)) {

            back('editError', $errors['name'][0]);
        }
        UserModel::update('name', trim(Request::input('name')));
        $_SESSION['user']['name'] = trim(Request::input('name'));
        back('success', 'name Updated success');
    }
    public static function editEmail()
    {
        $errors = Request::validate([

            "email" => ["required", "email", "unique:users,email," . auth('id')],
        ]);
        if (!empty($errors)) {

            back('editError', $errors['email'][0]);
        }
        UserModel::update('email', Request::input('email'));
        $_SESSION['user']['email'] = Request::input('email');
        back('success', 'email Updated success');
    }
    public static function editPhone()
    {
        $errors = Request::validate([

            "phone" => ["required", "EGPhone", "unique:users,phone," . auth('id')],
        ]);
        if (!empty($errors)) {

            back('editError', $errors['phone'][0]);
        }
        UserModel::update('phone', Request::input('phone'));
        $_SESSION['user']['phone'] = Request::input('phone');
        back('success', 'phone Updated success');
    }
    public static function editPassword()
    {
        $errors = Request::validate([

            "password" =>  ["required", "min:8"],
        ]);
        if (!empty($errors)) {

            back('editError', $errors['password'][0]);
        }
        UserModel::update('password', Request::input('password'));

        back('success', 'password Updated success');
    }
    public static function editGender()
    {
        $errors = Request::validate([

            "gender" =>  ["required", "in:male,female"],
        ]);
        if (!empty($errors)) {

            back('editError', $errors['gender'][0]);
        }
        UserModel::update('gender', Request::input('gender'));
        $_SESSION['user']['gender'] = Request::input('gender');
        back('success', 'gender Updated success');
    }

    public function banUser()
    {
        $this->changeBan(true);
    }

    public function unbanUser()
    {
        $this->changeBan(false);
    }

    private function changeBan(bool $banned): void
    {
        $errors = Request::validate([
            'user_id' => ['required', 'exists:users,id'],
        ]);
        if (!empty($errors)) {
            Response::json($errors, 'Validation failed', 422);
        }

        $error = UserModel::setBanned(Request::input('user_id'), $banned);
        if ($error) {
            Response::json(['success' => false, 'error' => [$error]], $error, 403);
        }

        Response::json(['success' => true, 'is_banned' => $banned]);
    }
}
