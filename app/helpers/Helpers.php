<?php
function  prArrJson(array $arr, bool $die = false)
{
    echo "<pre>";
    print_r(json_encode($arr));
    echo "</pre>";

    if ($die) {
        exit;
    }
}

function asset(string $path)
{
    return BASE_URL . "/assets/" . ltrim($path, "/");
}

function session(string $key, mixed $value = null): mixed
{
    if (func_num_args() === 1) {
        return $_SESSION[$key] ?? null;
    }

    
    $_SESSION[$key] = $value;

    return $_SESSION[$key];
}

function currentUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

function isAuth(?string $role = null): bool
{
    $user = currentUser();
    if ($user === null) {
        return false;
    }

    if ($role === null) {
        return true;
    }

    return ($user["role"] ?? null) === $role;
}


function auth(?string $key = null): mixed
{
    $user = currentUser();
    if ($key === null) {
        return $user;
    }

    return $user[$key] ?? null;
}

function isGuest(): bool
{
    return !isAuth();
}


function redirect(string $path)
{
    $url = BASE_URL . $path;
    header("location:{$url}");
    exit;
}

function route(string $path)
{
    return BASE_URL . $path;
}


function  back(?string $key = null, ?string $msg = "")
{
    $path = $_SERVER['HTTP_REFERER'] ?? (BASE_URL . '/');

    if ($key !== null) $_SESSION[$key] = $msg;

    header("location:{$path}");
    exit;
}

function showError(string $key)
{
    $htmlError = "";
    if (isset($_SESSION['_errors'][$key])) {
        $htmlError = "<p class='api-error-banner mb-0'><i class='fa-solid fa-circle-exclamation'></i> {$_SESSION['_errors'][$key][0]}</p>";
        unset($_SESSION['_errors'][$key]);
    }

    return $htmlError;
}

function showSessionMsg(string $key, bool $isError = true)
{
    $htmlError = "";
    $className = $isError ? 'api-error-banner' : 'alert alert-success';
    if (isset($_SESSION[$key])) {
        $htmlError = "<p class='{$className} text-center mb-3'><i class='fa-solid fa-circle-exclamation'></i> {$_SESSION[$key]}</p>";
        unset($_SESSION[$key]);
    }

    return $htmlError;
}

function old(string $key)
{
    $oldValue = $_SESSION['_old'][$key] ?? '';
    unset($_SESSION['_old'][$key]);
    return $oldValue;
}

function oldSelected(string $key, string $optionValue, bool $isLast = false, bool $isRadio = false)
{
    $isRadioChecked = $isRadio ? 'checked' : 'selected';
    $isSelected = (isset($_SESSION['_old'][$key]) && $_SESSION['_old'][$key] === $optionValue) ? $isRadioChecked : '';
    if ($isLast) unset($_SESSION['_old'][$key]);
    return $isSelected;
}

function isSelected(string $value, string $optionValue)
{
    $isSelected =  $value === $optionValue ? "selected" : '';
    return $isSelected;
}


function showDropDownLi()
{
    $registerLink = route('/auth/register');
    $loginLink = route('/auth/login');
    $logoutLink = route('/auth/logout');
    $profileLink = route('/profile');

    if (isAuth('admin')) {
        $userName = auth('name');
        return "
                <li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                        {$userName}
                    </a>
                    <ul class='dropdown-menu'>
                    <li><a class='dropdown-item' href='{$profileLink}'>profile</a></li>
                    <li><a class='dropdown-item' href='{$registerLink}'>Create New Admin</a></li>
                    <li><a class='dropdown-item' href='{$logoutLink}'>Logout</a></li>
                    </ul>
                </li>
                    ";
    } elseif (isAuth('customer')) {
        $userName = auth('name');
        return "
                <li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                        {$userName}
                    </a>
                    <ul class='dropdown-menu'>
                    <li><a class='dropdown-item' href='{$profileLink}'>profile</a></li>
                    <li><a class='dropdown-item' href='{$logoutLink}'>Logout</a></li>
                    </ul>
                </li>
            ";
    } else {
        return "
                <li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                        Account
                    </a>
                    <ul class='dropdown-menu'>
                        <li><a class='dropdown-item' href='{$loginLink}'>Login</a></li>
                        <li><a class='dropdown-item' href='{$registerLink}'>Register</a></li>
                    </ul>
                </li>
            ";
    }
}


function showSelectedOptions()
{
    if (isAuth('admin')) {
        $selected = oldSelected('role', 'admin', true);
        return "<option value='admin' {$selected} >Admin</option>";
    } else {
        $selected = oldSelected('role', 'customer', true);
        return "<option value='customer' {$selected}>customer</option>";
    }
}

function showUserData(array $users, bool $isAdmin = false)
{
    $registerLink = route("/auth/register");
    if (count($users) <= 0) {
        if ($isAdmin) {
            return "
                    <div class='empty d-flex flex-column justify-content-center align-items-center py-4'>
                        <div class='icon'>
                            <i class='fa-solid fa-users'></i>
                        </div>
                        <h4>No admins found</h4>
                        <p>No admins have been added yet. Start by adding the first admin to the system.</p>
                        <a class='btn btn-success' href='{$registerLink}'>
                            <i class='fa-solid fa-plus'></i>
                            Add Admin
                        </a>
                    </div>
            ";
        }

        return "<div class='empty d-flex flex-column justify-content-center align-items-center py-4'>
                    <div class='icon'>
                        <i class='fa-solid fa-user'></i>
                    </div>
                    <h4>No Customer found</h4>
                </div>";
    }

    $htmlUser = "";
    foreach ($users as $user) {
        $shortEmail = str_replace("ail.com", "...", $user['email']);
        $image = asset($isAdmin ? "images/admin.png" : "images/customer.png");
        $isBanned = $user['is_banned'] ? '<span class="badge text-bg-danger">Banned</span>' : '';
        $isBannedBtn = $user['is_banned'] ? '<button class="btn btn-secondary d-block w-100 border-0">Unban</button>' : '<button class="btn btn-danger d-block w-100 border-0">Ban</button>';
        $htmlUser .= "
            <div class='col-lg-4'>
                <div class='item position-relative cardUser mb-3 py-4 px-2'>
                    {$isBanned}
                    <div class='head text-center mb-4'>
                        <img src='{$image}' class='imgUser d-block m-auto'
                            alt=''>
                        <h4 class='mt-3'>{$user['name']}</h4>
                    </div>
                    <div class='body'>
                        <div class='row'>
                            <div class='col-12'>
                                <div class='item mb-3 d-flex align-items-center flex-wrap'>
                                    <p class='me-2 mb-0 label'>Email :</p>
                                    <p class='mb-0'>{$shortEmail}</p>
                                </div>
                            </div>
                            <div class='col-12'>
                                <div class='item mb-3 d-flex align-items-center'>
                                    <p class='me-2 mb-0 label'>Gender :</p>
                                    <p class='mb-0'>{$user['gender']}</p>
                                </div>
                            </div>
                            <div class='col-12'>
                                <div class='item mb-3 d-flex align-items-center'>
                                    <p class='me-2 mb-0 label'>Phone :</p>
                                    <p class='mb-0'>{$user['phone']}</p>
                                </div>
                            </div>
                            <div class='col-12'>
                                <div class='item d-flex align-items-center'>
                                    {$isBannedBtn}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ";
    }

    return $htmlUser;
}
function showAuthors(array $authors)
{
    if (count($authors) <= 0) {
        return "
                    <div class='empty d-flex flex-column justify-content-center align-items-center py-4'>
                        <div class='icon'>
                            <i class='m-auto fa-solid fa-user-group'></i>
                        </div>
                        <h4>No Authors found</h4>
                    </div>
            ";
    }

    $htmlUser = "";
    foreach ($authors as $author) {
        $image = asset("images/author.png");
        $shortBio = substr($author['bio'], 0, 60) ?? '';
        $htmlUser .= "
            <div class='col-lg-4'>
                <div class='item position-relative cardUser mb-3 py-4 px-2'>
                    <div class='head text-center mb-4'>
                        <img src='{$image}' class='imgUser d-block m-auto'
                            alt=''>
                        <h4 class='mt-3'>{$author['name']}</h4>
                    </div>
                    <div class='body'>
                        <div class='row'>
                            <div class='col-12'>
                                <div class='item d-flex'>
                                    <p class='me-3 mb-0 label'>BIO:</p>
                                    <p class='mb-0'>{$shortBio}...</p>
                                </div>
                            </div>
                        </div>
                </div>
                </div>
            </div>
        ";
    }

    return $htmlUser;
}

function showBooks(array $books)
{
    if (count($books) <= 0) {
        return "
                <div class='empty d-flex flex-column justify-content-center align-items-center py-4'>
                    <div class='icon'>
                        <i class='fa-solid fa-book'></i>
                    </div>
                    <h4>No Bools found</h4>
                </div>
            ";
    }

    $htmlBooks = "";
    foreach ($books as $book) {
        $image = asset("images/book.png");
        $shortDesc = substr($book['description'], 0, 60);
        $htmlBooks .= "
            <div class='col-lg-4'>
                <div class='item position-relative cardUser mb-3 py-4 px-2'>
                    <div class='head text-center mb-4'>
                        <img src='{$image}' class='imgUser d-block m-auto'
                            alt=''>
                        <h6 class='mt-3'>{$book['title']}</h6>
                    </div>
                    <div class='body'>
                        <div class='row'>
                            <div class='col-12'>
                                <div class='item mb-3 d-flex align-items-center'>
                                    <p class='me-2 mb-0 label'>Authors :</p>
                                    <p class='mb-0'>{$book['author_name']}</p>
                                </div>
                            </div>
                            <div class='col-12'>
                                <div class='item mb-3 d-flex align-items-center'>
                                    <p class='me-2 mb-0 label'>Price :</p>
                                    <p class='mb-0'>{$book['price']}</p>
                                </div>
                            </div>
                            <div class='col-12'>
                                <div class='item mb-3 d-flex align-items-center'>
                                    <p class='me-2 mb-0 label'>Stock :</p>
                                    <p class='mb-0'>{$book['stock']}</p>
                                </div>
                            </div>
                            <div class='col-12'>
                                <div class='item d-flex'>
                                    <p class='me-2 mb-0 label'>Description:</p>
                                    <p class='mb-0'>{$shortDesc}...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ";
    }

    return $htmlBooks;
}


function showOrders(array $orders, bool $status)
{
    if (count($orders) <= 0) {
        return "
                <div class='empty d-flex flex-column justify-content-center align-items-center py-4'>
                    <div class='icon'>
                        <i class='fa-solid fa-arrow-up-wide-short'></i>
                    </div>
                    <h4>There are no any order</h4>
                </div>
            ";
    }

    $htmlOrders = "";

    $isOrdered = ($status) ?
        " <td>
            <div class='buttons d-flex justify-content-center align-items-center'>
                <button class='btn btn-danger me-2 text-light'>Cancel</button>
                <button class='btn btn-success' data-bs-toggle='modal'
                    data-bs-target='#exampleModal'>Done</button>
            </div>
        </td>" : '';

    foreach ($orders as $order) {
        $htmlOrders .= "
            <tr>
                <th class='head'>{$order['id']}</th>
                <td>{$order['customer_name']}</td>
                <td>{$order['total_price']}</td>
                <td><a href='#'>Show</a></td>
                <td>{$order['created_at']}</td>
                {$isOrdered}
            </tr>
        ";
    }

    return $htmlOrders;
}



