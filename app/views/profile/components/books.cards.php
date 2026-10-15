<?php

/**
 * @var array $data;
 * @var array $Books;
 */
?>

<div class='row book'>

    <?php
    // Search Form
    echo "
    <form id='SearchBookForm' class='mb-3'>

        <div class='mb-3'>
            <label for='SearchTitle' class='form-label'>Book Title</label>
            <input type='text' name='title' id='SearchTitle' class='form-control' placeholder='Enter book title'>
        </div>

        <div class='mb-3'>
            <label for='SearchAuthor' class='form-label'>Author Name</label>
            <input type='text' name='author_name' id='SearchAuthor' class='form-control' placeholder='Enter author name'>
        </div>

        <div class='row'>
            <div class='col-md-6 mb-3'>
                <label for='MinPrice' class='form-label'>Min Price</label>
                <input type='number' name='min_price' id='MinPrice' class='form-control' min='0' step='0.01'>
            </div>

            <div class='col-md-6 mb-3'>
                <label for='MaxPrice' class='form-label'>Max Price</label>
                <input type='number' name='max_price' id='MaxPrice' class='form-control' min='0' step='0.01'>
            </div>
        </div>

        <div class='mb-3'>
            <label for='StockNumber' class='form-label'>Stock Number</label>
            <input type='number' name='stock_number' id='StockNumber' class='form-control' min='0'>
        </div>

        <div class='mb-3'>
            <label for='Sort' class='form-label'>Sort By Price</label>
            <select name='sort' id='Sort' class='form-select'>
                <option value=''>Default</option>
                <option value='ASC'>Price: Low to High</option>
                <option value='DESC'>Price: High to Low</option>
            </select>
        </div>

        <button type='submit' class='btn btn-primary' id='BookSearch'>Search</button>
        <button type='button' id='ResetBookSearch' class='btn btn-secondary'>Reset</button>

    </form>
    ";
    ?>

    <!-- Books ONLY -->
    <div id='BooksContainer' class='row' data-is-customer='<?= isAuth('customer') ? 1 : 0 ?>'>

        <?php
        if (empty($data['Books']['data'])) {

            echo "
                <div class='empty d-flex flex-column justify-content-center align-items-center py-4'>
                    <div class='icon'>
                        <i class='fa-solid fa-users'></i>
                    </div>
                    <h4>No Books found</h4>
                </div>
            ";
        } else {

            for ($i = 0; $i < count($data['Books']['data']); $i++) {

                $book = $data['Books']['data'][$i];

                $img = !empty($book['image'])
                    ? asset('images/uploads/' . $book['image'])
                    : asset('images/book.png');

                $shortdis = substr($book['description'], 0, 35) . "...";

                echo "
                    <div class='col-lg-4'>
                        <div class='item m-2'>
                            <div class='card py-3 px-4 rounded-4 bg-primary-subtle text-primary-emphasis'>

                                <img
                                    src='{$img}'
                                    class='card-img-top m-auto rounded'
                                    alt='...'
                                    style='width: 35%;'
                                    data-bs-target='#editphoto'
                                    data-bs-toggle='modal'
                                >

                                <div class='card-body'>

                                    <h5 class='card-title text-center'>{$book['title']}</h5>

                                    <div class='row'>
                                        <div class='col-4'><h6>Author :</h6></div>
                                        <div class='col-8'>{$book['author_name']}</div>
                                    </div>

                                    <div class='row'>
                                        <div class='col-4'><h6>Description :</h6></div>
                                        <div class='col-8'><p>{$shortdis}</p></div>
                                    </div>

                                    <div class='row'>
                                        <div class='col-4'><h6>Price :</h6></div>
                                        <div class='col-8'><p>{$book['price']}</p></div>
                                    </div>

                                    <div class='row'>
                                        <div class='col-4'><h6>Stock :</h6></div>
                                        <div class='col-8'><p>{$book['stock']}</p></div>
                                    </div>
                ";

                if (isAuth('customer')) {
                    echo "
                                    <div class='input-group mb-3'>
                                        <input type='number' min='1' class='form-control quantity-input' placeholder='quantity' aria-label='quantity' data-id='{$book['id']}'>
                                        <button class='btn btn-outline-secondary btn-add-to-cart' type='button'>Add to cart</button>
                                    </div>
                    ";
                }

                echo "
                                </div>
                            </div>
                        </div>
                    </div>
                ";
            }
        }
        ?>

    </div>

    <div id="BooksPagination">
        <?php preparePagination($data['Books'], 'books'); ?>
    </div>

</div>