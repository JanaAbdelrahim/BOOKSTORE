<?php
require_once __DIR__ . "/MiddleWare.php";
require_once __DIR__ . "/../../core/Database.php";

class AuthMiddleWare implements MiddleWare

{
    public function handle(string ...$roles): void
    {
        // Authentication
        if (!isset($_SESSION['user'])) {

            Response::json(null, "Unauthenticated", 401);

            redirect('/auth/login');
        }


        $stmt = Database::getConnection()->prepare("SELECT is_banned, role FROM users WHERE id = :id");
        $stmt->execute(['id' => $_SESSION['user']['id']]);
        $fresh = $stmt->fetch();
        if (!$fresh || $fresh['is_banned']) {
            $_SESSION['user'] = null;
            unset($_SESSION['user']);

            redirect('/auth/login');
        }
        $_SESSION['user']['role'] = $fresh['role'];

        if (empty($roles)) {
            return;
        }

        $currentRuleAuth = $_SESSION['user']['role'];
        if (!in_array($currentRuleAuth, $roles)) {
            Response::error("Forbidden", 403);
        }
    }
}
