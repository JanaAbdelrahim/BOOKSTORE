function imagePath(imageName, isUpload = false) {
    return window.location.origin + `/JanaBack/BOOKSTORE/public/assets/images${isUpload ? '/uploads/' : '/'}${imageName}`;
}

function escapeHtml(value) {
    return $('<div>').text(value ?? '').html();
}

function ajaxErrorMessage(response, msg = 'Something went wrong') {
    let data = response.responseJSON?.data;
    if (data && typeof data === 'object') {
        let firstKey = Object.keys(data).find(k => k !== 'success');
        if (firstKey !== undefined) {
            let val = data[firstKey];
            return Array.isArray(val) ? val[0] : String(val);
        }
    }
    return response.responseJSON?.message || msg;
}

$(document).ready(function () {

    let type = window.location.search.replace("?", "").split('-')[0];
    let id = (`#${type}-tab`);

    $(id).get(0)?.click();
});
function showToast(type, msg) {
    Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    }).fire({
        icon: type,
        title: msg
    });
}

/* ===================== Add Author ===================== */

$('#AddAuthorForm').submit(function (e) {
    e.preventDefault();

    let form = this,
        modalEl = $(form).closest('.modal')[0],
        formData = new FormData(form);

    $('#AddAuthorForm p.api-error-banner').addClass('d-none');

    $.ajax({
        url: "profile/addAuthor",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,

        success: function (response) {
            let author = response.data;
            let shortdis = String(author.bio || '').substring(0, 35) + "...";

            form.reset();
            if (modalEl) bootstrap.Modal.getInstance(modalEl)?.hide();

            $(".author.row .col-12.addAuthor").after(`
                <div class="col-lg-4">
                    <div class="item">
                        <div class="card py-3 px-4 rounded-4 bg-primary-subtle text-primary-emphasis">
                            <img src="${imagePath("customer.png")}" class="card-img-top m-auto rounded" alt="..."
                                style="width: 35%;" data-bs-target="#editphoto" data-bs-toggle="modal">
                            <div class="card-body">
                                <h5 class="card-title text-center">${escapeHtml(author.name)}</h5>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="item">
                                            <h6>BIO :</h6>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="item">
                                            <p>${escapeHtml(shortdis)}</p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button
                                            class='btn btn-success w-100 add-book-btn'
                                            data-bs-toggle='modal'
                                            data-bs-target='#AddBook'
                                            data-author-id='${author.id}'
                                            data-author-name='${escapeHtml(author.name)}'
                                        >
                                            AddBook
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `);
        },

        error: function (response) {
            console.log(response);
            let errors = response.responseJSON?.data;

            if (errors && typeof errors === 'object') {
                showErrorAddAuthor(errors);
            } else {
                showToast('error', ajaxErrorMessage(response));
            }
        },
    });
});

function showErrorAddAuthor(errors) {
    for (let error in errors) {
        $(`p.api-error-banner[data-name="${error}"]`)
            .text(Array.isArray(errors[error]) ? errors[error][0] : errors[error])
            .removeClass('d-none');
    }
}

/* ===================== Add Book ===================== */

$(document).on('click', '.add-book-btn', function () {

    let authorId = $(this).data('author-id'),
        authorName = $(this).data('author-name');

    $("#AuthorBookIdHidden").val(authorId);
    $('#AuthorNameBook').val(authorName);
});

$('#AddBookForm').submit(function (e) {
    e.preventDefault();

    let form = this,
        modalEl = $(form).closest('.modal')[0],
        formData = new FormData(form);

    $('#AddBookForm p.api-error-banner').addClass('d-none');

    $.ajax({
        url: "profile/addBook",
        type: "POST",
        data: formData,
        processData: false,  
        contentType: false,  

        success: function (response) {

            let book = response.data;

            form.reset();
            if (modalEl) bootstrap.Modal.getInstance(modalEl)?.hide();

            $("#BooksContainer .empty").remove();

            let shortdescription = String(book.description || '').substring(0, 35) + "...",
                imgpath = book.image
                    ? imagePath(book.image, true)
                    : imagePath('book.png');

            $("#BooksContainer").append(`
                <div class="col-lg-4">
                    <div class="item">
                        <div class="card py-3 px-4 rounded-4 bg-primary-subtle text-primary-emphasis">

                            <img src="${imgpath}" class="card-img-top m-auto rounded" alt="..." style="width: 35%;">

                            <div class="card-body">

                                <div class="row">
                                    <div class="col-4"><h6>title :</h6></div>
                                    <div class="col-8"><p>${escapeHtml(book.title)}</p></div>
                                </div>

                                <div class="row">
                                    <div class="col-4"><h6>Author :</h6></div>
                                    <div class="col-8"><p>${escapeHtml(book.author_name)}</p></div>
                                </div>

                                <div class="row">
                                    <div class="col-4"><h6>description :</h6></div>
                                    <div class="col-8"><p>${escapeHtml(shortdescription)}</p></div>
                                </div>

                                <div class="row">
                                    <div class="col-4"><h6>price :</h6></div>
                                    <div class="col-8"><p>${escapeHtml(book.price)}</p></div>
                                </div>

                                <div class="row">
                                    <div class="col-4"><h6>stock :</h6></div>
                                    <div class="col-8"><p>${escapeHtml(book.stock)}</p></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            `);
        },

        error: function (response) {
            console.log(response);
            let errors = response.responseJSON?.data;

            if (errors && typeof errors === 'object') {
                showErrorAddBook(errors);
            } else {
                showToast('error', ajaxErrorMessage(response));
            }
        }
    });
});


function showErrorAddBook(errors) {
    for (let error in errors) {
        $(`p.api-error-banner[data-name="${error}"]`)
            .text(Array.isArray(errors[error]) ? errors[error][0] : errors[error])
            .removeClass('d-none');
    }
}

/* ===================== Books list / search ===================== */

function displayBooks(books) {

    let booksContainer = $('#BooksContainer');

    // Remove old books
    booksContainer.empty();
    let isCustomer = Number(booksContainer.data('is-customer')) === 1;

    // No results
    if (books.length === 0) {

        booksContainer.html(`

            <div class="empty d-flex flex-column justify-content-center align-items-center py-4">

                <div class="icon">
                    <i class="fa-solid fa-users"></i>
                </div>

                <h4>No Books found</h4>

            </div>

        `);

        return;
    }


    // Display search results
    books.forEach(function (book) {

        let img = book.image
            ? imagePath(book.image, true)
            : imagePath('book.png');


        let shortdescription =
            String(book.description || '').substring(0, 35) + "...";

        let cartHtml = isCustomer ? `
            <div class="input-group mb-3">
                <input type="number" min="1" class="form-control quantity-input"
                    placeholder="quantity" aria-label="quantity" data-id="${book.id}">
                <button class="btn btn-outline-secondary btn-add-to-cart" type="button">Add to cart</button>
            </div>
        ` : '';

        booksContainer.append(`

            <div class="col-lg-4">

                <div class="item m-2">

                    <div class="card py-3 px-4 rounded-4 bg-primary-subtle text-primary-emphasis">

                        <img
                            src="${img}"
                            class="card-img-top m-auto rounded"
                            alt="..."
                            style="width: 35%;"
                        >


                        <div class="card-body">

                            <h5 class="card-title text-center">
                                ${escapeHtml(book.title)}
                            </h5>


                            <div class="row">

                                <div class="col-4">
                                    <h6>Author :</h6>
                                </div>

                                <div class="col-8">
                                    ${escapeHtml(book.author_name)}
                                </div>

                            </div>


                            <div class="row">

                                <div class="col-4">
                                    <h6>Description :</h6>
                                </div>

                                <div class="col-8">
                                    <p>${escapeHtml(shortdescription)}</p>
                                </div>

                            </div>


                            <div class="row">

                                <div class="col-4">
                                    <h6>Price :</h6>
                                </div>

                                <div class="col-8">
                                    <p>${book.price}</p>
                                </div>

                            </div>


                            <div class="row">

                                <div class="col-4">
                                    <h6>Stock :</h6>
                                </div>

                                <div class="col-8">
                                    <p>${book.stock}</p>
                                </div>

                            </div>

                            ${cartHtml}

                        </div>

                    </div>

                </div>

            </div>

        `);

    });

}
$('#SearchBookForm').submit(function (e) {

    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({

        url: "profile/filterBooks",

        type: "POST",

        data: formData,

        processData: false,

        contentType: false,

        success: function (response) {

            let books = response.data.data,
                currentPage = response.data.currentPage,
                total = response.data.total;

            displayBooks(books);
            updateBooksPagination(currentPage, total);

        },

        error: function (response) {

            console.log(response);

        }

    });

});
$('#ResetBookSearch').click(function () {
    $('#SearchBookForm')[0].reset();
    $('#BookSearch').click();
});
$(document).on('click', '#BooksPagination .page-link', function (e) {

    e.preventDefault();

    let page = $(this).attr('href').split('books-page=')[1];

    let formData = new FormData($('#SearchBookForm')[0]);

    formData.append('page', page);

    $.ajax({
        url: "profile/filterBooks",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,

        success: function (response) {

            let books = response.data.data,
                currentPage = response.data.currentPage,
                total = response.data.total;

            displayBooks(books);
            updateBooksPagination(currentPage, total);
        },

        error: function (response) {

            console.log(response);

        }
    });

});
function updateBooksPagination(currentPage, total) {

    let pages = Math.ceil(total / 10);

    let pagination = '';

    let prev = currentPage > 1
        ? currentPage - 1
        : 1;

    let next = currentPage < pages
        ? currentPage + 1
        : pages;

    let isDisabledPrev = currentPage == 1
        ? 'disabled'
        : '';

    let isDisabledNext = currentPage == pages
        ? 'disabled'
        : '';


    pagination += `
        <nav aria-label="Page navigation example ">
            <ul class="pagination m-2">

                <li class="page-item">
                    <a
                        class="page-link ${isDisabledPrev}"
                        href="/profile?books-page=${prev}"
                    >
                        Previous
                    </a>
                </li>
    `;


    for (let i = 1; i <= pages; i++) {

        let isActive = i == currentPage
            ? 'active'
            : '';

        pagination += `
            <li class="page-item">
                <a
                    class="page-link ${isActive}"
                    href="/profile?books-page=${i}"
                >
                    ${i}
                </a>
            </li>
        `;
    }


    pagination += `
                <li class="page-item">
                    <a
                        class="page-link ${isDisabledNext}"
                        href="/profile?books-page=${next}"
                    >
                        Next
                    </a>
                </li>

            </ul>
        </nav>
    `;


    $('#BooksPagination').html(pagination);
}

/* ===================== Orders (admin) ===================== */

$('.cancel-order').click(function () {

    let button = $(this);
    let orderId = button.data('id');

    $.ajax({
        url: 'profile/cancelOrder',
        type: 'POST',
        data: {
            order_id: orderId
        },

        success: function (response) {

            console.log(response);
            if (response.data.success) {

                button.closest('tr').remove();

            } else {
                alert('Failed to cancel order');
            }
        },

        error: function (response) {
            console.log(response.responseText);
            alert(ajaxErrorMessage(response));
        }
    });

});
$('.done-order').click(function () {

    let button = $(this);
    let orderId = button.data('id');

    $.ajax({
        url: 'profile/doneOrder',
        type: 'POST',
        data: {
            order_id: orderId
        },

        success: function (response) {

            console.log(response);
            if (response.data.success) {

                button.closest('tr').remove();

            } else {
                alert('Failed to done order');
            }
        },

        error: function (response) {
            console.log(response.responseText);
            alert(ajaxErrorMessage(response));
        }
    });

});

/* ===================== Cart ===================== */

$(document).on('click', '#BooksContainer .btn-add-to-cart', function () {
    let input = $(this).closest('.input-group').find('.quantity-input');
    let bookId = input.data('id');
    let quantity = parseInt(input.val(), 10);

    if (!quantity || quantity < 1) {
        showToast('warning', 'Enter a valid quantity');
        return;
    }

    $.ajax({
        url: 'profile/addToCart',
        type: 'POST',
        data: { book_id: bookId, quantity: quantity },
        success: function (response) {
            console.log(response);
            showToast('success', 'Added to cart');
            input.val('');
            $('#totalItemsInCart').text(response.data.totalItems);
        },
        error: function (response) {
            console.log(response.responseText);
            showToast('error', ajaxErrorMessage(response));
        }
    });
});
function updateTotalItemsInCart() {

    $.ajax({
        url: 'profile/totalItemsInCart',
        type: 'GET',
        success: function (response) {
            $('#totalItemsInCart').text(response.data.totalItems);
        },
        error: function (response) {
            console.log(response.responseText);
        }
    });
}
function Cart(orderItems, totalPrice = 0) {
    let container = $('#cartItemsContainer');
    container.empty();

    if (orderItems.length === 0) {
        container.html(`<p class="text-center">Your cart is empty</p>`);
        return;
    }

    let html = '<div class="row">';

    orderItems.forEach(function (item) {
        let img = item.image ? imagePath(item.image, true) : imagePath('book.png');

        let shortdis =
            String(item.description || '').substring(0, 35) + "...";

        html += `
    <div class="col-lg-6 cart-item" data-id="${item.book_id}">
        <div class="card py-3 px-4 rounded-4 bg-primary-subtle text-primary-emphasis mb-3">
            <img src="${img}" class="card-img-top m-auto rounded" style="width: 35%;" alt="...">
            <div class="card-body">
                <h5 class="card-title text-center">${escapeHtml(item.title)}</h5>

                <div class="row">
                    <div class="col-4"><h6>Author :</h6></div>
                    <div class="col-8">${escapeHtml(item.author_name)}</div>
                </div>

                <div class="row">
                    <div class="col-4"><h6>Description :</h6></div>
                    <div class="col-8"><p>${escapeHtml(shortdis)}</p></div>
                </div>

                <div class="row">
                    <div class="col-4"><h6>Price :</h6></div>
                    <div class="col-8"><p>${item.price}</p></div>
                </div>

                <div class="row">
                    <div class="col-4"><h6>Subtotal :</h6></div>
                    <div class="col-8"><p>${item.subtotal}</p></div>
                </div>

                <div class="d-flex justify-content-center align-items-center">
                    <button class="btn btn-danger btn-decrease" data-id="${item.book_id}">-</button>
                    <span class="mx-3 item-qty">${item.quantity}</span>
                    <button class="btn btn-success btn-increase" data-id="${item.book_id}">+</button>
                    <button class="btn btn-outline-danger ms-3 btn-remove-item" data-id="${item.book_id}" title="Remove"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>
        </div>
    </div>
`;
    });

    html += `
        </div>
        <h5 class="text-end mb-3">Total : ${Number(totalPrice).toFixed(2)}</h5>
        <button class="btn btn-primary w-100" id="orderNowBtn">Order Now</button>
    `;

    container.html(html);
}
function getOrderItems() {
    $.ajax({
        url: 'profile/getOrderItems',
        type: 'POST',
        success: function (response) {
            console.log(response);
            let orderItems = response.data.orderItems;
            $('#totalItemsInCart').text(response.data.totalItems);
            Cart(orderItems, response.data.totalPrice);
        },
        error: function (response) {
            console.log(response.responseText);
        }
    });

}
$(document).on('click', '#cartItemsContainer .btn-increase, #cartItemsContainer .btn-decrease', function () {
    let bookId = $(this).data('id');
    let change = $(this).hasClass('btn-increase') ? 1 : -1;

    $.ajax({
        url: 'profile/updateCartQuantity',
        type: 'POST',
        data: { book_id: bookId, change: change },
        success: function (response) {
            getOrderItems();
        },
        error: function (response) {
            showToast('error', ajaxErrorMessage(response));
        }
    });
});
$(document).on('click', '#orderNowBtn', function () {
    $.ajax({
        url: 'profile/orderNow',
        type: 'POST',
        success: function (response) {
            if (!response.data.success) {
                showToast('error', 'Order failed');
                return;
            }
            showToast('success', 'Order placed successfully');

            $('#cartItemsContainer').html(`<p class="text-center">Your cart is empty</p>`);

            $('#totalItemsInCart').text(0);

            bootstrap.Modal.getInstance($('#cartModal')[0])?.hide();
        },
        error: function (response) {
            console.log(response.responseText);
            showToast('error', ajaxErrorMessage(response, 'Order failed'));
        }
    });
});

$(document).on('click', '#cartItemsContainer .btn-remove-item', function () {
    $.ajax({
        url: 'profile/removeCartItem',
        type: 'POST',
        data: { book_id: $(this).data('id') },
        success: function () {
            getOrderItems();
        },
        error: function (response) {
            showToast('error', ajaxErrorMessage(response));
        }
    });
});

/* ===================== Ban / Unban ===================== */

$(document).on('click', '.ban-btn', function () {
    let button = $(this);
    let isBanned = Number(button.data('banned')) === 1;

    $.ajax({
        url: isBanned ? 'profile/unbanUser' : 'profile/banUser',
        type: 'POST',
        data: { user_id: button.data('id') },
        success: function () {
            let nowBanned = !isBanned;
            button.data('banned', nowBanned ? 1 : 0)
                .text(nowBanned ? 'Unban' : 'Ban')
                .toggleClass('btn-danger', !nowBanned)
                .toggleClass('btn-secondary', nowBanned);
            let card = button.closest('.card');
            card.find('.banned-badge').toggleClass('d-none', !nowBanned);
            showToast('success', nowBanned ? 'User banned' : 'User unbanned');
        },
        error: function (response) {
            // مثلاً: "The oldest admin can not be banned"
            showToast('error', ajaxErrorMessage(response));
        }
    });
});

/* ===================== Order details ===================== */

$(document).on('click', '.show-order', function (e) {
    e.preventDefault();
    let body = $('#orderDetailsBody').html('<p class="text-center">Loading...</p>');
    bootstrap.Modal.getOrCreateInstance($('#orderDetailsModal')[0]).show();

    $.ajax({
        url: 'profile/orderDetails',
        type: 'POST',
        data: { order_id: $(this).data('id') },
        success: function (response) {
            let order = response.data;
            let rows = order.items.map(function (item) {
                return `<tr>
                    <td>${escapeHtml(item.title)}</td>
                    <td>${escapeHtml(item.author_name)}</td>
                    <td>${item.quantity}</td>
                    <td>${item.unit_price}</td>
                    <td>${item.subtotal}</td>
                </tr>`;
            }).join('');
            let reason = order.cancel_reason ? `<p><strong>Cancel reason:</strong> ${escapeHtml(order.cancel_reason)}</p>` : '';
            body.html(`
                <p><strong>Order #${order.id}</strong> — ${escapeHtml(order.status)} — ${escapeHtml(order.customer_name)}</p>
                ${reason}
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead><tr><th>Book</th><th>Author</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr></thead>
                        <tbody>${rows}</tbody>
                    </table>
                </div>
                <h6 class="text-end">Total : ${order.total_price}</h6>
            `);
        },
        error: function (response) {
            body.html(`<p class="text-danger text-center">${escapeHtml(ajaxErrorMessage(response))}</p>`);
        }
    });
});