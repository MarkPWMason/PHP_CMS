<?php
function confirmQuery($result)
{
    global $connection;
    if (!$result) {
        die('QUERY FAILED ' . mysqli_error($connection));
    }
}

function insertCategories()
{
    global $connection;
    if (isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];

        if ($cat_title == "" || empty($cat_title)) {
            echo "This field should not be empty";
        } else {
            $query = "INSERT INTO categories (cat_title) VALUES ('{$cat_title}')";

            $create_category_query = mysqli_query($connection, $query);
            if (!$create_category_query) {
                die("QUERY FAILED" . mysqli_error($connection));
            }
        }
    }
}


function findAllCategories()
{
    global $connection;

    $query = "SELECT * FROM categories";
    $selectCategories = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_array($selectCategories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>edit</a></td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>delete</a></td>";
        echo "</tr>";
    }
}

function deleteCategories()
{
    global $connection;

    if (isset($_GET['delete'])) {
        $the_cat_id = $_GET['delete'];

        $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id}";
        mysqli_query($connection, $query);
        header("Location: categories.php");
    }
}

function onlineUsers()
{
    if (isset($_GET['onlineUsers'])) {
        global $connection;

        if (!$connection) {
            session_start();
            include("../includes/db.php");

            $session = session_id(); //gets id of any user
            $time = time();
            $time_out_in_seconds = 05;
            $time_out = $time - $time_out_in_seconds;

            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query); //counts the amount of rows within the query

            if ($count == NULL) {
                mysqli_query($connection, "INSERT INTO users_online (session, time) VALUES ('$session', '$time')");
            } else {
                mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
            }

            $user_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
            echo $count_user =  mysqli_num_rows($user_online_query);
        }
    }
}
onlineUsers();
?>