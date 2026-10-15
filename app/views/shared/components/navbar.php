<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="<?= asset("images/logo.png") ?>" class="img-fluid" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link me-3 active" aria-current="page" href="<?= route("") ?>"><i class="fa-solid fa-house"></i>Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link me-3" href="<?= route("/profile") ?>"><i class="fa-solid fa-user"></i>Profile</a>
                </li>

            </ul>
            <?php
            $user_name = auth('name');
            $route_register = route('/auth/register');
            $route_profile = route('/profile');
            $route_login = route('/auth/login');
            $route_logout = route('/auth/logout');
            if (isAuth("admin")) {
                echo "
            <li class='nav-item dropdown'>
            <a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
            <i class='fa-solid fa-circle-user me-1'></i>{$user_name}
            </a>
            <ul class='dropdown-menu'>
            <li><a class='dropdown-item' href='{$route_register}'>new admin</a></li>
            <li class='nav-item'>
            <a class='nav-link me-3' href='{$route_profile}'>Profile</a>
            </li>
            <li><a class='dropdown-item' href='{$route_logout}'>logout</a></li>
            </ul>
            </li>

            ";
            } else if (isAuth("customer")) {
                echo "
                    <li class='nav-item dropdown'>
            <a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
            <i class='fa-solid fa-circle-user me-1'></i>{$user_name}
            </a>
                
                <ul class='dropdown-menu'>
                <li class='nav-item'>
                    <a class='nav-link me-3' href='{$route_profile}'>Profile</a>
                </li>
                <li><a class='dropdown-item' href='{$route_logout}'>logout</a></li>
                </ul>
                </li>
                ";
            } else {
                echo "
            <li class='nav-item dropdown'>
            <a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
            <i class='fa-solid fa-right-to-bracket me-1'></i>Action
            </a>
            <ul class='dropdown-menu'>
            <li><a class='dropdown-item' href='{$route_register}'>register</a></li>
            <li><a class='dropdown-item' href='{$route_login}'>login</a></li>
            </ul>
            </li>
            ";
            }

            ?>
        </div>

    </div>
</nav>