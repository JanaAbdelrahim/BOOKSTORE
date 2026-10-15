<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>

    <link rel="stylesheet" href="<?= asset('shared/styles/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('shared/styles/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?= asset('shared/styles/global/global.css') ?>">

</head>

<body>



    <?php 
    include __DIR__ . "/../shared/components/navbar.php";

    require_once __DIR__ . "/components/funs.php";
    ?>
    <section id="Profile" class="py-4">

        <div class="container-fluid">

            <div class="row">

                <div class="col-lg-3 mb-4">
                    <div class="item">
                        <div class="card  py-3 rounded-4">
                            <img src="<?= asset("images/admin.png") ?>" class="card-img-top m-auto d-block rounded-c" alt="..." style="width: 35%;" data-bs-target="#Editphoto" data-bs-toggle="model">
                            <div class="card-body">
                                <h5 class="card-title text-center"><i class="fa-solid fa-pen-to-square text-info fs-6" data-bs-toggle="modal" data-bs-target="#EditName"></i><?=auth('name') ?></h5>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="item">
                                            <h6><i class="fa-solid fa-pen-to-square text-info fs-6" data-bs-toggle="modal" data-bs-target="#EditEmail"></i>Email :</h6>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="item">
                                            <p><?=auth('email') ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="item">
                                            <h6><i class="fa-solid fa-pen-to-square text-info fs-6" data-bs-toggle="modal" data-bs-target="#EditGender"></i>Gender :</h6>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="item">
                                            <p><?=auth('gender') ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="item">
                                            <h6><i class="fa-solid fa-pen-to-square text-info fs-6" data-bs-toggle="modal" data-bs-target="#EditPhone"></i>Phone :</h6>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="item">
                                            <p><?=auth('phone'); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <div class="item">
                                            <h6><i class="fa-solid fa-pen-to-square text-info fs-6" data-bs-toggle="modal" data-bs-target="#EditPassword"></i>Password :</h6>
                                        </div>
                                    </div>
                                    <div class="col-7">
                                        <div class="item">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">


                    <div class="item bg-light rounded-4">

                        <div class="links py-4 px-3">

                            <ul class="nav nav-tabs mb-4 position-relative" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="statistics-tab" data-bs-toggle="tab" data-bs-target="#statistics-tab-pane" type="button" role="tab" aria-controls="statistics-tab-pane" aria-selected="true">Statistics</button>
                                </li>
                                <?php if (isAuth('admin')): ?>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="admins-tab" data-bs-toggle="tab" data-bs-target="#admins-tab-pane" type="button" role="tab" aria-controls="admins-tab-pane" aria-selected="false">Admins</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="customers-tab" data-bs-toggle="tab" data-bs-target="#customers-tab-pane" type="button" role="tab" aria-controls="customers-tab-pane" aria-selected="false">Customers</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="authors-tab" data-bs-toggle="tab" data-bs-target="#authors-tab-pane" type="button" role="tab" aria-controls="authors-tab-pane" aria-selected="false">Authors</button>
                                    </li>
                                <?php endif; ?>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="books-tab" data-bs-toggle="tab" data-bs-target="#books-tab-pane" type="button" role="tab" aria-controls="books-tab-pane" aria-selected="false">Books</button>
                                </li>

                                <div class="dropdown">
                                    <button class="btn nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">Orders</button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" id="orders_ordered-tab" data-bs-toggle="tab" data-bs-target="#orders_ordered-tab-pane" type="button" role="tab" aria-controls="orders_ordered-tab-pane" aria-selected="false">Ordered</a></li>
                                        <li><a class="dropdown-item" id="orders_canceled-tab" data-bs-toggle="tab" data-bs-target="#orders_canceled-tab-pane" type="button" role="tab" aria-controls="orders_canceled-tab-pane" aria-selected="false">Canceled</a></li>
                                        <li><a class="dropdown-item" id="orders_done-tab" data-bs-toggle="tab" data-bs-target="#orders_done-tab-pane" type="button" role="tab" aria-controls="orders_done-tab-pane" aria-selected="false">Done</a></li>
                                    </ul>
                                </div>
                                <?php if (isAuth('customer')): ?>
                                    <button type="button" id="cartBtn" class="btn btn-primary position-absolute" style="right: 20px;"
                                        data-bs-toggle="modal" data-bs-target="#cartModal" onclick="getOrderItems()">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                        <span class="position-absolute top-0 start-100 translate-middle badge bg-danger rounded-pill">
                                            <span id="totalItemsInCart"><?= ordersModel::totalItemsInOrder() ?></span>
                                            <span class="visually-hidden">unread messages</span>
                                        </span>
                                    </button>
                                <?php endif; ?>
                            </ul>
                            <div class="tab-content" id="myTabContent">

                                <div class="tab-pane fade show active " id="statistics-tab-pane" role="tabpanel" aria-labelledby="statistics-tab" tabindex="0">
                                    <?php include __DIR__ . "/components/statistics.cards.php"; ?>
                                </div>
                                <?php if (isAuth('admin')): ?>
                                    <div class="tab-pane fade" id="admins-tab-pane" role="tabpanel" aria-labelledby="admins-tab" tabindex="0">
                                        <?php include __DIR__ . "/components/admins.cards.php"; ?>
                                    </div>
                                    <div class="tab-pane fade" id="customers-tab-pane" role="tabpanel" aria-labelledby="customers-tab" tabindex="0">
                                        <?php include __DIR__ . "/components/customers.cards.php"; ?>
                                    </div>
                                    <div class="tab-pane fade" id="authors-tab-pane" role="tabpanel" aria-labelledby="authors-tab" tabindex="0">
                                        <?php include __DIR__ . "/components/authors.cards.php"; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="tab-pane fade" id="books-tab-pane" role="tabpanel" aria-labelledby="books-tab" tabindex="0">
                                    <?php include __DIR__ . "/components/books.cards.php"; ?>
                                </div>
                                <div class="tab-pane fade" id="orders_ordered-tab-pane" role="tabpanel" aria-labelledby="orders_ordered-tab" tabindex="0">
                                    <?php include __DIR__ . "/components/orders_ordered.php"; ?>
                                </div>
                                <div class="tab-pane fade" id="orders_canceled-tab-pane" role="tabpanel" aria-labelledby="orders_canceled-tab" tabindex="0">
                                    <?php include __DIR__ . "/components/orders_canceled.php"; ?>
                                </div>
                                <div class="tab-pane fade" id="orders_done-tab-pane" role="tabpanel" aria-labelledby="orders_done-tab" tabindex="0">
                                    <?php include __DIR__ . "/components/orders_done.php"; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php require_once __DIR__ . "/components/editProfile.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= asset('shared/script/jquery.js') ?>"></script>
    <script src="<?= asset('profile/js/profile.js') ?>"></script>
    <script>
        if (<?= json_encode(isset($_SESSION['editError'])) ?>) {
            showToast('error', <?= json_encode($_SESSION['editError'] ?? '') ?>);
            <?php unset($_SESSION['editError']); ?>
        } else if (<?= json_encode(isset($_SESSION['success'])) ?>) {
            showToast('success', <?= json_encode($_SESSION['success'] ?? '') ?>);
            <?php unset($_SESSION['success']); ?>
        }
    </script>
</body>

</html>