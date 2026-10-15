<?php

/**
 * @var array $data;
 * @var array $Customers;
 */
?>




<div class='row'>

    <?php
    if (empty($data['Customers']['data'])) {
        echo "
                            <div class='empty d-flex flex-column justify-content-center align-items-center py-4'>
                        <div class='icon'>
                            <i class='fa-solid fa-users'></i>
                        </div>
                        <h4>No Customers found</h4>
</div>
        
        ";
    } else {
        $img = asset('images/customer.png');
        for ($i = 0; $i < count($data['Customers']['data']); $i++) {
            $isBannedNow = (int) $data['Customers']['data'][$i]['is_banned'] === 1;
            $uid = (int) $data['Customers']['data'][$i]['id'];
            $isban = "<span class='badge rounded-pill text-bg-danger w-25 banned-badge " . ($isBannedNow ? "" : "d-none") . "'>ban</span>";
            $butt = $isBannedNow
                ? "<button class='btn btn-secondary w-100 ban-btn' data-id='{$uid}' data-banned='1'>Unban</button>"
                : "<button class='btn btn-danger w-100 ban-btn' data-id='{$uid}' data-banned='0'>Ban</button>";
            echo "
    <div class='col-lg-4'>
        <div class='item m-2'>
            <div class='card py-3 px-4 rounded-4 bg-primary-subtle text-primary-emphasis'>
            {$isban}
                <img src='{$img}' class='card-img-top m-auto rounded' alt='...' style='width: 35%;' data-bs-target='#editphoto' data-bs-toggle='model'>
                <div class='card-body'>
                    <h5 class='card-title text-center'>{$data['Customers']['data'][$i]['name']}</h5>
                    <div class='row'>
                        <div class='col-4'>
                            <div class='item'>
                                <h6>Email :</h6>
                            </div>
                        </div>
                        <div class='col-8'>
                            <div class='item'>
                                <p>{$data['Customers']['data'][$i]['email']}</p>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-4'>
                            <div class='item'>
                                <h6>Gender :</h6>
                            </div>
                        </div>
                        <div class='col-8'>
                            <div class='item'>
                                <p>{$data['Customers']['data'][$i]['gender']}</p>
                            </div>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-4'>
                            <div class='item'>
                                <h6>Phone :</h6>
                            </div>
                        </div>
                        <div class='col-8'>
                            <div class='item'>
                                <p>{$data['Customers']['data'][$i]['phone']}</p>
                            </div>
                        </div>
                        <div class='buttons'>
                            {$butt}
                        </div>
                    </div>
                </div>
            </div>
        </div>   
    </div>
    ";
        }
    }




preparePagination($data['Customers'],'customers');

    ?>

</div>