<?php
if (isset($_GET['p_id'])) {
    $p_id = $_GET['p_id'];

}

$query = "SELECT * FROM posts WHERE post_id = $p_id";
$selectPostsById = mysqli_query($connection, $query);

while ($row = mysqli_fetch_array($selectPostsById)) {
    $post_id = $row['post_id'];
    $post_user = $row['post_user'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];
    $post_content = $row['post_content'];
}
if (isset($_POST['update_post'])) {
    $post_user = $_POST['post_user'];
    $post_title = $_POST['title'];
    $post_category_id = $_POST['post_category'];
    $post_status = $_POST['post_status'];
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];
    $post_content = $_POST['post_content'];
    $post_tags = $_POST['post_tags'];

    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "UPDATE posts SET post_title = '{$post_title}', post_category_id = {$post_category_id}, post_date = now(), post_user = '{$post_user}', post_status = '{$post_status}', post_tags = '{$post_tags}', post_content = '{$post_content}', post_image = '{$post_image}' WHERE post_id = {$p_id}";

    if (empty($post_image)) {
        $query_for_image = "SELECT * FROM posts WHERE post_id = $p_id";
        $select_image = mysqli_query($connection, $query_for_image);
        while ($row = mysqli_fetch_array($select_image)) {
            $post_image = $row['post_image'];
        }
    }

    $updatePost = mysqli_query($connection, $query);

    if (!$updatePost) {
        die('QUERY FAILED ' . mysqli_error($connection));
    }

    echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$post_id}'>View Post</a> or <a href='posts.php'>Edit More Posts</a></p>";
}
?>

<form action="" method="post" enctype="multipart/form-data"> 
    <div class="form-group">
        <label for="title">Post Title</label>
        <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="title">
    </div>
    <div class="form-group">
    <label for="category">Category</label>
        <select name="post_category" id="">
            <?php
            $query = "SELECT * FROM categories";
            $selectCategories = mysqli_query($connection, $query);

            confirmQuery($selectCategories);

            while ($row = mysqli_fetch_array($selectCategories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];
                echo "<option value='{$cat_id}'>{$cat_title}</option>";
            }
            ?>
            
        </select>
    </div>
    <div class="form-group">
        <label for="users">Users</label>
    <select name="post_user" id="">
            <?php
            $query = "SELECT * FROM users";
            $select_users = mysqli_query($connection, $query);

            confirmQuery($select_users);

            while ($row = mysqli_fetch_array($select_users)) {
                $user_id = $row['user_id'];
                $username = $row['username'];
                echo "<option value='{$username}'>{$post_user}</option>";
            }
            ?>
            
        </select>
    </div>
    <div class="form-group">
        <select name="post_status" id="">
            <option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>
            
            <?php
            if ($post_status == 'published') {
                echo "<option value='draft'> draft </option>";
            } else {
                echo "<option value='published'> publish </option>";
            }
            ?>

        </select>
    </div>
    <div class="form-group">
        <img width="100" src="../images/<?php echo $post_image ?>" alt="Post Image" >
        <input type="file" name="image">
    </div>
    <div class="form-group">
        <label for="title">Post Tags</label>
        <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="title">Post Content</label>
        <textarea class="form-control" name="post_content" id="" col="30" rows="10" name="post_content"><?php echo $post_content; ?></textarea>
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="update_post" value="publish">
    </div>
</form>