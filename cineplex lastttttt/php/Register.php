<?php
@include '../Includes/dbh.inc.php';
?>



<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Cineplex Cinemas - Buy Movie Tickets Online for the Latest Movies</title>
    <link rel="shortcut icon" href="../img/Logo/logos.png">
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <link rel="stylesheet" href="../css/Register.css" />
</head>

<body>
    <a href="../html/Index.html" class="logo"><img src="../img/Logo/logo.png" alt=""></a>
    <div class="container">
        <h1 class="form-title">Registration</h1>
        <form action="" method="post">
            <div class="main-user-info">
                <div class="user-input-box">
                    <label for="fullName">Full Name</label>
                    <input type="text" id="fullName" name="fullName" placeholder="Enter Full Name" />
                </div>
                <div class="user-input-box">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter Username" />
                </div>
                <div class="user-input-box">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter Email" />
                </div>
                <div class="user-input-box">
                    <label for="phoneNumber">Phone Number</label>
                    <input type="text" id="phoneNumber" name="phoneNumber" placeholder="Enter Phone Number" />
                </div>
                <div class="user-input-box">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter Password" />
                </div>
                <div class="user-input-box">
                    <label for="confirmPassword">Confirm Password</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" />
                </div>
            </div>
            <div class="form-submit-btn">
                <input type="submit" value="Register">
            </div>
        </form>
    </div>
</body>

</html>



<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullNamePattern = '/^[a-zA-Z\ ]+$/';
    $usernamePattern = '/^[a-zA-Z\d\._@-]+$/';
    $phoneNumberPattern = '/^0\d{9}$/';
    $passwordPattern = '/^.{5,}$/';

    if ($_POST["fullName"] == "") {
        echo '<script>alert("Name cant be empty")</script>';
    } 
    elseif (!preg_match($fullNamePattern, $_POST["fullName"])) {
        echo '<script>alert("Full name must contain only Alphabetic characters")</script>';
    } 
    elseif ($_POST["username"] == "") {
        echo '<script>alert("username cant be empty")</script>';
    } 
    elseif (!preg_match($usernamePattern, $_POST["username"])) {
        echo '<script>alert("Invalid Username")</script>';
    }
    elseif ($_POST["email"] == "") {
        echo '<script>alert("email cant be empty")</script>';
    } 
    elseif ($_POST["phoneNumber"] == "") {
        echo '<script>alert("phoneNumber cant be empty")</script>';
    }
    elseif (!preg_match($phoneNumberPattern, $_POST["phoneNumber"])) {
        echo '<script>alert("Invalid Phone Number")</script>';
    } 
    elseif ($_POST["password"] !== $_POST["confirmPassword"]) {
        echo '<script>alert("Passwords doesnt match")</script>';
    }
    elseif (!preg_match($passwordPattern, $_POST["password"])) {
        echo '<script>alert("Password must be at least 5 characters long")</script>';
    }
    else {
        // Check if email or phone number or username is already in use
        $email = $_POST["email"];
        $phoneNumber = $_POST["phoneNumber"];
        $username = $_POST["username"];

        $checkQuery = "SELECT * FROM users WHERE Email='$email' OR phoneNumber='$phoneNumber' OR username='$username'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo '<script>alert("Email, Phone number, or Username is already in use")</script>';
        } 
    else {

        $fullName = $_POST["fullName"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $phoneNumber = $_POST["phoneNumber"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"];
        $type="user";



        $sql = "INSERT INTO users(fullName, username,Email,phoneNumber,Password,type) VALUES ('$fullName','$username','$email',$phoneNumber,'$password','$type')";

        $query = mysqli_query($conn, $sql);

        if ($query) {
            echo '<script>alert("User Inserted Successfully")</script>';
        } else {
            echo '<script>alert("Something went Wrong")</script>';
        }
    }
}
}

?>