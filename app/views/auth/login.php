<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?= asset('shared/styles/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?= asset('shared/styles/global/global.css') ?>">
    <link rel="stylesheet" href="<?= asset('auth/login/css/scss/login.css') ?>">
</head>

<body>
    <?php require_once __DIR__ . "/../shared/components/navbar.php" ?>

    <div id="Login" class="py-5">
        <div class="content">
            <form action="<?= route('/auth/login') ?>" method="POST">
                <h2 class="text-center mb-4">Welcome back</h2>
                <?= showSessionMsg('successfully') ?>
                <div class="mb-4">
                    <label for="Email" class="form-label">Email :</label>
                    <input type="text" class="form-control" name="email" id="Email" placeholder="name@example.com" value="<?= old('email') ?>">
                    <?= showError('email') ?>
                </div>
                <div class="mb-4">
                    <label for="Password" class="form-label">Password :</label>
                    <input type="password" class="form-control" name="password" id="Password" placeholder="••••••••">
                    <?= showError('password') ?>
                </div>
                <?= showSessionMsg('invalidAccount') ?>
                <button class="btn w-100 mb-4">Login</button>
            </form>
            <p class="text-center mb-0">Don't have an account?<a class="ms-2" href="<?= route("/auth/register") ?>">Register</a></p>
        </div>
    </div>

    <script src="<?= asset('shared/script/bootstrap.js') ?>"></script>
    <script src="<?= asset('shared/script/jquery.js') ?>"></script>
</body>

</html>