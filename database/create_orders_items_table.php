<?php


require_once __DIR__ . "/../core/Database.php";
class create_orders_items_table
{
    public static function up()
    {
        Database::getConnection()->exec("CREATE TABLE IF NOT EXISTS orders_items(
                    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    order_id BIGINT UNSIGNED NOT NULL,
                    book_id BIGINT UNSIGNED NOT NULL,
                    quantity INT UNSIGNED NOT NULL,
                    unit_price DECIMAL(10, 2) NOT NULL,
                    subtotal DECIMAL(10, 2) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

                    CONSTRAINT chk_ordersItems_quantity CHECK (quantity > 0),
                    CONSTRAINT uq_ordersItems_order_book UNIQUE (order_id, book_id),
                    CONSTRAINT fk_ordersItems_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
                    CONSTRAINT fk_ordersItems_book FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
                    );");
    } 
    public static function down()
    {
        Database::getConnection()->exec("DROP TABLE IF EXISTS orders_items");
    }
}