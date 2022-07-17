<?php include "inc/header.php"; ?>
<?php include "lib/User.php"; ?>
<?php 
    Session::checkLogin();
    $user = new User();

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
        $userLogin = $user->userLogin($_POST);
    }
?>
    <div class="content">
        <div class="card my-5">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="card-title">User User Login</h3>
                </div>
                <hr>

                <?php
                    if (isset($userLogin)) {
                        echo $userLogin;
                    }
                ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" name="login" class="btn btn-info text-light">Submit</button>
                </form>
            </div>
        </div>
    </div>
<?php include "inc/footer.php"; ?>