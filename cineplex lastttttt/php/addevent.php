<?php
@include '../Includes/dbh.inc.php';

// Add Event
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_event'])) {
    $eventName = $_POST["eventName"];
    $image = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];
    $folder = "../img/events/";

    move_uploaded_file($tempname, $folder . $image);
    $imagepath = "http://localhost/dila/img/events/$image";

    $sql = "INSERT INTO events(EventName, Image) VALUES ('$eventName', '$imagepath')";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        echo '<script>alert("Event Inserted Successfully")</script>';
    } else {
        echo '<script>alert("Something went Wrong")</script>';
    }
}

// Edit Event
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['edit_event'])) {
    $edit_id = $_GET['edit_event'];

    // Fetch event details for editing
    $edit_sql = "SELECT * FROM events WHERE EventID = '$edit_id'";
    $edit_result = mysqli_query($conn, $edit_sql);
    $edit_row = mysqli_fetch_assoc($edit_result);
}

// Update Event
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_event'])) {
    $eventID = $_POST['eventID'];
    $eventName = $_POST["eventName"];
    $image = $_FILES["image"]["name"];
    $tempname = $_FILES["image"]["tmp_name"];
    $folder = "../img/events/";

    move_uploaded_file($tempname, $folder . $image);
    $imagepath = "http://localhost/dila/img/events/$image";

    // Update the event in the database
    $sql = "UPDATE events SET EventName = '$eventName', Image = '$imagepath' WHERE EventID = '$eventID'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        echo '<script>alert("Event Updated Successfully")</script>';
    } else {
        echo '<script>alert("Something went Wrong")</script>';
    }
}

// Delete Event
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['delete_event'])) {
    $eventID = $_GET['delete_event'];

    // Delete the event from the database
    $sql = "DELETE FROM events WHERE EventID = '$eventID'";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        echo '<script>alert("Event Deleted Successfully")</script>';
    } else {
        echo '<script>alert("Something went Wrong")</script>';
    }
}

// Fetch existing events
$sql = "SELECT * FROM events";
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
        <h2>Add Event</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
            <input type="text" name="eventName" placeholder="Event Name" required>
            <input type="file" name="image" accept="image/*" required>

            <input type="submit" name="add_event" value="Add Event">
        </form>

        <?php if (isset($edit_row)) { ?>
            <!-- Edit Event Form -->
            <h2>Edit Event</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="eventID" value="<?php echo $edit_row['EventID']; ?>">
                <input type="text" name="eventName" value="<?php echo $edit_row['EventName']; ?>" placeholder="Event Name" required>
                <input type="file" name="image" accept="image/*">

                <input type="submit" name="update_event" value="Update Event">
            </form>
        <?php } ?>

        <h2>Manage Events</h2>
        <table>
            <tr>
                <th>Event Name</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['EventName'] . "</td>";
                echo "<td><img src='" . $row['Image'] . "' width='100'></td>";
                echo "<td>";
                echo "<a href='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "?edit_event=" . $row['EventID'] . "' class='edit-btn'>Edit</a> | ";
                echo "<a href='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "?delete_event=" . $row['EventID'] . "' class='delete-btn'>Delete</a>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>
