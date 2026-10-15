<?php
require_once __DIR__ . "/../../Controller.php";
require_once __DIR__ . "/../../../models/BookModel.php";
class BookController extends Controller
{

    public function addBook()
    {
        $errors = Request::validate([
            'authorId' => ['required', "exists:authors,id"],
            'title' => ['required'],
            'description' => ['required'],
            'price' => ['required', 'numeric', 'gte:0'],
            'stock' => ['required', 'integer', 'gte:0'],
        ]);

        if (!empty($errors)) {
            if (isset($errors['authorId'])) {
                $errors['author_id'] = $errors['authorId'];
            }
            Response::json($errors, status: 422);
            return;
        }

        $book = BookModel::addBook();
        Response::json($book, "The Book has been Added successfully", 200);
    }
    public function filterBooks()
    {

        $result = BookModel::filtersFromRequest();
        $wheres = $result[0];
        $sort   = $result[1];
        
        $books = BookModel::getDataOfBooks(
            wheres: $wheres,
            sort: $sort,
            page: Request::page(),
        );

        Response::json($books);
    }
}
