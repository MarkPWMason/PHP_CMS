<?php include "includes/admin_header.php" ?>

<?php
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $query = "SELECT * FROM users WHERE username = '{$username}'";
    $select_user_profile = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_array($select_user_profile)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
    }
}
?>

<?php
if (isset($_POST['update_profile'])) {
    global $connection;

    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    $query = "UPDATE users SET user_firstname = '{$user_firstname}', user_lastname = '{$user_lastname}', username = '{$username}', user_email = '{$user_email}', user_password = '{$user_password}' WHERE username = '{$username}'";

    $update_user = mysqli_query($connection, $query);
    confirmQuery($update_user);
}
?>

    <div id="wrapper">
        <!-- Navigation -->
        <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                    <h1 class="page-header">
                            Admin Page
                            <small>Author</small>
                        </h1>


                        <form action="" method="post" enctype="multipart/form-data"> 
    <div class="form-group">
        <label for="title">First Name</label>
        <input type="text" value="<?php echo $user_firstname ?>" class="form-control" name="user_firstname">
    </div>
    <div class="form-group">
        <label for="title">Last Name</label>
        <input type="text" value="<?php echo $user_lastname ?>" class="form-control" name="user_lastname">
    </div>
    <div class="form-group">
        <label for="title">Username</label>
        <input type="text" value="<?php echo $username ?>" class="form-control" name="username">
    </div>
    <div class="form-group">
        <label for="title">Email</label>
        <input type="email" value="<?php echo $user_email ?>" class="form-control" name="user_email" >
    </div>
    <div class="form-group">
        <label for="title">Password</label>
        <input autocomplete="off" type="password" class="form-control" name="user_password" >
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_profile" value="Update Profile">
    </div>
</form>
                       
                        
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

   <?php include "includes/admin_footer.php" ?>
