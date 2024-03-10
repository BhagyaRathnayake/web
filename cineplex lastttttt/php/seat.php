<?php
@include '../Includes/dbh.inc.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Fetch booked seats from the database
$bookedSeats = array();
$selectQuery = "SELECT seatNumber FROM seating";
$result = mysqli_query($conn, $selectQuery);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $seats = explode(",", $row['seatNumber']);
        foreach ($seats as $seat) {
            $bookedSeats[] = trim($seat);
        }
    }
}

if (isset($_POST['submit'])) {
    if (isset($_POST['seatNumber']) && !empty($_POST['seatNumber'])) {
        $selectedSeats = $_POST['seatNumber'];
        $seatString = implode(",", $selectedSeats);

        $insertQuery = "INSERT INTO seating (seatNumber) VALUES (?)";
        $stmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($stmt, "s", $seatString);
        
        if (mysqli_stmt_execute($stmt)) {
            // Booking successful
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
          <div class="seats">
            <div class="status">
              <div class="item">Available</div>
              <div class="item">Booked</div>
              <div class="item">Selected</div>
            </div>
            <div class="all-seats" id="allSeats">
              <?php
              // Generate seats for rows A to E and columns 1 to 10
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