<?php
require_once __DIR__ . "/../..//core/Database.php";
require_once __DIR__ . "/model.php";

class OrdersModel extends Model
{
    public static function getDataOfOrders(array $wheres = [], string $cond = "AND", int $page = 1): array
    {
        $DB = Database::getConnection();
        [$whereQuery, $params] = Model::buildWhere($wheres);
        $offset = self::offset($page);
        $stmt = $DB->prepare("SELECT orders.*,
        users.name AS customer_name
        From
        orders
        LEFT JOIN users on
        users.id=orders.customer_id
        {$whereQuery}
        ORDER BY orders.id DESC
        LIMIT 10 OFFSET {$offset}
        ;");
        $stmt->execute($params);
        $result = $stmt->fetchAll();

        $stmt = $DB->prepare("SELECT COUNT(*) AS total From
        orders
        {$whereQuery}
        ;");
        $stmt->execute($params);
        $total = $stmt->fetch()['total'];
        return [
            'data' => $result,
            'total' => $total,
            'currentPage' => $page
        ];
    }

    public static function recalculateTotal($orderId)
    {
        $DB = Database::getConnection();
        $stmt = $DB->prepare("SELECT COALESCE(SUM(subtotal), 0) AS total FROM orders_items WHERE order_id = :orderId");
        $stmt->execute(['orderId' => $orderId]);
        $totalPrice = $stmt->fetch()['total'];

        $stmt = $DB->prepare("UPDATE orders SET total_price = :totalPrice WHERE id = :orderId");
        return $stmt->execute(['totalPrice' => $totalPrice, 'orderId' => $orderId]);
    }


    public static function totalItemsInOrder()
    {
        $orderId = self::getPendingOrders();

        if (!$orderId) {
            return 0;
        }

        $DB = Database::getConnection();
        $stmt = $DB->prepare("SELECT COUNT(*) AS total FROM orders_items WHERE order_id = :orderId");
        $stmt->execute(['orderId' => $orderId]);
        return (int) $stmt->fetch()['total'];
    }

    public static function getPendingOrders()
    {
        $DB = Database::getConnection();
        $stmt = $DB->prepare("SELECT id FROM orders WHERE status = 'pending' AND customer_id = :customerId LIMIT 1");
        $stmt->execute(['customerId' => auth('id')]);
        return $stmt->fetchColumn();
    }

    public static function addToCart($bookId, $quantity): ?string
    {
        $DB = Database::getConnection();

        $stmt = $DB->prepare("SELECT title, price, stock FROM books WHERE id = :id");
        $stmt->execute(['id' => $bookId]);
        $book = $stmt->fetch();

        $pendingOrder = self::getPendingOrders();
        if (!$pendingOrder) {
            $stmt = $DB->prepare("INSERT INTO orders (customer_id, status) VALUES (:customerId, 'pending')");
            $stmt->execute(['customerId' => auth('id')]);
            $pendingOrder = $DB->lastInsertId();
        }

        $stmt = $DB->prepare("SELECT id, quantity FROM orders_items WHERE order_id = :o AND book_id = :b LIMIT 1");
        $stmt->execute(['o' => $pendingOrder, 'b' => $bookId]);
        $item = $stmt->fetch();

        $newQuantity = $quantity;
        if ($item) {
            $newQuantity = $item['quantity'] + $quantity;
        }

        if ($newQuantity > $book['stock']) {
            return "Only {$book['stock']} copies of \"{$book['title']}\" are available";
        }

        if ($item) {
            $stmt = $DB->prepare("UPDATE orders_items SET quantity = :q, subtotal = :q2 * unit_price WHERE id = :id");
            $stmt->execute(['q' => $newQuantity, 'q2' => $newQuantity, 'id' => $item['id']]);
        } else {
            $stmt = $DB->prepare("INSERT INTO orders_items (order_id, book_id, quantity, unit_price, subtotal)
                VALUES (:o, :b, :q, :u, :s)");
            $stmt->execute([
                'o' => $pendingOrder,
                'b' => $bookId,
                'q' => $newQuantity,
                'u' => $book['price'],
                's' => $newQuantity * $book['price'],
            ]);
        }

        self::recalculateTotal($pendingOrder);
        return null;
    }

    public static function changeItemQuantity($bookId, $change): ?string
    {
        $DB = Database::getConnection();
        $pendingOrder = self::getPendingOrders();

        $stmt = $DB->prepare("SELECT orders_items.id, orders_items.quantity, books.stock, books.title
            FROM orders_items
            JOIN books ON books.id = orders_items.book_id
            WHERE orders_items.order_id = :o AND orders_items.book_id = :b");
        $stmt->execute(['o' => $pendingOrder, 'b' => $bookId]);
        $item = $stmt->fetch();
        if (!$item) {
            return "This book is not in your cart";
        }

        $newQuantity = $item['quantity'] + $change;

        if ($newQuantity < 1) {
            $stmt = $DB->prepare("DELETE FROM orders_items WHERE id = :id");
            $stmt->execute(['id' => $item['id']]);
        } elseif ($newQuantity > $item['stock']) {
            return "Only {$item['stock']} copies of \"{$item['title']}\" are available";
        } else {
            $stmt = $DB->prepare("UPDATE orders_items SET quantity = :q, subtotal = :q2 * unit_price WHERE id = :id");
            $stmt->execute(['q' => $newQuantity, 'q2' => $newQuantity, 'id' => $item['id']]);
        }

        self::recalculateTotal($pendingOrder);
        return null;
    }

    public static function removeItem($bookId): ?string
    {
        $DB = Database::getConnection();
        $pendingOrder = self::getPendingOrders();

        $stmt = $DB->prepare("DELETE FROM orders_items WHERE order_id = :o AND book_id = :b");
        $stmt->execute(['o' => $pendingOrder, 'b' => $bookId]);
        if ($stmt->rowCount() == 0) {
            return "This book is not in your cart";
        }

        self::recalculateTotal($pendingOrder);
        return null;
    }
    public static function orderNow()
    {
        $DB = Database::getConnection();

        $orderId = self::getPendingOrders();
        if (!$orderId) {
            return "Your cart is empty";
        }

        $stmt = $DB->prepare("SELECT orders_items.id, orders_items.book_id, orders_items.quantity,
                books.title, books.stock, books.price
            FROM orders_items
            JOIN books ON books.id = orders_items.book_id
            WHERE orders_items.order_id = :o");
        $stmt->execute(['o' => $orderId]);
        $items = $stmt->fetchAll();
        if (empty($items)) {
            return "Your cart is empty";
        }

        foreach ($items as $item) {
            if ($item['quantity'] > $item['stock']) {
                return "Only {$item['stock']} copies of \"{$item['title']}\" are available";
            }
        }

        $DB->beginTransaction();

        foreach ($items as $item) {
            $stmt = $DB->prepare("UPDATE books SET stock = stock - :q WHERE id = :id");
            $stmt->execute(['q' => $item['quantity'], 'id' => $item['book_id']]);

            $stmt = $DB->prepare("UPDATE orders_items SET unit_price = :p, subtotal = :q * :p2 WHERE id = :id");
            $stmt->execute(['p' => $item['price'], 'p2' => $item['price'], 'q' => $item['quantity'], 'id' => $item['id']]);
        }

        self::recalculateTotal($orderId);

        $stmt = $DB->prepare("UPDATE orders SET status = 'ordered' WHERE id = :id");
        $stmt->execute(['id' => $orderId]);

        $DB->commit();
        return (int) $orderId;
    }

    public static function cancelOrder($orderId, $reason = null): ?string
    {
        $DB = Database::getConnection();

        $stmt = $DB->prepare("SELECT status FROM orders WHERE id = :id");
        $stmt->execute(['id' => $orderId]);
        if ($stmt->fetchColumn() != 'ordered') {
            return "Only ordered orders can be canceled";
        }

        $stmt = $DB->prepare("SELECT book_id, quantity FROM orders_items WHERE order_id = :id");
        $stmt->execute(['id' => $orderId]);
        $items = $stmt->fetchAll();

        $DB->beginTransaction();

        foreach ($items as $item) {
            $stmt = $DB->prepare("UPDATE books SET stock = stock + :q WHERE id = :b");
            $stmt->execute(['q' => $item['quantity'], 'b' => $item['book_id']]);
        }

        $reason = trim($reason ?? '');
        if ($reason == '') {
            $reason = null;
        }
        $stmt = $DB->prepare("UPDATE orders SET status = 'canceled', cancel_reason = :r WHERE id = :id");
        $stmt->execute(['r' => $reason, 'id' => $orderId]);

        $DB->commit();
        return null;
    }

    // Admin: done
    public static function markDone($orderId): ?string
    {
        $DB = Database::getConnection();

        $stmt = $DB->prepare("SELECT status FROM orders WHERE id = :id");
        $stmt->execute(['id' => $orderId]);
        if ($stmt->fetchColumn() != 'ordered') {
            return "Only ordered orders can be marked as done";
        }

        $stmt = $DB->prepare("UPDATE orders SET status = 'done' WHERE id = :id");
        $stmt->execute(['id' => $orderId]);
        return null;
    }

    public static function getOrderItems($orderId)
    {
        $DB = Database::getConnection();

        $stmt = $DB->prepare("
        SELECT
            orders_items.id AS item_id,
            orders_items.book_id,
            orders_items.quantity,
            orders_items.unit_price,
            orders_items.subtotal,
            books.title,
            books.description,
            books.image,
            books.price,
            books.stock,
            authors.name AS author_name
        FROM orders_items
        JOIN books
            ON orders_items.book_id = books.id
        LEFT JOIN authors
            ON books.author_id = authors.id
        JOIN orders
            ON orders_items.order_id = orders.id
        WHERE orders_items.order_id = :orderId
            AND orders.customer_id = :customerId
            AND orders.status = 'pending'
        ORDER BY orders_items.id
    ");

        $stmt->execute([
            'orderId' => $orderId,
            'customerId' => auth('id')
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getOrderWithItems(int $orderId): ?array
    {
        $DB = Database::getConnection();
        $stmt = $DB->prepare("SELECT orders.*, users.name AS customer_name
            FROM orders LEFT JOIN users ON users.id = orders.customer_id
            WHERE orders.id = :id");
        $stmt->execute(['id' => $orderId]);
        $order = $stmt->fetch();
        if (!$order) {
            return null;
        }
        if (!isAuth('admin') && (int) $order['customer_id'] !== (int) auth('id')) {
            return null;
        }

        $stmt = $DB->prepare("SELECT orders_items.id AS item_id, orders_items.book_id, orders_items.quantity,
                orders_items.unit_price, orders_items.subtotal, books.title, books.image, authors.name AS author_name
            FROM orders_items
            JOIN books ON books.id = orders_items.book_id
            LEFT JOIN authors ON authors.id = books.author_id
            WHERE orders_items.order_id = :id
            ORDER BY orders_items.id");
        $stmt->execute(['id' => $orderId]);
        $order['items'] = $stmt->fetchAll();
        return $order;
    }
}
