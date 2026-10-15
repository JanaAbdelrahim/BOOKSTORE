<?php


/** 
 * @var array $data 
 */
?>


<!--  Edit Modal -->
<div class="modal fade" id="EditName" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="exampleModalLabel">Edit Name</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="FormEditName" method="POST" action="<?= route('/profile/editName') ?>">
                    <div class="mb-4 inputs">
                        <label for="EditNameInput" class="form-label">Name :</label>
                        <input type="text" class="form-control" name="name" id="EditNameInput" value="<?= auth('name') ?>">
                    </div>
                    <div class="buttons  d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="EditEmail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="exampleModalLabel">Edit Email</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="FormEditEmail" method="POST" action="<?= route('/profile/editEmail') ?>">
                    <div class="mb-4 inputs">
                        <label for="EditEmailInput" class="form-label">Email :</label>
                        <input type="text" class="form-control" name="email" id="EditEmailInput" value="<?= auth('email') ?>">
                    </div>
                    <div class="buttons  d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="EditGender" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="exampleModalLabel">Edit Gender</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="FormEditGender" method="POST" action="<?= route('/profile/editGender') ?>">
                    <div class="mb-4 inputs">
                        <label for="EditGenderInput" class="form-label">Gender :</label>
                        <input type="text" class="form-control" name="gender" id="EditGenderInput" value="<?= auth('gender') ?>">
                    </div>
                    <div class="buttons  d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="EditPhone" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="exampleModalLabel">Edit Phone</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="FormEditPhone" method="POST" action="<?= route('/profile/editPhone') ?>">
                    <div class="mb-4 inputs">
                        <label for="EditPhoneInput" class="form-label">Phone :</label>
                        <input type="text" class="form-control" name="phone" id="EditPhoneInput" value="<?= auth('phone') ?>">
                    </div>
                    <div class="buttons  d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="EditPassword" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="exampleModalLabel">Edit Password</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="FormEditPassword" method="POST" action="<?= route('/profile/editPassword') ?>">
                    <div class="mb-4 inputs">
                        <label for="EditPasswordInput" class="form-label">Password :</label>
                        <input type="password" class="form-control" name="password" id="EditPasswordInput" value="" autocomplete="new-password">
                    </div>
                    <div class="buttons  d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="AddAuthor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="exampleModalLabel">Add new author</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="AddAuthorForm">
                    <div class="mb-4">
                        <label for="AuthorName" class="form-label">Name :</label>
                        <input type="text" class="form-control" name="name" id="AuthorName">
                        <p class="api-error-banner d-none" data-name="name"></p>
                    </div>
                    <div class="mb-4">
                        <label for="AuthorBio" class="form-label">Bio :</label>
                        <textarea class="form-control" name="bio" rows="10" id="AuthorBio"></textarea>
                        <p class="api-error-banner d-none" data-name="bio"></p>
                    </div>

                    <div class="buttons  d-flex justify-content-center align-items-center">
                        <button type="button" class=" close btn btn-secondary me-3" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--  Add Book Modal -->
<div class="modal fade" id="AddBook" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="exampleModalLabel">Add New Book</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="AddBookForm" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="AuthorBookId" class="form-label">Author :</label>
                        <input type="hidden" name="authorId" id="AuthorBookIdHidden" value="">
                        <input
                            type="text"
                            id="AuthorNameBook"
                            class="form-control"
                            readonly>
                        <p class="api-error-banner d-none" data-name="author_id"></p>
                    </div>

                    <div class="mb-4">
                        <label for="BookTitle" class="form-label">Title :</label>
                        <input type="text" class="form-control" name="title" id="BookTitle">
                        <p class="api-error-banner d-none" data-name="title"></p>
                    </div>

                    <div class="mb-4">
                        <label for="BookImage" class="form-label">Image :</label>
                        <input type="file" class="form-control" name="image" id="BookImage">
                        <p class="api-error-banner d-none" data-name="image"></p>
                    </div>

                    <div class="mb-4">
                        <label for="BookDescription" class="form-label">Descrition :</label>
                        <textarea class="form-control" name="description" id="BookDescription" rows="10"></textarea>
                        <p class="api-error-banner d-none" data-name="description"></p>
                    </div>

                    <div class="mb-4">
                        <label for="BookPrice" class="form-label">Price :</label>
                        <input type="number" class="form-control" name="price" id="BookPrice">
                        <p class="api-error-banner d-none" data-name="price"></p>
                    </div>

                    <div class="mb-4">
                        <label for="BookStock" class="form-label">Stock :</label>
                        <input type="number" class="form-control" name="stock" id="BookStock">
                        <p class="api-error-banner d-none" data-name="stock"></p>
                    </div>

                    <div class="buttons  d-flex justify-content-center align-items-center">
                        <button type="button " class="btn close btn-secondary me-3" data-bs-dismiss="modal">Close</button>
                        <button class="btn save text-dark bg-body-secondary" type="submit">Add</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<!--  Cart Modal -->
<div class="modal fade" id="cartModal" tabindex="-1"
    aria-labelledby="cartModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h2 class="modal-title" id="cartModalLabel">My Cart</h2>

                <button type="button" class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            <div class="modal-body" id="cartItemsContainer">
                <p class="text-center">Loading cart...</p>
            </div>

        </div>
    </div>
</div>

<!--  showOrders Modal -->
<!-- <div class="modal fade" id="ShowOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title"><?php if (isAuth('admin')) {
                                                echo "Customer Order";
                                            } else {
                                                echo "Your Order";
                                            } ?></h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div> -->

<!--  showOrders Modal -->
<!-- <div class="modal fade" id="CanceledReason" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title">Cancel Reason</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="TextArea" class="form-label">Cancel Reason</label>
                        <textarea class="form-control" id="TextArea" rows="8"></textarea>
                    </div>
                    <button class="btn btn-danger w-100" onclick="cancelOrder()">Cancel Order</button>
                </div>
            </div>
        </div>
    </div> -->

<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-5" id="orderDetailsLabel">Order details</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="orderDetailsBody"></div>
        </div>
    </div>
</div>
