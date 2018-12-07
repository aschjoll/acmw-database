<?php include('header.php');

  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>

<html>
  <div class="container">
    <h1 class="form-heading"></h1>
    <div class="login-form">
      <div class="main-div">
        <div class="panel">
	  <!-- notification message -->
	    <?php if (isset($_SESSION['success'])) : ?>
      	      <div class="error success" >
                <div id="card-alert" class="card pink lighten-5">
                  <div class="card-content pink-text darken-1">
                    <span class="card-title pink-text darken-1"> 
		      <?php  if (isset($_SESSION['username']))?> 
		             Welcome <?php echo $_SESSION['username'];?>
		      <?php endif; ?>
		    </span>
		    <p><?php echo $_SESSION['success'];
                      	unset($_SESSION['success']);
		    ?></p>
		  </div>
                </div>
      	      </div>
           <!-- end notification message -->
	      <div class="center">
	    	<h4>Welcome to the</h4><br>
		<div class="divider"></div>
		<span class="deep-purple-text text-accent-2"><h3>University of Kentucky chapter of the ACM-W!</h3>
		</span>
               	<div class="divider"></div>
		<div class="row">
		  <div class="col s12 m6">
		    <div class="vertical-align">
		      <span class="teal-text text-darken-1"><br><br><br><br><h3>who we are</h3>
		    </div>
   		  </div>
		  <div class="col s12 m6">
		    <div class="card-panel teal lighten-5">
		      <span><p>We are a group of Computer Science/Engineering and Information Technology students and hobbyists. At ACM-W, we are all about creating new projects, cultivating lasting friendships, and sharing ideas with each other.</p>
		    </span>
		  </div>
		</div>
              	<div class="row">
                  <div class="col s12 m6">
                    <div class="vertical align">
                      <span class=" teal-text text-darken-1"><br><br><br><br><h3>what we do</h3>
              	    </div>
                  </div>
                <div class="col s12 m6">
                  <div class="card-panel teal lighten-5">
    		    <span><p>Since inception, our focus has been empowering others through technology. Our members have done everything from running coding workshops at local schools to building apps that help feed the homeless and connect students.</p>
              	    </span>
		  </div>
		</div>
	      </div>
          </div>
        </div>
      </div>
</html>

<?php include('footer.php'); ?>

