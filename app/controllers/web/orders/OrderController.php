<?php
require_once __DIR__ . "/../../Controller.php";
require_once __DIR__ . "/../../../models/ordersModel.php";

class OrderController extends Controller
{
    public function cancelOrder()
    {
        $errors = Request::validate([
            'order_id' => ['required', 'exists:orders,id'],
        ]);
        if (!empty($errors)) {
            Response::json($errors, 'Validation failed', 422);
        }

        $error = OrdersModel::cancelOrder(Request::input('order_id'), Request::input('cancel_reason'));
        if ($error) {
            Response::json(['success' => false, 'error' => [$error]], $error, 422);
        }

        Response::json(['success' => true]);
    }

    public function doneOrder()
    {
        $errors = Request::validate([
            'order_id' => ['required', 'exists:orders,id'],
        ]);
        if (!empty($errors)) {
            Response::json($errors, 'Validation failed', 422);
        }

        $error = OrdersModel::markDone(Request::input('order_id'));
        if ($error) {
            Response::json(['success' => false, 'error' => [$error]], $error, 422);
        }

        Response::json(['success' => true]);
    }

    public function addToCart()
    {
        $errors = Request::validate([
            'book_id'  => ['required', 'exists:books,id'],
            'quantity' => ['required', 'integer', 'gt:0'],
        ]);
        if (!empty($errors)) {
            Response::json($errors, 'Validation failed', 422);
        }

        $error = OrdersModel::addToCart(Request::input('book_id'), Request::input('quantity'));
        if ($error) {
            Response::json(['success' => false, 'error' => [$error]], $error, 422);
        }

        Response::json([
            'success'    => true,
            'totalItems' => OrdersModel::totalItemsInOrder()
        ]);
    }

    public function getOrderItems()
    {
        $orderId = OrdersModel::getPendingOrders();

        if (!$orderId) {
            Response::json([
                'success' => true,
                'orderItems' => [],
                'totalItems' => 0,
                'totalPrice' => 0,
            ]);
        }

        $orderItems = OrdersModel::getOrderItems($orderId);

        $totalPrice = 0;
        foreach ($orderItems as $item) {
            $totalPrice += $item['subtotal'];
        }

        Response::json([
            'success' => true,
            'orderItems' => $orderItems,
            'totalItems' => count($orderItems),
            'totalPrice' => $totalPrice,
        ]);
    }

    public function totalItemsInCart()
    {
        Response::json(['totalItems' => OrdersModel::totalItemsInOrder()]);
    }

    public function updateCartQuantity()
    {
        $errors = Request::validate([
            'book_id' => ['required', 'exists:books,id'],
            'change'  => ['required', 'in:1,-1'],
        ]);
        if (!empty($errors)) {
            Response::json($errors, 'Validation failed', 422);
        }

        $error = OrdersModel::changeItemQuantity(Request::input('book_id'), Request::input('change'));
        if ($error) {
            Response::json(['success' => false, 'error' => [$error]], $error, 422);
        }

        Response::json(['success' => true, 'totalItems' => OrdersModel::totalItemsInOrder()]);
    }

    public function removeCartItem()
    {
        $errors = Request::validate([
            'book_id' => ['required', 'exists:books,id'],
        ]);
        if (!empty($errors)) {
            Response::json($errors, 'Validation failed', 422);
        }

        $error = OrdersModel::removeItem(Request::input('book_id'));
        if ($error) {
            Response::json(['success' => false, 'error' => [$error]], $error, 422);
        }

        Response::json(['success' => true, 'totalItems' => OrdersModel::totalItemsInOrder()]);
    }

    // POST profile/orderNow
    public function orderNow()
    {
        $result = OrdersModel::orderNow();
        if (is_string($result)) {
            Response::json(['success' => false, 'error' => [$result]], $result, 422);
        }

        Response::json(['success' => true, 'order_id' => $result, 'totalItems' => 0]);
    }

    // POST profile/orderDetails   body: order_id
    public function orderDetails()
    {
        $order = OrdersModel::getOrderWithItems(Request::input('order_id'));
        if (!$order) {
            Response::json(null, 'Order not found', 404);
        }
        Response::json($order);
    }
}
