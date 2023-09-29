<?php
session_start();

if (!isset($_SESSION['username'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.html");
    exit;
}

// Connect to the database
$server = "localhost";
$username = "root";
$password = "";
$dbname = "facebook";

$conn = mysqli_connect($server, $username, $password, $dbname);

if (!$conn) {
    die("Connection to database failed due to: " . mysqli_connect_error());
}

// Get the username from the session
$username = $_SESSION['username'];

// Fetch the first_name based on the username
$sql = "SELECT first_name, last_name FROM users WHERE username = '$username'";
$sql_post = "SELECT title, content, timestamp, image  FROM posts WHERE uid = 2";
$result = $conn->query($sql);
$result_post = $conn->query($sql_post);

if ($result_post->num_rows == 1) {
    $row = $result_post->fetch_assoc();
    $title = $row['title'];
    $content = $row['content'];
    $timestamp = $row['timestamp'];
    $image = $row['image'];
} else {
    // Handle the case where the username is not found in the database
    $first_name = "Unknown";
    $last_name = "";
}

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
} else {
    // Handle the case where the username is not found in the database
    $first_name = "Unknown";
    $last_name = "";
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Facebook - Home</title>
    <!-- Add your CSS styles here -->
</head>
<body>
    <div id="header">
        <h1>Facebook</h1>
    </div>
    <div id="content">
        <h2>Welcome, <?php echo $first_name.' '.$last_name; ?>!</h2>
        <div class="post">
            <p>This is a sample post on Facebook.</p>
            <p>Posted by: <?php echo $username;?>
        </p>
        <div>
        </div>
        <a href="post.html"><button>Create a post</button></a>
        </div>
        <!-- More posts and content can be added here -->
    </div>
</body>
</html>
