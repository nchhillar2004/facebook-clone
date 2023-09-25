<?php
session_start(); // Start a PHP session

    $server = "localhost";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($server, $username, $password);

    if (!$conn){
        die("connection to database failes due to:". mysqli_connect_error());
    }
    echo "Successfully connnected to database";

    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM `facebook`.`users` WHERE `username` = '$username' AND `password` = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Authentication successful, fetch user data
        $row = $result->fetch_assoc();
        $_SESSION['username'] = $row['username']; // Store username in session
        
        header("Location: home.php"); // Redirect to home page
    } else {
        $_SESSION['error_message'] = "Inalid username or password";
        $_SESSION['error_code'] = "401";
        $_SESSION['error_header'] = "HTTP/1.0 401 Unauthorized";
        $_SESSION['error_title'] = "Unauthorized";
        $_SESSION['error_description'] = "You do not have permission to access this page. Please ensure you are logged in with the appropriate credentials";
        // Redirect to the 404 error page
        header("Location: 404.php");
        exit;
    }
    
    $conn->close();
?>