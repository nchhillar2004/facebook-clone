<?php
session_start();
    $server = "localhost";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($server, $username, $password);

    if (!$conn){
        die("connection to database failes due to:". mysqli_connect_error());
    }

    // Get the username from the session
    $username = $_SESSION['username'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $content = $_POST['content'];
    $image = $_POST['image'];

    $sql = "INSERT INTO `facebook`.`posts` (`username`, `title`, `description`, `content`, `timestamp`, `image`) VALUES ('$username', '$title', '$description', '$content', current_timestamp(), '$image');";

    if (mysqli_query($conn, $sql)) {
        // Signup successful, store user details in session
        $_SESSION['username'] = $username;
        $_SESSION['title'] = $title;
        $_SESSION['description'] = $description;
        $_SESSION['content'] = $content;
        $_SESSION['image'] = $image;
        header("Location: home.php");
    } else {
        $_SESSION['error_message'] =  mysqli_error($conn);
        $_SESSION['error_code'] = "500";
        $_SESSION['error_header'] = "HTTP/1.0 500 Internal server error";
        $_SESSION['error_title'] = "Internal server error";
        $_SESSION['error_description'] = "We're sorry, something went wrong on our end. Please try again later or contact our support team";
        // Redirect to the 404 error page
        header("Location: 404.php");
        exit;
    }

    $conn->close();
?>