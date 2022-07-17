<?php include "inc/header.php"; ?>
<?php include "lib/User.php"; ?>
<?php 
    $user = new User();

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
        $userReg = $user->userRegistration($_POST);
    }
?>
    <div class="content">
        <div class="card my-5">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="card-title">User Registration</h3>
                </div>
                <hr>
                <?php
                    if (isset($userReg)) {
                        echo $userReg;
                    }
                ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="text" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" name="register" class="btn btn-info text-light">Submit</button>
                </form>
            </div>
        </div>
    </div>
<?php include "inc/footer.php"; ?>