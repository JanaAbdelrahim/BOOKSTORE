<?php


require_once __DIR__ . "/../core/Database.php";
class create_api_tokens_table
{
    public static function up()
    {
        Database::getConnection()->exec("CREATE TABLE IF NOT EXISTS api_tokens 
        (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id BIGINT UNSIGNED NOT NULL,
            token VARCHAR(255) NOT NULL UNIQUE,
            expires_at TIMESTAMP NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            CONSTRAINT fk_apiTokens_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        );
        ");
    }
    public static function down()
    {
        Database::getConnection()->exec("DROP TABLE IF EXISTS api_tokens");
    }
}