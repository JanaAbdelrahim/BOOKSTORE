<?php

/**
 * @var array $data;
 */

$orders = $data['orders']['canceled']['data'];

if (empty($orders)) {
    echo "
    <div class='empty d-flex flex-column justify-content-center align-items-center py-4'>
        <div class='icon'>
            <i class='fa-solid fa-users'></i>
        </div>
        <h4>No orders found</h4>
    </div>
    ";
} else {
    echo "
    <div class='table-responsive'>
        <table class='table table-info table-striped table-hover'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Total price</th>
                    <th>Details</th>
                    <th>create_at</th>
                </tr>
            </thead>
            <tbody>
    ";

    foreach ($orders as $order) {
        echo "
                <tr>
                    <th>{$order['id']}</th>
                    <td>{$order['customer_name']}</td>
                    <td>{$order['total_price']}</td>
                    <td><a href='#' class='show-order' data-id='{$order['id']}'>Show</a></td>
                    <td>{$order['created_at']}</td>
                </tr>
        ";
    }

    echo "
            </tbody>
        </table>
    </div>
    ";

    preparePagination($data['orders']['canceled'], 'orders_canceled');
}