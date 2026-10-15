<?php

/**
 * @var array $data;
 * @var array $Authors;
 */
?>




<div class='author row'>
    <div class='col-12 addAuthor  d-flex justify-content-center'>
        <button class='btn  btn-success w-75 mb-3' data-bs-toggle="modal" data-bs-target="#AddAuthor">Add Author</button>
    </div>

    <?php
    if (empty($data['Authors']['data'])) {
        echo "
                            <div class='empty d-flex flex-column justify-content-center align-items-center py-4'>
                        <div class='icon'>ْ
                            <i class='fa-solid fa-users'></i>
                        </div>
                        <h4>No Authors found</h4>
</div>";
    } else {
        $img = asset('images/customer.png');
        for ($i = 0; $i < count($data['Authors']['data']); $i++) {
            echo "
    <div class='col-lg-4 '>
        <div class='item'>
            <div class='card py-3 px-4 rounded-4 bg-primary-subtle text-primary-emphasis m-2'>
                <img src={$img} class='card-img-top m-auto rounded' alt='...' style='width: 35%;' data-bs-target='#editphoto' data-bs-toggle='model'>
                <div class='card-body'>
                    <h5 class='card-title text-center'>{$data['Authors']['data'][$i]['name']}</h5>
                    <div class='row'>
                        <div class='col-4'>
                            <div class='item'>
                                <h6>BIO :</h6>
                            </div>
                        </div>
                        <div class='col-8'>
                            <div class='item'>
                                <p>{$data['Authors']['data'][$i]['bio']}</p>
                            </div>
                        </div>
                        <div class='col-12'>
                            <button
                                class='btn btn-success w-100 add-book-btn'
                                data-bs-toggle='modal'
                                data-bs-target='#AddBook'
                                data-author-id='{$data['Authors']['data'][$i]['id']}'
                                data-author-name='{$data['Authors']['data'][$i]['name']}'
                            >
                                AddBook
                            </button>
                        </div>
        
                    </div>
                </div>
            </div>
        </div>   
    </div>
    ";
        }
    }



    preparePagination($data['Authors'], 'authors');
    ?>

</div>