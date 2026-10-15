<?php
require_once __DIR__ . "/../..//core/Database.php";
require_once __DIR__ . "/model.php";

class AuthorModel extends Model

{
    public static function AddAuthor()
    {
        $DB = Database::getConnection();
        $stmt = $DB->prepare("
        INSERT INTO authors
        (name,bio)
        VALUES
        (:name,:bio)
    ");

        $stmt->execute([
            "name" => trim((string) Request::input("name")),
            "bio" => (trim((string) Request::input("bio", '')) === '') ? null : trim((string) Request::input("bio")),
        ]);

        $author_id = $DB->lastInsertId();

        $stmt = $DB->prepare("SELECT * FROM authors WHERE id = :id");
        $stmt->execute(["id" => $author_id]);
        $row = $stmt->fetch();

        return $row;
    }
}
