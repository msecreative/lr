<?php
    $filepath = realpath(dirname(__FILE__));
    include_once $filepath.'/../lib/Session.php';
    Session::init();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Register System || OOP-PDO</title>
    <link rel="stylesheet" href="inc/css/bootstrap.min.css">
    <style>
        .content {
            min-height: 70vh;
        }
    </style>
</head>
<?php
    if (isset($_GET['action']) && $_GET['action'] == 'logout') {
       Session::destroy();
    }
?>
<body class="bg-secondary">
        <div class="page-wrapper">
            <div class="container">
                <nav class="navbar navbar-expand-lg bg-info mt-2">
                    <div class="container-fluid">
                        <a class="navbar-brand link-light" href="index.php">Login Register System || OOP-PDO</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <?php
                                $id = Session::get("id");
                                $userlogin = Session::get("login");
                                if ($userlogin == true) { ?>
                            <li class="nav-item">
                            <a class="nav-link link-light" href="profile.php?id=<?= $id ?>">Profile</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link link-light" href="?action=logout">Logout</a>
                            </li>
                            <?php        
                                }else{
                            ?>
                            <li class="nav-item">
                            <a class="nav-link link-light" href="register.php">Register</a>
                            </li>
                            <li class="nav-item">
                            <a class="nav-link link-light" href="login.php">Login</a>
                            </li>
                            <?php } ?>
                        </ul>
                        </div>
                    </div>
                </nav>
