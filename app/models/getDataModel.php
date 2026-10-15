<?php


require_once __DIR__ . "/../..//core/Database.php";
require_once __DIR__ . "/model.php";

class GetDataModel extends Model

{
    private static function table(string $name): string
    {

        return $name;
    }

    public static function getTotalOfTable(string $tableName, array $wheres = [], string $cond = "AND")
    {
        $DB = Database::getConnection();
        $result= Model::buildWhere($wheres);
        $whereQuery = $result[0];
        $params = $result[1];
        $tableName = self::table($tableName);
        $stmt = $DB->prepare("SELECT COUNT(id) AS
        total from
        {$tableName}
        {$whereQuery}
        ;");
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result;
    }
    public static function getTotaLBoughtBooksByCustomer()
    {
        $DB = Database::getConnection();
        $customerId = Auth('id');
        $stmt = $DB->prepare("SELECT SUM(orders_items.quantity) AS total
            FROM orders_items
            LEFT JOIN orders
            ON
            orders.id = orders_items.order_id
            WHERE
            orders.customer_id = :customerId
            AND
            orders.status= 'done'

            ;");
        $stmt->execute(['customerId' => $customerId]);
        $result = $stmt->fetch();
        return (int) ($result['total'] ?? 0);
    }

    public static function getDataOfTable(string $tableName, string $data = '*', array $wheres = [], string $cond = "AND", int $page = 1): array
    {
        $DB = Database::getConnection();
        $result = Model::buildWhere($wheres);
        $whereQuery = $result[0];
        $params = $result[1];
        $tableName = self::table($tableName);
        $page = max(1, $page);
        $offset = Model::offset($page, 10);
        $stmt = $DB->prepare("SELECT {$data} From
        {$tableName}
        {$whereQuery}
        ORDER BY id DESC
        LIMIT 10 OFFSET {$offset}
        ;");
        $stmt->execute($params);
        $result = $stmt->fetchAll();

        $stmt = $DB->prepare("SELECT COUNT(*) AS total From
        {$tableName}
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
}
