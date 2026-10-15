<?php
require_once __DIR__ . "/../../Controller.php";
require_once __DIR__ . "/../../../models/getDataModel.php";
require_once __DIR__ . "/../../../models/BookModel.php";
require_once __DIR__ . "/../../../models/ordersModel.php";
require_once __DIR__ . "/../../../models/UserModel.php";

class profileController extends Controller
{
    public function index()
    {
        $data = null;
        if (isAuth('admin'))
            $data = $this->getAdminData();
        else if (isAuth('customer')) {
            $data = $this->getCustomerData();
        } else {
            redirect('/auth/login');
        }
        $this->view('/profile/profile', $data);
    }

    private function getAdminData()
    {
        $total = [
            'totalBooks' => getDataModel::getTotalOfTable('books'),
            'totalAuthors' => getDataModel::getTotalOfTable('authors'),
            'totalCustomers' => getDataModel::getTotalOfTable('users', [['role', '=', 'customer']]),
            'totalAdmins' => getDataModel::getTotalOfTable('users', [['role', '=', 'admin']]),
            'orders' => [
                'ordered' => getDataModel::getTotalOfTable("orders", [['status', '=', 'ordered']]),
                'canceled' => getDataModel::getTotalOfTable("orders", [['status', '=', 'canceled']]),
                'done' => getDataModel::getTotalOfTable("orders", [['status', '=', 'done']])
            ]
        ];

        $cols = UserModel::PUBLIC_COLUMNS;
        $admins = getDataModel::getDataOfTable("users", $cols, wheres: [['role', '=', 'admin'], ['id', '!=', auth('id')]], page: Request::page('admins-page'));
        $customers = getDataModel::getDataOfTable("users", $cols, wheres: [['role', '=', 'customer']], page: Request::page('customers-page'));
        $authors = getDataModel::getDataOfTable("authors", page: Request::page('authors-page'));
        $books = BookModel::getDataOfBooks(page: Request::page('books-page'));
        $orders = [
            'ordered' => OrdersModel::getDataOfOrders(wheres: [['status', '=', 'ordered']], page: Request::page('orders_ordered-page')),
            'canceled' => OrdersModel::getDataOfOrders(wheres: [['status', '=', 'canceled']], page: Request::page('orders_canceled-page')),
            'done' => OrdersModel::getDataOfOrders(wheres: [['status', '=', 'done']], page: Request::page('orders_done-page'))
        ];

        $data = [
            'Admins' => $admins,
            'Customers' => $customers,
            'Books' => $books,
            'Authors' => $authors,
            'orders' => $orders,
        ];

        return [
            'total' => $total,
            'data' => $data
        ];
    }
    private function getCustomerData()
    {
        $total = [
            'totalBooks' => getDataModel::getTotalOfTable('books'),
            'totalBoughtBooks' => getDataModel::getTotaLBoughtBooksByCustomer(),
            'orders' => [
                'ordered' => getDataModel::getTotalOfTable("orders", [['customer_id', '=', auth('id')], ['status', '=', 'ordered']]),
                'canceled' => getDataModel::getTotalOfTable("orders", [['customer_id', '=', auth('id')], ['status', '=', 'canceled']]),
                'done' => getDataModel::getTotalOfTable("orders", [['customer_id', '=', auth('id')], ['status', '=', 'done']])
            ]
        ];

        $books = BookModel::getDataOfBooks(page: Request::page('books-page'));
        //$boughtBooks = BookModel::getBoughtBooksByCustomer(page: Request::input('bought-books-page', 1));
        $orders = [
            'ordered' => OrdersModel::getDataOfOrders(wheres: [['customer_id', '=', auth('id')], ['status', '=', 'ordered']], page: Request::page('orders_ordered-page')),
            'canceled' => OrdersModel::getDataOfOrders(wheres: [['customer_id', '=', auth('id')], ['status', '=', 'canceled']], page: Request::page('orders_canceled-page')),
            'done' => OrdersModel::getDataOfOrders(wheres: [['customer_id', '=', auth('id')], ['status', '=', 'done']], page: Request::page('orders_done-page'))
        ];

        $data = [
            'Books' => $books,
            'orders' => $orders,
        ];

        return [
            'total' => $total,
            'data' => $data
        ];
    }
}
