<?php 
    include "lib/User.php";
    include "inc/header.php"; 
        Session::checkSession();
?>

<?php
    if (isset($_GET["id"])) {
        $profileId = (int)$_GET["id"];
    }
    $user = new User();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
        $updateProfile = $user->updateProfileData($profileId, $_POST);
    }
?>
    <div class="content">
        <div class="card my-5">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center py-2">
                    <h3 class="card-title">User Profile</h3>
                    <a href="index.php" class="btn btn-info link-light">Back</a>
                </div>

                <?php
                    if (isset($updateProfile)) {
                        echo $updateProfile;
                    }

                    $profileData = $user->getProfileDetailsById($profileId);
                    if ($profileData) {
    
                ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="name" class="form-control" id="name" name="name" value="<?=$profileData->name?>">
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="username" class="form-control" id="username" name="username" value="<?=$profileData->username?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?=$profileData->email?>">
                    </div>
                    <!-- <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password">
                    </div> -->
                    <?php
                        $sesId = Session::get("id");
                        if ($profileId == $sesId) {
                    ?>
                    <button type="submit" name="update" class="btn btn-info text-light">Update</button>
                    <a class="btn btn-success" href="passwordcng.php?id=<?=$profileId?>">Change Password</a>
                    <?php } ?>
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
<?php include "inc/footer.php"; ?>