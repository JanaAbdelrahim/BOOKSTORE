<?php
require_once __DIR__ . "/../../Controller.php";
require_once __DIR__ . "/../../../models/authorModel.php";
class AuthorController extends Controller
{
    public function addAuthor()
    {
        $errors = Request::validate([
            "name" => ["required"],
        ]);

        if (!empty($errors)) {
            Response::json($errors, "Unprocessable Entity", 422);
            return;
        }

        $new = AuthorModel::AddAuthor();
        Response::json($new, "success", 200);
    }
}
