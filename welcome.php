<?php
session_start(); 

  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>


<html>
<head>
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link rel="stylesheet" href="mainstyles.css" type="text/css">
        <title>Home</title>
</head>
<body id="LoginForm">
	<div class="container">
        	<h1 class="form-heading"></h1>
        	<div class="login-form">
        		<div class="main-div">
        			<div class="panel">
					<!-- notification message -->
				        <?php if (isset($_SESSION['success'])) : ?>
      						<div class="error success" >
        					<h2>	<?php
                						echo $_SESSION['success'];
                						unset($_SESSION['success']);
          						?>
        					</h2>
      						</div>
        				<?php endif ?>
					<?php  if (isset($_SESSION['username'])) : ?>
				        <h3>Welcome <strong><?php echo $_SESSION['username']; ?></strong></h3>
        				<p> <a href="welcome.php?logout='1'" style="color: red;">logout</a> </p>
    					<?php endif ?>
        			</div>
			</div>
		</div>
	</div>
</body>
</html>

