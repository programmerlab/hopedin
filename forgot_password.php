<?php include 'include/header.php';
 ?>
  <body>
  
  <div class="login-page">
  	<div class="login-header">
		<h3>FORGET PASSWORD</h3>
	</div>
	
	
	<form method="post" id="forgot_phone" onsubmit="return reset_password();"  >
	
	<div class="login-form">
		<div class="phase1">
			<div class="field-login">
				<input placeholder="Enter Email/Phone/Account Id" class="" id="user_emails" required name="email" type="text" />
				
			</div>
			
			<div class="field-login">
				<input placeholder="Enter ASP Pin" class="phonevalidation" id="phase_afp" required name="afp_pin" type="text" />
				<p class="forget-pass"><a href="#" style="float:left">Forget ASP</a><a href="index.php">Return To Login</a></p>
			</div>
			
			<div class="field-login">
				<input value="Next" onclick="return forgot_phase();" class="login-btn" type="button" />
			</div>
		</div>
		<div class="phase2" style="display:none;">
			<div class="field-login select-country">
			</div>
			<div class="field-login" style="text-align:center;">
				<input type="text" value="+86" name="mobile" required id="mobile_code"   placeholder="" class="mobile-number-input phonevalidation"> 
				<div class="verify-button">
					<button type="button" onclick="return otp_forgot();" class="btn btn-primary">Verify</button>
				</div>
			</div>
			<br>
			<br>
			<div class="field-login">
				<input type="text" maxlength="4" name="otp" required placeholder="Enter OTP Received On Mobile">
			</div>
			<div class="field-login">
				<input placeholder="Enter New Password" minlength="6" required name="password" type="password">
				<p class="forget-pass"><a href="forgot_mode.php" style="float:left">Reset Via Email</a><a href="index.php">Return To Login</a></p>
			</div>
			
			<div class="field-login">
				<input type="submit" value="Reset Password Now" class="login-btn">
			</div>
		</div>
		
		<p class="text-center create-link">
			Don't have an account? <a href="verification.php">Create account</a>
		</p>
	</div>
	</form>
  </div>
  
     
	<script src="build/js/intlTelInput.js"></script>
    <script>
    $("#mobile_code").intlTelInput({
		preferredCountries: ['cn', 'pk'],
		//separateDialCode: true,
      utilsScript: "build/js/utils.js"
    });
	</script>
	<script>

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