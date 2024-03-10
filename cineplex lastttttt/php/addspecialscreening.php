<?php
@include '../Includes/dbh.inc.php';

// Add Film
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_film'])) {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $Trailers = $_POST["Trailer"];
    $imagename = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];
    $folder = "../img/specialscreening/";

    move_uploaded_file($tempname, $folder . $imagename);
    $imagepath = "http://localhost/dila/img/specialscreening/$imagename";

    // Use mysqli_real_escape_string to prevent SQL injection
    $date = mysqli_real_escape_string($conn, $_POST["date"]);
    $time = mysqli_real_escape_string($conn, $_POST["time"]);

    $sql = "INSERT INTO specialscreening(name, price, image, date, time, Trailer) VALUES ('$name', $price, '$imagepath', '$date', '$time', '$Trailers')";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        echo '<script>alert("Movie Inserted Successfully")</script>';
    } else {
        echo '<script>alert("Something went Wrong")</script>';
    }
}

// Edit Film
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['edit_film'])) {
    $edit_id = $_GET['edit_film'];

    // Fetch movie details for editing
    $edit_sql = "SELECT * FROM specialscreening WHERE movieId = '$edit_id'";
    $edit_result = mysqli_query($conn, $edit_sql);
    $edit_row = mysqli_fetch_assoc($edit_result);
}

// Update Film
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_film'])) {
    $movie_id = $_POST['movie_id'];
    $name = $_POST["name"];
    $price = $_POST["price"];
    $Trailers = $_POST["Trailer"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $imagename = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];
    $folder = "../img/specialscreening/";

    move_uploaded_file($tempname, $folder . $imagename);
    $imagepath = "http://localhost/dila/img/specialscreening/$imagename";

    // Update the movie in the database
    $sql = "UPDATE specialscreening SET name = '$name', price = '$price', image = '$imagepath', date = '$date', time = '$time', Trailer = '$Trailers' WHERE movieId = '$movie_id'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        echo '<script>alert("Movie Updated Successfully")</script>';
    } else {
        echo '<script>alert("Something went Wrong")</script>';
    }
}

// Delete Film
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete_film'])) {
    $movie_id = $_GET['delete_film'];

    // Delete the movie from the database
    $sql = "DELETE FROM specialscreening WHERE movieId = '$movie_id'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        echo '<script>alert("Movie Deleted Successfully")</script>';
    } else {
        echo '<script>alert("Something went Wrong")</script>';
    }
}

// Fetch existing movies
$sql = "SELECT * FROM specialscreening";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/addmovie.css">
</head>

<body>
    <div class="container">
        <h2>Add Special Screening Movie</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Movie Name" required>
            <input type="number" name="price" placeholder="Movie Price" required>
            <input type="text" name="Trailer" placeholder="Trailer" required>
            <input type="file" name="image" accept="image/*" required>

            <!-- Dropdown for Date -->
            <label for="date">Select Date:</label>
            <select name="date" id="date" required>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
                <option value="Sunday">Sunday</option>
            </select>

            <!-- Dropdown for Time -->
            <label for="time">Select Time:</label>
            <select name="time" id="time" required>
                <option value="08:00">8:00 AM</option>
                <option value="10:30">10:30 AM</option>
                <option value="13:00">1:00 PM</option>
                <option value="16:00">4:00 PM</option>
                <option value="19:00">7:00 PM</option>
                <option value="22:30">10:30 PM</option>
            </select>

            <input type="submit" name="add_film" value="Add Film">
        </form>

        <?php if (isset($edit_row)) { ?>
            <!-- Edit Movie Form -->
            <h2>Edit Movie</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="movie_id" value="<?php echo $edit_row['movieId']; ?>">
                <input type="text" name="name" value="<?php echo $edit_row['name']; ?>" placeholder="Movie Name" required>
                <input type="number" name="price" value="<?php echo $edit_row['price']; ?>" placeholder="Movie Price" required>
                <input type="text" name="Trailer" value="<?php echo $edit_row['Trailer'];?> " placeholder="Trailer" required>
                <input type="file" name="image" accept="image/*">

                <!-- Dropdown for Date -->
                <label for="date">Select Date:</label>
                <select name="date" id="date" required>
                    <option value="Monday" <?php if ($edit_row['date'] == 'Monday') echo 'selected'; ?>>Monday</option>
                    <option value="Tuesday" <?php if ($edit_row['date'] == 'Tuesday') echo 'selected'; ?>>Tuesday</option>
                    <option value="Wednesday" <?php if ($edit_row['date'] == 'Wednesday') echo 'selected'; ?>>Wednesday</option>
                    <option value="Thursday" <?php if ($edit_row['date'] == 'Thursday') echo 'selected'; ?>>Thursday</option>
                    <option value="Friday" <?php if ($edit_row['date'] == 'Friday') echo 'selected'; ?>>Friday</option>
                    <option value="Saturday" <?php if ($edit_row['date'] == 'Saturday') echo 'selected'; ?>>Saturday</option>
                    <option value="Sunday" <?php if ($edit_row['date'] == 'Sunday') echo 'selected'; ?>>Sunday</option>
                </select>

                <!-- Dropdown for Time -->
                <label for="time">Select Time:</label>
                <select name="time" id="time" required>
                    <option value="08:00" <?php if ($edit_row['time'] == '08:00') echo 'selected'; ?>>8:00 AM</option>
                    <option value="10:30" <?php if ($edit_row['time'] == '10:30') echo 'selected'; ?>>10:30 AM</option>
                    <option value="13:00" <?php if ($edit_row['time'] == '13:00') echo 'selected'; ?>>1:00 PM</option>
                    <option value="16:00" <?php if ($edit_row['time'] == '16:00') echo 'selected'; ?>>4:00 PM</option>
                    <option value="19:00" <?php if ($edit_row['time'] == '19:00') echo 'selected'; ?>>7:00 PM</option>
                    <option value="22:30" <?php if ($edit_row['time'] == '22:30') echo 'selected'; ?>>10:30 PM</option>
                </select>

                <input type="submit" name="update_film" value="Update Film">
            </form>
        <?php } ?>

        <h2>Manage Movies</h2>
        <table>
            <tr>
                <th>Movie Name</th>
                <th>Price</th>
                <th>Trailer</th>
                <th>Date</th>
                <th>Time</th>
                <th>Actions</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "<td>" . $row['Trailer'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" . $row['time'] . "</td>";
                echo "<td>";
                echo "<a href='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "?edit_film=" . $row['movieId'] . "' class='edit-btn'>Edit</a> | ";
                echo "<a href='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "?delete_film=" . $row['movieId'] . "' class='delete-btn'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>

        </table>
    </div>
</body>

</html>