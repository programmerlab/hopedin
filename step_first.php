<?php include 'include/header.php';
unset($_SESSION['session_type']);
?>
  <body>
  
  <div class="login-page">
  	<div class="login-header">
		<h3>SIGNUP AS</h3>
	</div>
	
	<form method="post" action="verification.php" >
	<div class="login-form">
		<div class="field-login select-country">
		</div>
		
		<div class="field-login col-sm-3" style="text-align:center; margin-left: 37.5%;">
			<select required name="user_type" class="form-control" >
				<option value="">Select signup As</option>
				<option value="student">Student</option>
				<option value="teacher">Teacher</option>
			</select>
		</div>
		<br/><br/>
		
		<div class="field-login">
			<input type="submit" value="Next" class="login-btn">
		</div>
		<p class="text-center create-link">
			Already have an account? <a href="index.php">Login</a>
		</p>
	</div>
	</form>
  </div>
  
     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://use.fontawesome.com/a832a5b49f.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	<script src="build/js/intlTelInput.js"></script>


  </body>