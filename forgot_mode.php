<?php include 'include/header.php';
 ?>
  <body>
  
  <div class="login-page">
  	<div class="login-header">
		<h3>Forget Password</h3>
	</div>
	
	
	<form method="post" id="forgot_phone" onsubmit="return reset_password();"  >
	<?php if(isset($_SESSION['succ_msg'])){
			?>
			<p class="text-center text-success"><b><?php echo $_SESSION['succ_msg']; ?></b></p>
			<?php
	} 
	unset($_SESSION['succ_msg']);
	?>
	<div class="login-form">
		<div class="field-login">
			<input style="padding-left:15px !important;" type="email" name="email" required id=""   placeholder="Enter Registered Email" class="mobile-number-input"> 
			
			<div class="verify-button">
				<button type="button" onclick="return otp_forgot_email();" class="btn btn-primary">Verify</button>
			</div>
		</div>
		<div class="field-login">
			
			<input style="margin-top: 52px;" type="text" maxlength="4" name="otp" required placeholder="Enter OTP Received On Mail">
		</div>
		<div class="field-login">
			<input placeholder="Enter New Password" minlength="6" required name="password" type="password">
			<p class="forget-pass"><a href="forgot_password.php" style="float:left">Reset Via Phone</a><a href="index.php">Return To Login</a></p>
		</div>
		<div class="field-login">
			<input type="submit" value="Reset Password Now" class="login-btn">
		</div>
		<p class="text-center create-link">
			Don't have an account? <a href="verification.php">Create account</a>
		</p>
	</div>
	</form>
  </div>
  
     

	$(document).ready(function(){
		$(".phonevalidation").keydown(function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 return;
        } 
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    }); 
	

	});

	</script>
  </body>