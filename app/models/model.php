<?php


require_once __DIR__ . "/../../core/Database.php";

class Model
{
    protected PDO $DB;
    public function __construct()
    {
        $this->DB = Database::getConnection();
    }
    public static function buildWhere(array $wheres): array
    {
        $sql = '';
        $params = [];
        $i = 0;

        foreach ($wheres as $where) {
            [$column, $operator, $value] = $where;
            $logic = strtoupper($where[3] ?? 'AND');
            $sql .= ($i === 0 ? 'WHERE ' : " {$logic} ") . "{$column} {$operator} :w{$i}";
            $params["w{$i}"] = $value;
            $i++;
        }

        return [$sql . ' ', $params];
    }

    public static function offset(int $page, int $perPage = 10): int
    {
        return (max(1, $page) - 1) * $perPage;
    }
}
