<?php 
    include "lib/User.php";
    include "inc/header.php"; 
        Session::checkSession();
?>

<?php
    if (isset($_GET["id"])) {
        $profileId = (int)$_GET["id"];
        $sesId = Session::get("id");
        if ($profileId != $sesId) {
            header("Location: index.php");
        }
    }
    $user = new User();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
        $updatePass = $user->updatePassData($profileId, $_POST);
    }
?>
    <div class="content">
        <div class="card my-5">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center py-2">
                    <h3 class="card-title">Change Password</h3>
                    <a href="profile.php?id=<?= $profileId ?>" class="btn btn-info link-light">Back</a>
                </div>

                <?php
                    if (isset($updatePass)) {
                        echo $updatePass;
                    }
    
                ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="oldPass" class="form-label">Old Password</label>
                        <input type="oldPass" class="form-control" id="oldPass" name="oldPass">
                    </div>
                    <div class="mb-3">
                        <label for="newPass" class="form-label">New Password</label>
                        <input type="newPass" class="form-control" id="newPass" name="newPass">
                    </div>
                    <button type="submit" name="update" class="btn btn-info text-light">Update Password</button>
                </form>
            </div>
        </div>
    </div>
<?php include "inc/footer.php"; ?>