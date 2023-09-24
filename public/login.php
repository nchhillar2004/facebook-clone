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
        echo "Error: Invalid username or password";
    }
    
    $conn->close();
?>