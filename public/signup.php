<?php
session_start();
    $server = "localhost";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($server, $username, $password);

    if (!$conn){
        die("connection to database failes due to:". mysqli_connect_error());
    }

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Check if the username already exists in the database
    $check_username_query = "SELECT * FROM `facebook`.`users` WHERE username = '$username'";
    $check_username_result = mysqli_query($conn, $check_username_query);

    if (mysqli_num_rows($check_username_result) > 0) {
        
        $_SESSION['error_message'] = "Username not available.";
        $_SESSION['error_code'] = "409";
        $_SESSION['error_header'] = "HTTP/1.0 409 Conflict";
        $_SESSION['error_title'] = "Conflict";
        $_SESSION['error_description'] = "Sorry, but we couldn't complete your request due to a conflict with existing data or resources.";
        // Redirect to the 404 error page
        header("Location: 404.php");
        exit;
    } else {
        // Username is unique, proceed with the signup process
        $sql = "INSERT INTO `facebook`.`users` (first_name, last_name, username, password) VALUES ('$first_name', '$last_name', '$username', '$password')";
        
        if (mysqli_query($conn, $sql)) {
            // Signup successful, store user details in session
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['username'] = $username;
            
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
    }

    $conn->close();
?>