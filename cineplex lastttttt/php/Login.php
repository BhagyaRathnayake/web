<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Cineplex Cinemas - Buy Movie Tickets Online for the Latest Movies</title>
    <link rel="shortcut icon" href="../img/Logo/logos.png">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <link rel='stylesheet' href='../css/Login.css'>
</head>

<body style="background-image: url(../img/background/loginbackground.jpg);background-size: 
cover;background-position: center;background-repeat: no-repeat;">


    <a href="../html/Index.html" class="logo"><img src="../img/Logo/logo.png" alt=""></a>

    <button style="width: 100px; margin-left: 90%;" class="home"><a href="../php/Index.php">Home</a></button>

    <section>
        <div class="form-box">
            <div class="form-value">
                <form action="" method="POST">
                    <h2>Login</h2>
                    <div class="inputbox"> 
                        <ion-icon name="mail-outline"></ion-icon> <input type="email" required name="email">
                        <label>Email</label>
                    </div>
                    <div class="inputbox"> 
                        <ion-icon name="lock-closed-outline"></ion-icon> <input type="password"required name="password"> 
                        <label>Password</label> 
                    </div>
                    <div class="forget"> 
                        <label><input type="checkbox" name="re-check" id="re-check">
                            Remember Me</label> <a href="#">Forgot Password</a> 
                        </div> <input type="submit" value="Login" id="loginButton">
                    <div class="register">
                        <p>Don't have an account? <a href="../php/Register.php">Sign Up</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    
</body>

</html>



<?php
@include '../Includes/dbh.inc.php';
session_start();
   
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // username and password sent from form 
      
    $email = ($_POST['email']);
    $password = ($_POST['password']);
      
    $sql = "SELECT * FROM users WHERE Email = '$email' and Password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        // Handle query errors
        echo "Error: " . mysqli_error($conn);
    } else {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($row) {
            $email = $row['Email'];
            $type = $row['type'];
            $name = $row['fullName'];

            $_SESSION['email'] = $email;
            $_SESSION['type'] = $type;
            $_SESSION['name'] = $name;

            if ($type == "user") {
                header("location: /dila/php/Index.php");
            } 
            elseif($type == "admin") {
                header("location: /dila/html/admin.html");
            }
            elseif($type == "staff") {
                header("location: /dila/html/staff.html");
            }
        } else {
            echo '<script>alert("Your Login Name or Password is invalid")</script>';
        }
    }
}
?>
