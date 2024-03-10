<?php
include 'connection.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

// Fetch booked seats from the database
$bookedSeats = array();
$selectQuery = "SELECT seatNumber FROM book WHERE date = ? AND time = ?";
$stmt = mysqli_prepare($conn, $selectQuery);
$date = date('Y-m-d');
$time = "9:45AM"; // Assuming the default time is 9:45AM
mysqli_stmt_bind_param($stmt, "ss", $date, $time);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
while ($row = mysqli_fetch_assoc($result)) {
    $seats = explode(",", $row['seatNumber']);
    foreach ($seats as $seat) {
        $bookedSeats[] = trim($seat);
    }
}

if (isset($_POST['submit'])) {
    if (isset($_POST['seatNumber']) && !empty($_POST['seatNumber'])) {
        $selectedSeats = $_POST['seatNumber'];
        $seatString = implode(",", $selectedSeats);
        $selectedTime = $_POST['time'];
        $movieName = "moviename";
        $date = $_POST['date'];

        $insertQuery = "INSERT INTO book (seatNumber, time, moviename, date) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($stmt, "ssss", $seatString, $selectedTime, $movieName, $date);

        if (mysqli_stmt_execute($stmt)) {
            // Booking successful
            // You can redirect or display a success message here
        } else {
            echo "Error booking seats: " . mysqli_error($conn);
        }
    } else {
        echo "No seats selected!";
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ticket Booking</title>
  <style>
    .seat {
      display: inline-block;
      width: 40px;
      height: 40px;
      border: 1px solid #ccc;
      margin: 5px;
      text-align: center;
      line-height: 40px;
    }
    .booked {
      background-color: red !important;
      color: white;
      cursor: not-allowed;
    }
    .selected {
      background-color: green;
      color: white;
    }
  </style>
</head>
<body>
  <form action="" method="POST" id="bookingForm">
    <div class="center">
      <div class="tickets">
        <div class="ticket-selector">
          <div class="head">
            <div class="title">Movie Name</div>
          </div>
          <div class="timings">
            <div>
              <label for="bookingDate">Select Date:</label>
              <input type="date" id="bookingDate" name="date">
            </div>
            <div class="times">
              <input type="radio" name="time" id="t1" value="9:45AM" checked />
              <label for="t1" class="time">9:45AM</label>
            </div>
          </div>
          <div class="seats">
            <div class="status">
              <div class="item">Available</div>
              <div class="item">Booked</div>
              <div class="item">Selected</div>
            </div>
            <div class="all-seats" id="allSeats">
              <?php
              if (!empty($bookedSeats)) {
                  // Use $bookedSeats array
                  for ($i = 'A'; $i <= 'E'; $i++) {
                      echo '<div class="row">';
                      for ($j = 1; $j <= 10; $j++) {
                          $seatNumber = $i . $j;
                          $class = in_array($seatNumber, $bookedSeats) ? ' booked' : ''; // Add space before class
                          echo '<div class="seat' . $class . '" id="'.$seatNumber.'">'; // Remove space before class
                          echo $seatNumber;
                          echo '<input type="checkbox" name="seatNumber[]" value="' . $seatNumber . '">';
                          echo '</div>';
                      }
                      echo '</div>';
                  }
              } else {
                  echo "No booked seats data available.";
              }
              ?>
            </div>
          </div>
          <input type="submit" name="submit" value="BOOK">
        </div>
      </div>
    </div>
  </form>

  <script>
    // Mark booked seats as red
    window.onload = function() {
      var bookedSeats = <?php echo json_encode($bookedSeats); ?>;
      bookedSeats.forEach(function(seat) {
        var seatElement = document.getElementById(seat);
        if (seatElement) {
          seatElement.classList.add('booked');
          var checkbox = seatElement.querySelector('input[type="checkbox"]');
          if (checkbox) {
            checkbox.disabled = true;
          }
        }
      });
    };
  </script>
</body>
</html>