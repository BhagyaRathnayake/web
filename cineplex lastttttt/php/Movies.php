<?php

session_start();
@include '../Includes/dbh.inc.php';




?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cineplex Cinemas - Buy Movie Tickets Online for the Latest Movies</title>
  <link rel="shortcut icon" href="../img/Logo/logos.png">
  <link rel="stylesheet" href="../css/Movies.css">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet" />
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</head>

<body>

  <nav class="nav">
    <i class="uil uil-bars navOpenBtn"></i>
    <a href="#" class="logo"><img src="../img/Logo/logo.png" alt=""></a>
    <ul class="nav-links">
      <i class="uil uil-times navCloseBtn"></i>
      <li class="ab"><a href="Index.php">Home</a></li>
      <li class="ab"><a href="Movies.php">Movies</a></li>
      <li class="ab"><a href="Event.php">Events</a></li>
      <li class="ab"><a href="../html/aboutus.html">About Us</a></li>
      <li class="ab"><a href="#">Contact Us</a></li>

      <?php

      if (isset($_SESSION['email'])) {
        echo '<li class="ab"><a href="#"> Hello,  ' . $_SESSION['name'] . '</a></li>';
        echo '<li class="ab"><a href="\dila\php\logout.php">Logout</a></li>';
      } else {
        echo            ' <li class="ab"><a href="../php/Login.php">Login</a></li>';
      }
      ?>
    </ul>

    <i class="uil uil-search search-icon" id="searchIcon"></i>
    <div class="search-box">
      <i class="uil uil-search search-icon"></i>
      <input type="text" placeholder="Search here..." />
    </div>
  </nav>


  <section class="section3">

    <h2> NOW SHOWING </h2>
    <br>
    <br>
    <br>
    <div class="cards">

      <?php

      $sql = "SELECT * FROM movies LIMIT 4;";

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '      <div class="card">
         <img src="' . $row["image"] . '" alt="">
         <div class="details">
         <h2>' . $row["name"] . '</h2>
         <div class="allbtn">
         <a href="seat.php">
         <button class="login">Book Now</button></a>
         <a href="'.$row["Trailer"].'" target="_blank">
         <button class="seeMore">Trailer</button></a>
         
        </div>
      </div>
    </div>';
        }
      } else {
        echo "<p>No Movies Available</p>";
      }
      ?>

<section class="section4"> 
    <h2> Special Screening </h2>
    <br>
    <br>
    <br>
    <div class="cards">

      <?php
      $sql = "SELECT * FROM specialscreening LIMIT 4;";

      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '      <div class="card">
          <img src="' . $row["image"] . '" alt="">
          <div class="details">
          <h2>' . $row["name"] . '</h2>
          <div class="allbtn">
          <a href="seat.php">
          <button class="login">Book Now</button></a>
          <a href="'.$row["Trailer"].'" target="_blank">
         <button class="seeMore">Trailer</button></a>
        </div>
      </div>
    </div>';
        }
      } 
      else 
      {
        echo "<p>No Movies Available</p>";
      }

      ?>
    </div>
  </section>

  <footer>
    <div class="row primary">
      <div class="column about">
        <h3>Cineplex Cinemas</h3>
        <p>
          Your Gateway to Great Films! Experience the magic of the big screen at Cineplex Cinemas.
          From Hollywood blockbusters to indie favorites, we bring you the best in cinematic entertainment.
          Join us for an unforgettable movie experience!
        </p>
      </div>
      <div class="column links">
        <h3>Quick Links</h3>
        <ul>
          <li>
            <a href="#terms-of-services">Terms Of Service</a>
          </li>
          <li>
            <a href="#support">Support</a>
          </li>
          <li>
            <a href="#support">About Us</a>
          </li>
        </ul>
      </div>
      <div class="column subscribe">
        <h3>Subscribe</h3>
        <div class="social">
          <a href="https://www.facebook.com/Cineplex"><i class="fab fa-facebook-square"></i></a>
          <a href="https://www.instagram.com/redecineplex?igsh=aGloZTRvYjdjcjZ0"><i class="fa-brands fa-instagram-square"></i></a>
          <a href="https://twitter.com/CineplexMovies?ref_src=twsrc%5Egoogle%7Ctwcamp%5Eserp%7Ctwgr%5Eauthor"><i class="fa-brands fa-twitter-square"></i></a>
        </div>
      </div>
    </div>
    <div class="row secondary">
      <div>
        <p>
          <i class="fas fa-phone-alt"></i>
        </p>
        <p>+94 77 199 1951</p>
      </div>
      <div>
        <p><i class="fas fa-envelope"></i></p>
        <a href="https://mail.google.com/mail/u/0/#inbox">
          <p>guestservices@cineplex.com</p>
        </a>
      </div>
      <div>
        <p><i class="fas fa-map-marker-alt"></i></p>
        <a href="https://www.google.com/maps/dir//Sudarshana,+51+Polwaththa+Rd,+Ampitiya/@7.2663643,80.6100292,13z/data=!4m8!4m7!1m0!1m5!1m1!1s0x3ae36736d6185187:0x7341c788bd7227b9!2m2!1d80.6618922!2d7.2704054?entry=ttu">
          <p>1234 Sudarshana Street, Kandy</p>
        </a>
      </div>
    </div>
    <div class="row copyright">
      <p>Copyright &copy; 2024 Dila Coding | All Rights Reserved</p>
    </div>
  </footer>

  <script src="../js/index.js"></script>
</body>

</html>