<?php

@include '../Includes/dbh.inc.php';
session_start();

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>New admin and staff</h3>
    <form action="" method="POST">
        <input type="email" name="email">
        <select name="role" id="">
            <option value="admin">Admin</option>
            <option value="staff">Staff</option>
        </select>
        <input type="submit">
    </form>

</body>
</html>

<?php

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $type = "user";
    $newusertype = $_POST['role'];

    $sql = "SELECT * FROM users WHERE Email = '$email' and type = '$type'";
    $result = mysqli_query($conn, $sql);
    

    if (mysqli_num_rows($result)==0) {
        echo '<script>alert("No user Found")</script>';


    }
    else{
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $email = $row['Email'];   
        $sql = "UPDATE users SET type = '$newusertype' WHERE Email = '$email' ";

        if (mysqli_query($conn, $sql)) {
            echo '<script>alert("Acess given")</script>';

        } else {
            echo '<script>alert("No user Found")</script>';

        }
 
    }

  

}
    
    ?>