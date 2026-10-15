<?php


require_once __DIR__ . "/../core/Database.php";
class create_orders_table
{
    public static function up()
    {
        Database::getConnection()->exec("CREATE TABLE IF NOT EXISTS orders(
                    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    customer_id BIGINT UNSIGNED NOT NULL,
                    status ENUM('pending', 'ordered', 'canceled', 'done') NOT NULL DEFAULT 'pending',
                    cancel_reason TEXT DEFAULT NULL,
                    total_price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    CONSTRAINT fk_orders_customer FOREIGN KEY (customer_id) REFERENCES users(id) ON DELETE CASCADE
                );");
    }
    public static function down()
    {
        Database::getConnection()->exec("DROP TABLE IF EXISTS orders");
    }
}