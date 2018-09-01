<script>
$(document).ready(function(){
  $("#contact_user").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".mine_record li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

</script>
			<div class="col-sm-3 side-menu">
				<div class="search-menu">
					<input type="text" id="contact_user" placeholder="Search here">
					<span class="search-ico"><a href="#"><i class="fa fa-search"></i></a></span>
				</div>
				<ul class="side-menu-list mine_record">													
					<li><a href="find-new-friend.php"><span class="menu-icon"><i class="fa fa-search-plus"></i></span> Find New Friends</a> <span class="right-ico"><i class="fa fa-angle-right"></i></span></li>
					<?php 
					$data2=$db->Get_my_requests(); 
					$count2=mysqli_num_rows($data2);
					?>
					<li class=""><a href="freind-request.php"><span class="menu-icon"><i class="fa fa-user-plus"></i></span> </span> Friend Requests</a> <span class="right-ico">
					<span class="count_request1"><?php if($count2){ ?><span class="badge"><?php echo $count2; ?></span><?php } ?></span><i class="fa fa-angle-right"></i>
					</span></li>
					<li><a href="group-chat.php"><span class="menu-icon"><i class="fa fa-users"></i></span> Group Chat</a> <span class="right-ico"><i class="fa fa-angle-right"></i></span></li>
					<li><a href="#"><span class="menu-icon"><i class="fa fa-podcast"></i></span> Broadcast</a> <span class="right-ico"><i class="fa fa-angle-right"></i></span></li>
					<li><a href="tags.php""><span class="menu-icon"><i class="fa fa-tags"></i></span> Tags</a> <span class="time">10:30 am</span> <span class="right-ico"><i class="fa fa-angle-right"></i></span></li>
					<?php $data1=$db->Get_my_friends();
						  $count=mysqli_num_rows($data1);
						  if($count)
						  {
						  while($row1=mysqli_fetch_array($data1))
						  {
							 
							?>
							<li class="chat-selected"><a class="" href="profile-page.php?id=<?php echo $row1['id']; ?>"><span class="menu-icon"><img src="uploads/<?php echo $row1['profile']; ?>"></span> <?php echo explode(" ",$row1['fname'])[0]; ?></a>  <span class="right-ico"> <i class="fa fa-angle-right"></i></span></li>
							<?php
						  }
						  }
						  else 
						  {
							  ?>
							  <p class="alert alert-danger text-center">No Friends Yet!</p>
							  <?php
						  }
					?>
						
				</ul>
</div>