<?php

    $server = "localhost";
    $username = "root";
    $password = "";

    $conn = mysqli_connect($server, $username, $password);

    if (!$conn){
        die("connection to database failes due to:". mysqli_connect_error());
    }
    echo "Successfully connnected to database";

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Check if the username already exists in the database
    $check_username_query = "SELECT * FROM `facebook`.`users` WHERE username = '$username'";
    $check_username_result = mysqli_query($conn, $check_username_query);

    if (mysqli_num_rows($check_username_result) > 0) {
        // Username already exists, display an error message
        echo "Error: Username already exists. Please choose a different username.";
    } else {
        // Username is unique, proceed with the signup process
        $sql = "INSERT INTO `facebook`.`users` (first_name, last_name, username, password) VALUES ('$first_name', '$last_name', '$username', '$password')";
        
        if (mysqli_query($conn, $sql)) {
            // Signup successful, store user details in session
            session_start();
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['username'] = $username;
            
            header("Location: home.php");
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    $conn->close();
?>