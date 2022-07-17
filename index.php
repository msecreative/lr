<?php 
    include "lib/User.php"; 
    include "inc/header.php";
    Session::checkSession();
?>
    <div class="content">
        <?php
            $loginmsg = Session::get("loginmsg");
            if (isset($loginmsg)) {
                echo $loginmsg;
            }
            Session::set("loginmsg", NULL);
        ?>
        <div class="card my-5">
            <div class="card-body">
                <div class="d-flex">
                    <h3 class="card-title">User List</h3>
                    <span class="ms-auto text-capitalize"><strong>Welcome!</strong>
                    <?php
                        $name = Session::get("name");
                        if (isset($name)) {
                            echo $name;
                        }
                    ?>
                    </span>
                </div>
                <table class="table table-striped table-info table-hover table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>User Name</th>
                        <th>Email Address</th>
                        <th>Action</th>
                    </tr>
                    <?php 
                        $user = new User();
                        $userData = $user->getUserData();
                        if ($userData) {
                            foreach ($userData as $data){
                    ?>
                    <tr>
                        <td><?=$data->id ?></td>
                        <td><?=$data->name ?></td>
                        <td><?=$data->username ?></td>
                        <td><?=$data->email ?></td>
                        <td>
                            <a href="profile.php?id=<?=$data->id?>">View</a>
                        </td>
                    </tr>
                    <?php  
                            }
                        }else{
                        ?>
                        <tr><td colspan="5"><h2>No Data Found!!!</h2></td></tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
<?php include "inc/footer.php"; ?>