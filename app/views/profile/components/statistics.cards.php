<?php

/**
 * @var array $total;
 */
?>

<div class="row">

    <div class="col-lg-3 mb-3 text-primary-emphasis">
        <div class="item">
            <div class="card text-center p-3 rounded-4 border-0">
                <i class="fa-solid fa-book m-auto fs-1"></i>
                <h6 class="my-3">total Books</h6>
                <p class="text-success fw-bolder mb-0">
                    <?= $total['totalBooks']['total']; ?>
                </p>
            </div>
        </div>
    </div>

    <?php if (isAuth('admin')): ?>

        <div class="col-lg-3 mb-3 text-primary-emphasis">
            <div class="item">
                <div class="card text-center p-3 rounded-4 border-0">
                    <i class='m-auto fa-solid fa-user-group fs-1'></i>
                    <h6 class="my-3">total Authors</h6>
                    <p class="text-success fw-bolder mb-0">
                        <?= $total['totalAuthors']['total']; ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 mb-3 text-primary-emphasis">
            <div class="item">
                <div class="card text-center p-3 rounded-4 border-0">
                    <i class='m-auto fa-solid fa-users fs-1'></i>
                    <h6 class="my-3">total Customers</h6>
                    <p class="text-success fw-bolder mb-0">
                        <?= $total['totalCustomers']['total']; ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-3 mb-3 text-primary-emphasis">
            <div class="item">
                <div class="card text-center p-3 rounded-4 border-0">
                    <i class='m-auto fa-solid fa-users-gear fs-1'></i>
                    <h6 class="my-3">total Admins</h6>
                    <p class="text-success fw-bolder mb-0">
                        <?= $total['totalAdmins']['total']; ?>
                    </p>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <div class="col-lg-3 mb-3 text-primary-emphasis">
        <div class="item">
            <div class="card text-center p-3 rounded-4 border-0">
                <i class='m-auto fa-solid fa-user-group fs-1'></i>
                <h6 class="my-3">Total orders [ordered]</h6>
                <p class="text-success fw-bolder mb-0">
                    <?= $total['orders']['ordered']['total']; ?>
                </p>
            </div>
        </div>
    </div>

    <?php if (isAuth('customer')): ?>
        <div class="col-lg-3 mb-3 text-primary-emphasis">
            <div class="item">
                <div class="card text-center p-3 rounded-4 border-0">
                    <i class='m-auto fa-solid fa-book fs-1'></i>
                    <h6 class="my-3">Total Bought Books</h6>
                    <p class="text-success fw-bolder mb-0">
                        <?= $total['totalBoughtBooks'] ?? 0; ?>
                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="col-lg-3 mb-3 text-primary-emphasis">
        <div class="item">
            <div class="card text-center p-3 rounded-4 border-0">
                <i class='m-auto fa-solid fa-book fs-1'></i>
                <h6 class="my-3">Total orders [canceled]</h6>
                <p class="text-success fw-bolder mb-0">
                    <?= $total['orders']['canceled']['total']; ?>
                </p>
            </div>
        </div>
    </div>

    <div class="col-lg-3 mb-3 text-primary-emphasis">
        <div class="item">
            <div class="card text-center p-3 rounded-4 border-0">
                <i class='m-auto fa-solid fa-book fs-1'></i>
                <h6 class="my-3">Total orders [done]</h6>
                <p class="text-success fw-bolder mb-0">
                    <?= $total['orders']['done']['total']; ?>
                </p>
            </div>
        </div>
    </div>

</div>