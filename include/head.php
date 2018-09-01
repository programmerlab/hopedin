<?php
if(!isset($_SESSION['session_user_set']))
{
	echo "<script>window.location.href='login.php'</script>";
	die;
}
$data=$db->get_user();
$row=mysqli_fetch_array($data);
$image=$row['profile'];
 ?>
  <body>
  <style>
  .upper_case
  {
	  text-transform: capitalize;
  }
  </style>
  <div class="main-header">
  <div class="dashboard-header">
  	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-4">
				<div class="profile-pic">
					<img src="uploads/<?php echo $image; ?>">
				</div>
				<div class="profile-name">
					<p><?php echo $row['fname']." ".$row['lname']; ?></p>
					<p><span class="upper_case"><?php echo $row['user_type']; ?></span> : <?php echo $row['account_id']; ?></p>   
				</div>
			</div>
			<div class="col-sm-8">
				<div class="top-menu">
					<ul class="first-top">
						
						<li><a href="#"><span><i  class="fa fa-search"></i></span><span>Verify</span></a></li>
						<li><a href="#"><span><i  class="fa fa-qrcode"></i></span><span>QR Code</span></a></li>
						<li onclick="return update_notification();"><a href="#" class="dropdown-toggle" data-toggle="dropdown"  role="button" aria-haspopup="true" aria-expanded="false"  >						
						 <?php $ndata=$db->get_notification();	 						  
						 $count=mysqli_num_rows($ndata);							  
						 if($count)							  
						 {						
					     ?>
						 <span style="position:absolute;" class="badge count_not"><?php echo $count; ?></span> <?php } ?> <span><i  class="fa fa-bell"></i></span><span>Account</span> </a>			<ul class="dropdown-menu">	
						 <?php if($count)									
						 {										
								while($nrow=mysqli_fetch_array($ndata))										
								{								   
						?>									
						<li>										
						<img src="uploads/<?php echo $nrow['profile']; ?>" height="50" width="50" > 										
						<p><b><a style="color:black;" href="profile-page.php?id=<?php echo $nrow['rid']; ?>"><?php echo $nrow['fname']." ".$nrow['lname']; ?></a></b></p><p><?php echo $nrow['msg']; ?></p>									
						</li>									
						<?php } } else {										
						?>										
						<p class="alert alert-danger">No Notification Yet!</p>
						<?php									
						}									
						?>							  
						</ul>							  							  
						</li>
						
						<li><a href="#"><span><i  class="fa fa-bell"></i></span><span>Enrollment</span></a></li>
						<li><a href="#"><span><i  class="fa fa-bell"></i></span><span>Study</span></a></li>
						<li><a href="#"><span><i  class="fa fa-bell"></i></span><span>Shopping</span></a></li>
						<li><a href="#"><span><i  class="fa fa-bell"></i></span><span>Booking</span></a></li>
						
						<li><a href="#"><span><i  class="fa fa-bell"></i></span><span>Transaction</span></a></li>
						<li><a href="#"><span><i class="fa fa-life-ring"></i></span><span>Support</span></a></li>
						<li><a href="#"><span><i class="fa fa-star"></i></span><span>Rate Us</span></a></li>
						<li><a href="#"><span><i class="fa fa-share"></i></span><span>Share</span></a></li>
						
						<li><a href="logout.php"><span><i  class="fa fa-power-off" style="color:red"></i></span><span>Sign Out</span></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
  </div>
  
  <div class="dashboard-header second-header">
  	<div class="container-fluid">
		<div class="row">
			
			<div class="col-sm-12">
			<div class="top-menu">
					<ul>
						<li><a href="dashboard.php" class="link-active">
						<span class="count_read">
						<?php $all_read=$db->Get_unread_msg_all();
							  $all_count=mysqli_num_rows($all_read); 
							  if($all_count){
						?>
						 <span style="position:absolute; left: 80%;" class="badge"><?php echo $all_count; ?></span><?php } ?></span><span><i  class="fa fa-comment"></i></span>
						 <span>Chat</span></a></li>												
						
						<li><a href="find-new-friend.php">
						<span class="count_request">   
						<?php $all_read=$db->Get_my_requests();
							  $all_count=mysqli_num_rows($all_read);
							  if($all_count){
						?>
						 <span style="position:absolute; left: 80%;" class="badge"><?php echo $all_count; ?></span><?php } ?></span>
						<span><i  class="fa fa-users"></i></span><span>Contacts</span></a></li>
						
						<li><a href="discover.php"><span><i class="fa fa-pie-chart" aria-hidden="true"></i></span><span>Discover</span></a></li>
						<li><a href="#"><span><i  class="fa fa-info-circle"></i></span><span>Enrollment</span></a></li>
						<li><a href="#"><span><i  class="fa fa-list-alt"></i></span><span>Resume</span></a></li>
						<li><a href="#"><span><i  class="fa fa-bullhorn"></i></span><span>Jobs</span></a></li>
						<li><a href="profile-detail.php"><span><i  class="fa fa-university"></i></span><span>Schools</span></a></li>
						<li><a href="#"><span><i  class="fa fa-book"></i></span><span>Admission</span></a></li>
						<li><a href="#"><span><i  class="fa fa-graduation-cap"></i></span><span>Scholarships</span></a></li>
						<li><a href="#"><span><i  class="fa fa-mouse-pointer"></i></span><span>Exams</span></a></li>
						
						<li><a href="#"><span><i  class="fa fa-signal"></i></span><span>Results</span></a></li>
						<li><a href="#"><span><i  class="fa fa-desktop"></i></span><span>E-Learning</span></a></li>
						<li><a href="#"><span><i  class="fa fa-credit-card"></i></span><span>Visa Info</span></a></li>
						<li><a href="#"><span><i  class="fa fa-print"></i></span><span>Document</span></a></li>
						<li><a href="#"><span><i class="fa fa-cart-plus"></i></span><span>Shopping</span></a></li>
						<li><a href="#"><span><i  class="fa fa-plane"></i></span><span>Booking</span></a></li>
						
						<li><a href="#"><span><i  class="fa fa-dollar"></i></span><span>Wallet</span></a></li>
						<li><a href="#"><span><i  class="fa fa-history"></i></span><span>History</span></a></li>
						<li><a href="general-information.php"><span><i  class="fa fa-user"></i></span><span>Account</span></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
  </div>
  </div>
 