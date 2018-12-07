<!DOCTYPE html>
<?php
session_start();

 if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header("location: login.php");
  }
?>
<head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
         <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <title>UKY ACM-W</title>
</head>
<header>
  
<!-- Dropdown Structure -->
<ul id="dropdown1" class="dropdown-content">
  <li><a href="profile.php">My Profile</a></li>
  <li class="divider"></li>
  <li><a href="?logout='1'">Logout</a></li>
</ul>
  <nav>
    <div class="nav-wrapper deep-purple lighten-2">
      <div class="container">
          <a href="welcome.php" class="brand-logo">ACM-W</a>
          <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
          <ul class="right hide-on-med-and-down">
            <li><a href="events.php">Events</a></li>
	    <li><a href="members.php">Members</a></li>
	      <?php  if (isset($_SESSION['username']))
        	{
			echo "<li><a href=\"memberStats.php\">Member Stats</a><li>";
         		echo "<li><a class=\"dropdown-trigger\" href=\"#!\" data-target=\"dropdown1\">Account<i class=\"material-icons right\">arrow_drop_down</i></a>";
		}
		else
			echo"<li><a href=\"login.php\">Login</a></li>";
	      ?>
          </ul>
      </div>
    </div>
  </nav>

  <ul class="sidenav" id="mobile-demo">
    <li><a href="events.php">Events</a></li>
  </ul>
</header>
<main>
<body>
<div class="container">

<?php
 if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header("location: login.php");
  }
?>

