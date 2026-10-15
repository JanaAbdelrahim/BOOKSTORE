<?php
class UserController extends Controller {
    public function getAllUsers() {
        $users = [
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john.doe@example.com']
        ];
        return $users;
    }
}