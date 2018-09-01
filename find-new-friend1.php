<?php include 'include/header.php';
include 'include/head.php';
?>
  
  
  <div class="dashboard-content">
  	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3 side-menu">
				<div class="search-menu">
					<input type="text" placeholder="Search here">
					<span class="search-ico"><a href="#"><i class="fa fa-search"></i></a></span>
				</div>
				<ul class="side-menu-list">
					<li class="chat-selected"><a href="find-new-friend.php"><span class="menu-icon"><i class="fa fa-search-plus"></i></span> Find New Friends</a> <span class="right-ico"><i class="fa fa-angle-right"></i></span></li>
					<li><a href="freind-request.php"><span class="menu-icon"><i class="fa fa-user-plus"></i></span> </span> Friend Requests</a> <span class="right-ico"><i class="fa fa-angle-right"></i></span></li>
					<li><a href="group-chat.php"><span class="menu-icon"><i class="fa fa-users"></i></span> Group Chat</a> <span class="right-ico"><i class="fa fa-angle-right"></i></span></li>
					<li><a href="#"><span class="menu-icon"><i class="fa fa-podcast"></i></span> Broadcast</a> <span class="right-ico"><i class="fa fa-angle-right"></i></span></li>
					<li><a href="tags.php"><span class="menu-icon"><i class="fa fa-tags"></i></span> Tags</a> <span class="time">10:30 am</span> <span class="right-ico"><i class="fa fa-angle-right"></i></span></li>
				</ul>
			</div>
			<div class="col-sm-9 right-content">
				<div class="main-right">
					<h4 class="chat-name">Find New Friends</h4>
					
					<div class="public-profile">
						<div class="find-new">
							<input type="text" onkeyup="return search_new($(this).val());" placeholder="Email / Phone Number / Account ID">
							<span class="search-ico"><a href="#"><i class="fa fa-search"></i></a></span>
						</div><br>
						<div class="row" style="clear: both;">
							<div class="find_result">
							</div>
						</div>
						<div class="acr">
							<div class="panel-group" id="accordion">
								<div class="panel panel-default">
								  <div class="panel-heading">
									<h4 class="panel-title">
									  <a href="#"><i class="fa fa-qrcode" style="float:left; margin-top:3px; margin-right:15px;"></i>Scan QR Code <span><i class="fa fa-angle-right"></i></span>
									   </a>
									</h4>
								  </div>
								  
								</div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a href="#"><i class="fa fa-globe" style="float:left; margin-top:3px; margin-right:15px;"></i>Look In Near By <span><i class="fa fa-angle-right"></i></span></a>
        </h4>
      </div>
      
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a href="#"><i class="fa fa-address-book" style="float:left; margin-top:3px; margin-right:15px;"></i>Add Phone Contact <span><i class="fa fa-angle-right"></i></span></a>
        </h4>
      </div>
      
    </div>
	<div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a href="#"><i class="fa fa-facebook-f" style="float:left; margin-top:3px; margin-right:15px;"></i>Add Facebook Friend <span><i class="fa fa-angle-right"></i></span></a>
        </h4>
      </div>
      
    </div>
	
	
  </div> 
						</div>
						
						
						
						
					</div>
					
					
					
					
				</div>
			</div>
		</div>
	</div>
  </div>
  
     <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.12/js/all.js" integrity="sha384-Voup2lBiiyZYkRto2XWqbzxHXwzcm4A5RfdfG6466bu5LqjwwrjXCMBQBLMWh7qR" crossorigin="anonymous"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	

  </body>