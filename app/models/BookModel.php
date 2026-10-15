<?php
require_once __DIR__ . "/../..//core/Database.php";
require_once __DIR__ . "/model.php";

class BookModel extends Model


{
    private const BOOK_SELECT = "SELECT books.*, authors.name AS author_name FROM books LEFT JOIN authors ON authors.id = books.author_id";

    public static function getDataOfBooks(string $data = '*', array $wheres = [], int $page = 1, string $sort = ""): array
    {
        $DB = Database::getConnection();
        [$whereQuery, $params] = Model::buildWhere($wheres);
        $offset = self::offset($page);
        $sort = strtoupper($sort);
        $orderQuery = "ORDER BY books.id DESC";
        if ($sort == 'ASC' || $sort == 'DESC') {
            $orderQuery = "ORDER BY books.price {$sort}, books.id DESC";
        }
        $stmt = $DB->prepare("SELECT books.*,
        authors.name AS author_name
        From
        books
        LEFT JOIN authors on
        authors.id=books.author_id
        {$whereQuery}
        {$orderQuery}
        LIMIT 10 OFFSET {$offset}
        ;");
        $stmt->execute($params);
        $result = $stmt->fetchAll();
        $stmt = $DB->prepare("SELECT COUNT(*) AS total
            FROM
            books
            LEFT JOIN authors ON
            authors.id = books.author_id
            {$whereQuery}

        ;");
        $stmt->execute($params);
        $total = $stmt->fetch()['total'];
        return [
            'data' => $result,
            'total' => $total,
            'currentPage' => $page,
        ];
    }


    public static function filtersFromRequest(bool $withStock = true): array
    {
        $wheres = [];

        if (Request::input('author_name', '') != '') {
            $wheres[] = ['authors.name', 'LIKE', '%' . Request::input('author_name') . '%'];
        }
        $title = Request::input('title', '');
        if ($title != '') {
            $wheres[] = ['books.title', 'LIKE', '%' . $title . '%'];
        }
        if ($withStock && Request::input('stock_number', '') != '' && is_numeric(Request::input('stock_number'))) {
            $wheres[] = ['books.stock', '=', Request::input('stock_number')];
        }
        if (Request::input('min_price', '') != '' && is_numeric(Request::input('min_price'))) {
            $wheres[] = ['books.price', '>=', Request::input('min_price')];
        }
        if (Request::input('max_price', '') != '' && is_numeric(Request::input('max_price'))) {
            $wheres[] = ['books.price', '<=', Request::input('max_price')];
        }

        $sort = strtoupper((string) Request::input('sort', ''));
        return [$wheres, in_array($sort, ['ASC', 'DESC'], true) ? $sort : ''];
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::getConnection()->prepare(self::BOOK_SELECT . " WHERE books.id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public static function addBook(): array
    {
        $DB = Database::getConnection();
        $image = self::uploadImage('image');

        $request = $DB->prepare("INSERT INTO books
        (author_id,title,image,description,price,stock)
        VALUES
            (:author_id,:title,:image,:description,:price,:stock)
        ");
        $request->execute([
            "author_id" => Request::input('authorId'),
            "title" => trim((string) Request::input('title')),
            "image" => $image,
            "description" => Request::input('description'),
            "price" => Request::input('price'),
            "stock" => Request::input('stock')
        ]);

        $bookId = (int) $DB->lastInsertId();
        return self::find($bookId);
    }

    private static function uploadImage(string $fileName): ?string
    {
        if (Request::isFile($fileName)) {
            $file = Request::file($fileName);
            $tmpPath = $file['tmp_name'];


            if (self::checkValidFileImage($tmpPath)) {
                $name = $file['name'];
                $fileOriginalExtension = strtolower(pathinfo($name, PATHINFO_EXTENSION));
        
                $allowedExtension = ['png', 'jpg', 'webp', 'jpeg'];

                if (!in_array($fileOriginalExtension, $allowedExtension)) {
                    Response::json(['image' => ['The Extension is not allowed']], status: 422);
                }

                $newFileName = $name . "_" . time() . "." . $fileOriginalExtension;
                $uploadDir = __DIR__ . "/../../public/assets/images/uploads";

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $uploadPath = $uploadDir . "/" . $newFileName;
                if (!move_uploaded_file($tmpPath, $uploadPath)) {
                    Response::json(['image' => ['Failed To Upload Image please try again']], status: 500);
                }

                return $newFileName;
            }
        }
        return null;
    }

    private static function checkValidFileImage(string $fileTmpName)
    {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $fileTmpName);
        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
        if (!in_array($mime, $allowedMimes)) {
            Response::json(['image' => ["Invalid file content. The file does not match an allowed image type."]], status: 422);
        }

        return true;
    }
}
