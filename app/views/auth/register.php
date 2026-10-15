<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="<?= asset('shared/styles/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?= asset('shared/styles/global/global.css') ?>">
    <link rel="stylesheet" href="<?= asset('auth/register/css/register.css') ?>">

</head>

<body style="background-color: antiquewhite;">
<?php 




?>
    <?php require_once __DIR__ . "/../shared/components/navbar.php" ?>
    <div id="Register" class="py-5">
        <div class="content">
            <form action="<?= route('/auth/register') ?>" method="POST" autocomplete="off">
                <h2 class="text-center mb-4">Create an account</h2>
                <div class="mb-4">
                    <label for="Role" class="form-label">Role :</label>
                    <select name="role" id="Role" class="form-control">
                        <option value="" <?= oldSelected('role', "",true); ?> hidden></option>
                        <?php 
                        if(isAuth('admin')) {
                            $selected=oldSelected('role', "admin",true); 
                            echo "<option value='admin' {$selected}>admin</option>";
                        }
                        ?>
                        <option value="customer" <?= oldSelected('role', "customer",true); ?>>customer</option>

                    </select>
                    <?= showError('role') ?>
                </div>
                <div class="mb-4">
                    <label for="Name" class="form-label">Name :</label>
                    <input type="text" class="form-control"  name="name" id="Name" placeholder="e.g. Ahmed mohamed " value="<?= old('name'); ?>">
                    <?= showError('name') ?>
                </div>
                <div class="mb-4">
                    <label for="Email" class="form-label">Email :</label>
                    <input type="text" class="form-control" name="email" id="Email" placeholder="name@example.com" autocomplete="off" value="<?= old('email'); ?>">
                    <?= showError('email') ?>
                </div>
                <div class="mb-4">
                    <label for="Password" class="form-label">Password :</label>
                    <input type="password" class="form-control"  name="password" id="Password" placeholder="••••••••" autocomplete="off">
                    <?= showError('password') ?>    
                </div>
                <div class="mb-4">
                    <label for="Phone" class="form-label">Phone :</label>
                    <input type="text" class="form-control" name="phone" id="Phone" placeholder="EGPhone" value="<?= old('phone'); ?>">
                    <?= showError('phone') ?>
                </div>

                <div class="mb-4">
                    <label class="form-label me-3 mb-0">Gender :</label>
                    <label class="me-2"><input type="radio" name="gender" value="male" <?= oldSelected('gender', 'male', true) ?>> Male</label>
                    <label><input type="radio" value="female" name="gender" <?= oldSelected('gender', 'female', true) ?>> Female</label>
                    <?= showError('gender') ?>
                </div>

                <button class="btn w-100 mb-4" >Register</button>
            </form>
            <p class="text-center mb-0">Don't have an account?<a class="ms-2" href="<?= route("/auth/login") ?>">Login</a></p>
        </div>

    </div>

    <script src="<?= asset('shared/script/bootstrap.js') ?>"></script>
    <script src="<?= asset('shared/script/jquery.js') ?>"></script>
</body>

</html>