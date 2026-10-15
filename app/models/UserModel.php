<?php


require_once __DIR__ . "/../..//core/Database.php";
require_once __DIR__ . "/model.php";

class UserModel extends Model


{
    public const PUBLIC_COLUMNS = 'id,name,email,phone,gender,role,is_banned,created_at';

    public function getUsers(): array
    {
        $stmt = $this->DB->query("SELECT " . self::PUBLIC_COLUMNS . " FROM users");
        return $stmt->fetchAll();
    }

    public static function CreateUser(?string $forceRole = null): int
    {
        $DB = Database::getConnection();

        $stmt = $DB->prepare("INSERT INTO users
        (role, name, email, password, phone, gender)
        VALUES
        (:role, :name, :email, :password, :phone, :gender)");

        $stmt->execute([
            'role' => $forceRole ?? Request::input('role'),
            'name' => trim((string) Request::input('name')),
            'email' => trim((string) Request::input('email')),
            'password' => password_hash((string) Request::input('password'), PASSWORD_DEFAULT),
            'phone' => trim((string) Request::input('phone')),
            'gender' => Request::input('gender'),
        ]);

        return (int) $DB->lastInsertId();
    }
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->DB->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public static function findById(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare("SELECT " . self::PUBLIC_COLUMNS . " FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public static function update(string $column, string $value, ?int $userId = null)
    {
        $DB = Database::getConnection();
        $id = $userId ?? (int) auth('id');
        if ($column == 'password') {
            $value = password_hash($value, PASSWORD_DEFAULT);
        }
        $stmt = $DB->prepare("UPDATE users SET {$column} = :value WHERE id = :id");
        $stmt->execute(['value' => $value, 'id' => $id]);
    }

    public static function oldestAdminId(): ?int
    {
        $stmt = Database::getConnection()->query("SELECT id FROM users WHERE role = 'admin' ORDER BY created_at ASC, id ASC LIMIT 1");
        $id = $stmt->fetchColumn();
        return $id === false ? null : (int) $id;
    }


    public static function setBanned(int $targetId, bool $banned): ?string
    {
        $target = self::findById($targetId);
        if ($targetId == auth('id')) {
            return "You can not ban yourself";
        }
        if ($target['role'] == 'admin' && $targetId == self::oldestAdminId()) {
            return "The oldest admin can not be banned";
        }

        $stmt = Database::getConnection()->prepare("UPDATE users SET is_banned = :b WHERE id = :id");
        $stmt->execute(['b' => $banned ? 1 : 0, 'id' => $targetId]);
        return null;
    }
}
