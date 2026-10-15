<?php


require_once __DIR__ . "/../core/Database.php";
class create_books_table
{
    public static function up()
    {
        Database::getConnection()->exec("CREATE TABLE IF NOT EXISTS books(
                    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    title VARCHAR(255) NOT NULL,
                    author_id BIGINT UNSIGNED NOT NULL,
                    image VARCHAR(255) NULL DEFAULT NULL,
                    description TEXT NOT NULL,
                    price DECIMAL(10, 2) NOT NULL,
                    stock INT NOT NULL DEFAULT 0,

                    CONSTRAINT chk_books_price CHECK (price >= 0),
                    CONSTRAINT chk_books_stock CHECK (stock >= 0),
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    CONSTRAINT fk_books_author FOREIGN KEY (author_id) REFERENCES authors(id) ON DELETE CASCADE
                );");
    }
    public static function down()
    {
        Database::getConnection()->exec("DROP TABLE IF EXISTS books");
    }
}