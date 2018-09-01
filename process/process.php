<?php 
include ('../include/functions.php');
$db= new functions();
if(isset($_REQUEST['action']) && $_REQUEST['action']=='Do_signup')
{
	$data=$db->checkemail($_REQUEST['email']);
	$data1=$db->checkmobile($_REQUEST['mobile']);
	if(mysqli_num_rows($data))
	{
		echo "0";
		die;
	}
	else if(mysqli_num_rows($data1))
	{
		echo "3";
		die;
	}
	else
	{
		$img=end(explode(".",$_FILES['file']['name'])); 
		$f_name=time().".".$img;
		$_POST['cdate']=date('Y-m-d H:i:s');
		$_POST['profile']=$f_name;
		$_POST['user_type']=$_SESSION['session_type'];
		$my_rand_strng = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), -2).rand ( 100000000000 , 999999999999 );
		$_POST['account_id']=$my_rand_strng;
		$ins=$db->insert_data('registration',$_POST);
		if($ins)
		{
			move_uploaded_file($_FILES['file']['tmp_name'], "../uploads/".$f_name);
			unset($_SESSION['mobileNumber']);
			unset($_SESSION['session_type']);
			echo "1";
			die;
		}
		else
		{
			echo "2";
			die;
		}
		

	}
}
else if(isset($_REQUEST['action']) && $_REQUEST['action']=='change_subemail'){	
		$sel="select * from registration where email='".$_REQUEST['email']."' and id='".$_SESSION['session_user_set']."'";    
		$data=$db->query($sel);	
		if(mysqli_num_rows($data))	{		
		$row=mysqli_fetch_assoc($data);		
		if($row['afp_pin']==$_REQUEST['asp_pin'])		
		{			
		$sql="select * from registration where email='".$_REQUEST['new_email']."' and id!='".$_SESSION['session_user_set']."'";			
		$q=$db->query($sql);			
		if(mysqli_num_rows($q))			
		{				
		echo "3";			
		}			
		else 			{				
		$db->query("update registration set email='".$_REQUEST['new_email']."' where id='".$_SESSION['session_user_set']."'");				
		echo "1";			
		}					
		}		
		else 		
		{			echo "0";		
		}	
		}	else 	{
			echo "2";	
			}	die;
}
else if(isset($_REQUEST['action']) && $_REQUEST['action']=='profile_uform')
{
	if($_FILES['file']['name'])
	{
		$img=end(explode(".",$_FILES['file']['name'])); 
		$f_name=time().".".$img;
		move_uploaded_file($_FILES['file']['tmp_name'], "../uploads/".$f_name);
		$_POST['profile']=$f_name;
	}
	$q=$db->create_query($_POST);
	$sql="update registration set $q where id='".$_SESSION['session_user_set']."'";
	$db->query($sql);
	$_SESSION['succ_msg']='Success!';
	echo "<script>window.location.href='../profile-management.php'</script>";
	die;
}
else if(isset($_REQUEST['action']) && $_REQUEST['action']=='chat_unread_msg') 
{
	$db->query("update chat_msg set deliver=1 where chat_msg.receiver=".$_SESSION['session_user_set']);
	$all_read=$db->Get_unread_msg_all();
	echo $all_count=mysqli_num_rows($all_read); 
	echo "@";
	$data=$db->Get_my_requests(); 
	echo $count=mysqli_num_rows($data);
	die;
}

else if(isset($_REQUEST['action']) && $_REQUEST['action']=='update_contact_list')
{
	?>
	<li><a href="#"><span class="menu-icon"><i class="fa fa-mobile" style="font-size:30px;"></i></span> Mobile Chat App</a> <span class="right-ico"><i class="fa fa-angle-right"></i></span></li>
					<?php $data1=$db->Get_my_friend_chat(); 
						  $count=mysqli_num_rows($data1);
						  if($count)
						  {
						  while($row1=mysqli_fetch_array($data1))
						  {
							  $mdata=$db->Get_unread_msg($row1['id']);
							  $msg_count=mysqli_num_rows($mdata);
							?>
							<li class="chat-selected"><a class="get_chat my_chatting<?php echo $row1['id']; ?>" data-id="<?php echo $row1['id']; ?>" href="javascript:void(0);"><span class="menu-icon"><img src="uploads/<?php echo $row1['profile']; ?>"></span> <?php echo explode(" ",$row1['fname'])[0]; ?></a> <span class="time"><?php if($row1['cdate']){ echo $db->humanTiming(strtotime($row1['cdate']))." ago"; } ?></span>  <span class="right-ico"><?php if($msg_count){ ?><span class="badge cout<?php echo $row1['id']; ?>"><?php echo $msg_count; ?></span><?php } ?> <i class="fa fa-angle-right"></i></span></li>
							<?php
						  }
						  }
						  else 
						  {
							  ?>
							  <p class="alert alert-danger text-center">No Friends Yet!</p>
							  <?php
						  }
					
}

else if(isset($_REQUEST['action']) && $_REQUEST['action']=='get_chat_side')
{
	$data=$db->get_user_byId($_REQUEST['id']);
	$row=mysqli_fetch_assoc($data);
	?><div class="main-right">
					<h4 class="chat-name"><?php echo $row['fname'] ?> <a style="color:#163962;" href="profile-page.php?id=<?php echo $row['id']; ?>"><i class="fa fa-user"></i></a></h4>
					<div class="chat-screen">
					</div>
					<div class="fix-typer">
						<div class="chat-type-board">
						   <form method="post" id="chat_msg" onsubmit="return chat_start();" >
							<div class="typer">
								<span><a href="#"><i class="fa fa-calendar"></i></a></span>
								<span class="laod-aud"><a href="javascript:void(0);" id="start-btn" ><i class="fa fa-circle-o-notch fa-spin fa-fw loader1"  style="display:none;"></i><img src="img/mike.png"></a>
								<a href="javascript:void(0);" style="display:none;" id="stop-btn"><img src="img/mike.png"></a>
								</span>
								<span>
								
								<input type="text" id="chat_text" data-emojiable="true" required name="msg" placeholder="Type your message">
								<input type="hidden" id="reciver_id" value="<?php echo $row['id']; ?>" required name="rid">
								<button type="submit" id="chat_submit" style="display:none;" >send</button>
								</span>
								<span class="span-face"></span>
								<span><a onclick="$('#chat_submit').trigger('click');" href="javascript:void(0);"><i class="fa fa-arrow-circle-o-right"></i></a></span>
							</div>
						    </form>
						</div>
					
						<div class="chat-uploaders">
							
							<ul>
							<li><a href="javascript:void(0);" data-toggle="modal" data-target="#files_Modal" ><span><i  class="fa fa-folder-open"></i></span><span>Gallery</span></a>
							</li>
							<li><a class="cameras" href="javascript:void(0);"><span><i  class="fa fa-camera"></i></span><span>Camera</span></a></li>
							<li><a href="javascript:void(0);" data-toggle="modal" data-target="#files_Modal"><span><i  class="fa fa-print"></i></span><span>Document</span></a></li>
							<li><a href="#"><span><i class="fa fa-phone"></i></span><span>Call Audio</span></a></li>
							<li><a href="#"><span><i class="fa fa-video-camera" aria-hidden="true"></i></span><span>Call Video</span></a></li>
							<li><a href="#"><span><i  class="fa fa-gift"></i></span><span>Kick In</span></a></li>
							<li><a href="#"><span><i class="fa fa-exchange"></i></span><span>Transfer</span></a></li>
							<li><a href="#"><span><i  class="fa fa-dollar"></i></span><span>Pay Free</span></a></li>
							<li><a href="#"><span><i  class="fa fa-heart"></i></span><span>Favorite</span></a></li>
							<li><a href="javascript:void(0);" onclick="Get_geo_location();"><span><i  class="fa fa-map"></i></span><span>Location</span></a></li>
							<li><a href="#"><span><i  class="fa fa-address-book"></i></span><span>Contact</span></a></li>
						</ul>
						</div>
					</div>
				</div>
				<!-- Modal -->
					<div id="files_Modal" style="top:25%;" class="modal fade" role="dialog">
					  <div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
						  <div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Upload File:</h4>
						  </div>
						  <form action="process.php" onsubmit="return file_submit();" method="post" enctype="multipart/form-data" id="upload_form">
						  <div class="modal-body">
							<div class="form-wrap">
								<input name="file" type="file" />
								<input type="hidden" value="<?php echo $row['id']; ?>" required name="rid">
								<!--div id="progress-wrp"><div class="progress-bar"></div ><div class="status">0%</div></div>
								<div id="output" --><!-- error or success results ></div -->
							</div>
						  </div> 
						  <div class="modal-footer">
							<button type="submit" class="btn btn-success btn_prop">Send <i class="fa fa-spinner fa-spin fa-fw btn_load" style="display:none;"></i></button>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						  </div>
						  </form>
						</div>

					  </div>
				  </div>
				
	<?php
}
else if(isset($_REQUEST['action']) && $_REQUEST['action']=='file_submit')
{
	$img=end(explode(".",$_FILES['file']['name']));
	$f_name=time().".".$img;
	if(move_uploaded_file($_FILES['file']['tmp_name'],'../img/chat_files/'.$f_name))
	{
		echo $_FILES['file']['type'];
		$ins="insert into chat_msg set sender='".$_SESSION['session_user_set']."',receiver='".$_REQUEST['rid']."',msg='',cdate='".date('Y-m-d H:i:s')."',file='".$f_name."',types='".$_FILES['file']['type']."'";
		$db->query($ins);  
		echo "1";
	}
	else 
	{
		echo "0"; 
	}
	die;
	
	
}
else if(isset($_REQUEST['action']) && $_REQUEST['action']=='upload_camera')
{
	$f_name=$_REQUEST['file'];
	$ins="insert into chat_msg set sender='".$_SESSION['session_user_set']."',receiver='".$_REQUEST['id']."',msg='',cdate='".date('Y-m-d H:i:s')."',file='".$f_name."',types='image/mpeg'";
	$db->query($ins);
	echo "1";
}
else if(isset($_REQUEST['action']) && $_REQUEST['action']=='add_recordFile')
{
	/*$data=$_REQUEST['url'];
	//list($type, $data) = explode(';', $data);
	//list(, $data)      = explode(',', $data);
	$data = base64_decode($data);	
	$file=time()."."."wav";
	file_put_contents('../img/chat_files/'.$file, $data);
	$ins="insert into chat_msg set sender='".$_SESSION['session_user_set']."',receiver='".$_REQUEST['id']."',msg='',cdate='".date('Y-m-d H:i:s')."',file='".$file."',types='audio/mpeg'";
	$ins="insert into chat_msg set sender='".$_SESSION['session_user_set']."',receiver='".$_REQUEST['id']."',msg='',cdate='".date('Y-m-d H:i:s')."',file='".$_REQUEST['url']."',types='record/mpeg'";
	$db->query($ins);  */
	$f_name = time().".wav";
	echo $_FILES['audio_data']['name'];
	$ins="insert into chat_msg set sender='".$_SESSION['session_user_set']."',receiver='".$_REQUEST['id']."',msg='',cdate='".date('Y-m-d H:i:s')."',file='".$f_name."',types='audio/mpeg'";
	$db->query($ins);
	move_uploaded_file($_FILES['audio_data']['tmp_name'],'../img/chat_files/'.$f_name);
	echo "1";
}


else if(isset($_REQUEST['action']) && $_REQUEST['action']=='chat_start')
{
	$ins="insert into chat_msg set sender='".$_SESSION['session_user_set']."',receiver='".$_REQUEST['rid']."',msg='".htmlentities($_REQUEST['msg'],ENT_QUOTES)."',cdate='".date('Y-m-d H:i:s')."'";
	$db->query($ins);
	echo "1";
}
else if(isset($_REQUEST['action']) && $_REQUEST['action']=='update_notification')
{
	$sel="update notification set status='1' where notification.other_id='".$_SESSION['session_user_set']."'";
    $run=$db->query($sel);
    echo "1";
}

else if(isset($_REQUEST['action']) && $_REQUEST['action']=='update_chat')
{
	$db->query("update chat_msg set status=1 where chat_msg.sender='".$_REQUEST['id']."' and chat_msg.receiver=".$_SESSION['session_user_set']);
	$data=$db->get_user_chat($_REQUEST['id']);
	while($row=mysqli_fetch_assoc($data))
	{
		$row['cdate']=$db->humanTiming1(strtotime($row['cdate']));  
		$result['chat'][]=$row;
	}
	echo json_encode($result);
}

else if(isset($_REQUEST['action']) && $_REQUEST['action']=='asp_form')
{
	$sel="select * from registration where afp_pin='".$_REQUEST['old_asp']."' and id='".$_SESSION['session_user_set']."'";
    $run=$db->query($sel);
	if(mysqli_num_rows($run))
	{
		$row=mysqli_fetch_assoc($run);
		if($row['password']==$_REQUEST['password'])
		{
			$db->query("update registration set afp_pin='".$_REQUEST['new_asp']."' where id='".$_SESSION['session_user_set']."'");
			echo "1";
			die;
		}
		else
		{
			echo "2";
			die;
		}
	}
	else
	{
		echo "0";
		die;
	}
}
else if(isset($_REQUEST['action']) && $_REQUEST['action']=='password_submit')
{
	$sel="select * from registration where password='".$_REQUEST['old_password']."' and id='".$_SESSION['session_user_set']."'";
    $run=$db->query($sel);
	if(mysqli_num_rows($run))
	{
		$db->query("update registration set password='".$_REQUEST['password']."' where id='".$_SESSION['session_user_set']."'");
		echo "1";
		die;
	}
	else
	{
		echo "0";
		die;
	}
}

else if(isset($_REQUEST['action']) && $_REQUEST['action']=='search_new')
{
	$sel="select * from registration where (email LIKE '".$_REQUEST['keyword']."' or  account_id LIKE '".$_REQUEST['keyword']."' or mobile='".trim($_REQUEST['keyword'],"+")."') and id!='".$_SESSION['session_user_set']."'";
	$q=$db->query($sel);
	$count=mysqli_num_rows($q);
	if($count && $_REQUEST['keyword']!='')
	{
		while($row=mysqli_fetch_assoc($q))
		{
			?>
			<div class="col-sm-6" style="padding: 10px;">
				<div class="pub-pro">
					<a href="profile-page.php?id=<?= $row['id']; ?>"><img src="uploads/<?= $row['profile']; ?>" alt=""></a>
				</div>
				<div class="public-content">
					<a href="profile-page.php?id=<?= $row['id']; ?>"><p><?php echo $row['fname']." ".$row['lname']; ?></p></a>
					<p>Gender: <?php echo $row['gender']; ?></p>
					<p>Country: <?php echo $row['country']; ?></p>
					<p>Age: <?php echo $row['age']; ?> Years</p>
					<button type="button" data-id="<?php echo $row['id']; ?>" class="btn btn-danger btn-sm add_new_friend">+ Add Friend</button>
			    </div>
			</div>
			<?php
		}
	}
	else 
	{
		echo "0";
		die;
	}
}

else if(isset($_REQUEST['action']) && $_REQUEST['action']=='add_new_friend')
{
	$rid=$_REQUEST['rid'];
	$sel="delete from friend_tbl where (requested_by='$rid' and requested_to='".$_SESSION['session_user_set']."') or (requested_to='$rid' and requested_by='".$_SESSION['session_user_set']."')";
    $run=$db->query($sel);
	$ins="insert into friend_tbl set requested_by='".$_SESSION['session_user_set']."',requested_to='".$_REQUEST['rid']."', cdate='".date('Y-m-d H:i:s')."',status='0'";
	$data=$db->query($ins);
	$db->query("insert into notification set user_id='".$_SESSION['session_user_set']."',other_id='".$_REQUEST['rid']."',msg='Send a Friend Requests!',cdate='".date('Y-m-d H:i:s')."' ");
	echo "1";
}
else if(isset($_REQUEST['action']) && $_REQUEST['action']=='Do_login')
{
	$sel="select * from registration where (email='".$_REQUEST['email']."' || account_id='".$_REQUEST['email']."') and password='".$_REQUEST['password']."'";
	$q=$db->query($sel);
	$count=mysqli_num_rows($q);
	if($count)
	{
		$row=mysqli_fetch_array($q);
		$db->query("update registration set last_login='".date('Y-m-d H:i:s')."' where id=".$row['id']);
		$db->set_zone();	
		$_SESSION['session_user_set']=$row['id'];
		echo "<script>window.location.href='../dashboard.php'</script>";
		die;
	}
	else 
	{
		echo "<script>window.location.href='../login.php?msg=invalid'</script>";
		die;
	}
}
else if(isset($_REQUEST['action']) && $_REQUEST['action']=='request_action')
{
	$status=$_REQUEST['set'];
	$sel="select * from friend_tbl where id='".$_REQUEST['id']."'";
	$data=$db->query($sel);
	$row=mysqli_fetch_array($data);
	if($status==1)
	{
		$sql="update friend_tbl set status='$status' where id='".$_REQUEST['id']."'";
		$db->query("insert into notification set user_id='".$row['requested_to']."',other_id='".$row['requested_by']."',msg='Accepted a Friend Requests!',cdate='".date('Y-m-d H:i:s')."' ");
		$_SESSION['succ_msg']='Success! Request Has been approved.';
	}
	else if($status==2)
	{
		$sql="update friend_tbl set status='$status' where id='".$_REQUEST['id']."'";
		$db->query("insert into notification set user_id='".$row['requested_to']."',other_id='".$row['requested_by']."',msg='Blocked a Friend Requests!',cdate='".date('Y-m-d H:i:s')."' ");
		$_SESSION['succ_msg']='Success! Request Has been Blocked.';
	}
	else 
	{
		$sql="delete from friend_tbl where id='".$_REQUEST['id']."'";
		$db->query("insert into notification set user_id='".$row['requested_to']."',other_id='".$row['requested_by']."',msg='Rejected a Friend Requests!',cdate='".date('Y-m-d H:i:s')."' ");
		$_SESSION['succ_msg']='Success! Request Has been Rejected.';
	}
	$q=$db->query($sql);
	echo "<script>window.location.href='../freind-request.php'</script>";
	die;
}
else if(isset($_REQUEST['action']) && $_REQUEST['action']=='request_contact')
{
	$sql="delete from friend_tbl where id='".$_REQUEST['id']."'";
	$q=$db->query($sql);
	$_SESSION['succ_msg']='Success! User Has been Removed From Contact.';
	echo "<script>window.location.href='../profile-page.php?keyword=".$_REQUEST['key']."'</script>";
	die; 
}
else if(isset($_REQUEST['action']) && $_REQUEST['action']=='check_allow')
{
	$sel="update registration set ".$_REQUEST['name']."=".$_REQUEST['act']." where id='".$_SESSION['session_user_set']."'";
	$q=$db->query($sel);
	echo "1";
	die;
}

else if(isset($_REQUEST['action']) && $_REQUEST['action']=='delete_account')
{
	$sel="delete from registration where id='".$_SESSION['session_user_set']."'";
	$q=$db->query($sel);
	session_destroy();
	echo "<script>window.location.href='../index.php'</script>";
	die;
}

else if(isset($_REQUEST['action']) && $_REQUEST['action']=='Do_login_mob')
{
	$mobile=ltrim($_REQUEST['mobile'],"+");
	$sel="select * from registration where mobile='".$mobile."' and password='".$_REQUEST['password']."'";
	$q=$db->query($sel);
	$count=mysqli_num_rows($q);
	if($count)
	{
		$row=mysqli_fetch_array($q);
		$db->query("update registration set last_login='".date('Y-m-d H:i:s')."' where id=".$row['id']);
		$_SESSION['session_user_set']=$row['id'];
		$db->set_zone();
		echo "<script>window.location.href='../dashboard.php'</script>";
		die;
	}
	else 
	{
		echo "<script>window.location.href='../index.php?msg=invalid'</script>";
		die;
	}
}

else if(isset($_REQUEST['action']) && $_REQUEST['action']=='sendotp'){	
$code=rand(999,10000);
$authKey = "1220Alj1Sz0Zfkf567e98be";
$mobileNumber = trim($_REQUEST['mobile']);
$mobileNumber = ltrim($mobileNumber,"+");
/*$senderId = "ibitte";
$message = urlencode("Hopedin Verification Code - ".$code);
$route = "default";
$postData = array(    'authkey' => $authKey,    'mobiles' => $mobileNumber,    'message' => $message,    'sender' => $senderId,    'route' => $route);
$url="http://bulksmsc.com/api/sendhttp.php";
$ch = curl_init();
curl_setopt_array($ch, array(    CURLOPT_URL => $url,    CURLOPT_RETURNTRANSFER => true,    CURLOPT_POST => true,    CURLOPT_POSTFIELDS => $postData));
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$output = curl_exec($ch);
if(curl_errno($ch)){    
echo 'error:' . curl_error($ch);
}
curl_close($ch);
*/

$params = array(
			  'api_key'=>'944a4c9d',
			  'api_secret'=>'GVW8g4dvgpqvrY0u',
			  'to'=>$mobileNumber,
			  'from'=>'NEXMO',
			  'text'=>"Hopedin Verification Code - ".$code
			  
			);
			$postData = http_build_query($params);
			$ch = curl_init();
			curl_setopt_array($ch, array(    CURLOPT_URL => 'https://rest.nexmo.com/sms/json',    CURLOPT_RETURNTRANSFER => true,    CURLOPT_POST => true,    CURLOPT_POSTFIELDS => $postData));
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$output = curl_exec($ch);
			if(curl_errno($ch)){    
			echo 'error:' . curl_error($ch);
			}
			//print_r($output);
			curl_close($ch);
$sel="select * from registration where mobile ='$mobileNumber'";
$q=$db->query($sel);
$count=mysqli_num_rows($q);
if($count){
	$query="update registration set mobile_verify=0,code='$code' where mobile ='$mobileNumber'";
	}else {
		$query="insert into registration set mobile ='$mobileNumber', mobile_verify=0,code='$code',profile='profile_photo.jpg'";
		}
		$q=$db->query($query);
		echo $output;
}
else if(isset($_REQUEST['action']) && $_REQUEST['action']=='verifyopt'){
	$sel="select * from registration where mobile ='".$_REQUEST['mobile']."' and code='".$_REQUEST['code']."'";
	$q=$db->query($sel);
	$count=mysqli_num_rows($q);
	if($count){
		$row=mysqli_fetch_array($q);
		$_SESSION['session_user_set']=$row['id'];
		echo "1";
		die;
	}else {
		echo "0";
		die;
		}
}
else if(isset($_REQUEST['action']) && $_REQUEST['action']=='sendotp1'){	
	    
		$code=rand(999,10000);
		$authKey = "8209ATNGl0kz5b096d0c";
		$mobileNumber = trim($_REQUEST['mobile']);
		$mobileNumber=ltrim($mobileNumber,"+");
		$cdata=$db->checkmobile($mobileNumber);
		$count=mysqli_num_rows($cdata);
		if($count)
		{
			echo "0";
			die;
		}
		else
		{
			/*
			$senderId = "Hopedin";
			$message = urlencode("Hopedin Verification Code - ".$code);
			$route = "default";
			$postData = array(    'authkey' => $authKey,    'mobiles' => $mobileNumber,    'message' => $message,    'sender' => $senderId);
			$url="http://bulksmsc.com/api/sendhttp.php";
			$ch = curl_init();
			curl_setopt_array($ch, array(    CURLOPT_URL => $url,    CURLOPT_RETURNTRANSFER => true,    CURLOPT_POST => true,    CURLOPT_POSTFIELDS => $postData));
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$output = curl_exec($ch);
			if(curl_errno($ch)){    
			echo 'error:' . curl_error($ch);
			}
			curl_close($ch);
			*/
			$params = array(
			  'api_key'=>'944a4c9d',
			  'api_secret'=>'GVW8g4dvgpqvrY0u',
			  'to'=>$mobileNumber,
			  'from'=>'NEXMO',
			  'text'=>"Hopedin Verification Code - ".$code
			  
			);
			$postData = http_build_query($params);
			$ch = curl_init();
			curl_setopt_array($ch, array(    CURLOPT_URL => 'https://rest.nexmo.com/sms/json',    CURLOPT_RETURNTRANSFER => true,    CURLOPT_POST => true,    CURLOPT_POSTFIELDS => $postData));
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$output = curl_exec($ch);
			if(curl_errno($ch)){    
			echo 'error:' . curl_error($ch);
			}
			//print_r($output);
			curl_close($ch);
			$_SESSION['mobileNumber']=$mobileNumber;
			$_SESSION['otp_code']=$code; 
			echo "1";
			die;
		}
}
else if(isset($_REQUEST['action']) && $_REQUEST['action']=='otp_forgot_email'){
	$code=rand(1000,9999);
	$email = trim($_REQUEST['email']);
	$sql="select * from registration where email='$email'";
	$run=$db->query($sql);
	$count=mysqli_num_rows($run);
	if($count)
	{
		$row=mysqli_fetch_array($run);
		$db->query("update registration set forgot_code='".$code."' where id=".$row['id']);
		$to = $email;
				$from = "info@nationalkitchen.net";
				$headers ="From: $from\n";
				$headers .= "MIME-Version: 1.0\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
				$subject ="Password Reset Code!";
				$msg = '<body style="margin:0px;">
						<table style="padding:0;width:100%!important;background:#f1f1f1;margin:0; padding:30px 0px;" cellspacing="0" cellpadding="8" border="0">
						  <tbody>
							<tr >
							  <td valign="top"><table style="border-radius:4px;border:1px #FFE1CC solid; background:#fff" cellspacing="0" cellpadding="0" border="0" align="center">
								  <tbody>
									<tr style="background: black;color: white;/*! padding-left: 23px; */">
									  <td colspan="3" height="6"><h3 style="text-align: center;">Hopedin</h3></td>
									</tr>
									 
									<tr>
									  <td><table style="line-height:25px" cellspacing="0" cellpadding="0" border="0" align="center">
										  <tbody>
											<tr>
											  <td colspan="3" height="30"></td>
											</tr>
											<tr>
											  <td width="36"></td>
											  <td style="color:#444444;border-collapse:collapse;font-size:11pt;font-family:proxima_nova,Open Sans,Lucida Grande,Segoe UI,Arial,Verdana,Lucida Sans Unicode,Tahoma,Sans Serif;max-width:454px" width="454" valign="top" align="left">Hello, '.$row['fname'].' <br>
											  <p class="text-center">This mail is inform you that new password reset request received.</p> 
												<br>
												<p>Your OPT - <b>'.$code.'</b></p>
												<p>Thank You</p>
												<p>Hopedin</p>
											  <td width="36"></td>
											</tr>
											<tr>
											  <td colspan="3" height="36"></td>
											</tr> 
										  </tbody>
										</table></td>
									</tr>
								  </tbody>
								</table>
								<table cellspacing="0" cellpadding="0" border="0" align="center">
								  <tbody>
									<tr>
									  <td height="10"></td>
									</tr>
									<tr>
									  <td style="padding:0;border-collapse:collapse"><table cellspacing="0" cellpadding="0" border="0" align="center">
										  <tbody>
											<tr style="color:#a8b9c6;font-size:11px;font-family:proxima_nova,Open Sans,Lucida Grande,Segoe UI,Arial,Verdana,Lucida Sans Unicode,Tahoma,Sans Serif">
											  <td width="400" align="left"></td>
											  <td width="128" align="right">&copy; 2018 Hopedin</td>
											</tr>
										  </tbody>
										</table></td>
									</tr>
								  </tbody>
								</table></td>
							</tr>
						  </tbody>
						</table>
						</body>';
		mail($to,$subject,$msg,$headers);
		echo "1"; 
		die;
	}
	else 
	{
		echo "0";
		die;
	}
}

else if(isset($_REQUEST['action']) && $_REQUEST['action']=='otp_forgot'){
$code=rand(1000,9999);
$authKey = "8209ATNGl0kz5b096d0c";
$mobileNumber = trim($_REQUEST['mobile']);
$mobileNumber = ltrim($mobileNumber,"+");
$sql="select * from registration where mobile='$mobileNumber'";
$run=$db->query($sql);
$count=mysqli_num_rows($run);
if($count)
{
	$row=mysqli_fetch_array($run);
	/*$senderId = "Hopedin";
	$message = urlencode("Hopedin: Your OTP - ".$code);
	$route = "default";
	$postData = array(    'authkey' => $authKey,    'mobiles' => $mobileNumber,    'message' => $message,    'sender' => $senderId);
	$url="http://bulksmsc.com/api/sendhttp.php";
	$ch = curl_init();
	curl_setopt_array($ch, array(    CURLOPT_URL => $url,    CURLOPT_RETURNTRANSFER => true,    CURLOPT_POST => true,    CURLOPT_POSTFIELDS => $postData));
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$output = curl_exec($ch);
	if(curl_errno($ch)){    
	echo 'error:' . curl_error($ch);
	}
	curl_close($ch);
	*/
			$params = array(
			  'api_key'=>'944a4c9d',
			  'api_secret'=>'GVW8g4dvgpqvrY0u',
			  'to'=>$mobileNumber,
			  'from'=>'NEXMO',
			  'text'=>"Hopedin Verification Code - ".$code
			  
			);
			$postData = http_build_query($params);
			$ch = curl_init();
			curl_setopt_array($ch, array(    CURLOPT_URL => 'https://rest.nexmo.com/sms/json',    CURLOPT_RETURNTRANSFER => true,    CURLOPT_POST => true,    CURLOPT_POSTFIELDS => $postData));
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			$output = curl_exec($ch);
			if(curl_errno($ch)){    
			echo 'error:' . curl_error($ch);
			}
			//print_r($output);
			curl_close($ch);
	$db->query("update registration set forgot_code='".$code."' where id=".$row['id']);
	echo "1";
	die;
}
else
{
	echo "0";
	die;
}

}
else if(isset($_REQUEST['action']) && $_REQUEST['action']=='reset_password'){
	if(isset($_REQUEST['mobile']))
	{
		$mobileNumber = trim($_REQUEST['mobile']);
		$mobileNumber = ltrim($mobileNumber,"+");
		$q=" mobile='$mobileNumber' and afp_pin='".$_REQUEST['afp_pin']."' ";
	}
	else
	{
		$email = trim($_REQUEST['email']);
		$q=" email='$email' ";
	}
	$sql="select * from registration where $q and forgot_code='".$_REQUEST['otp']."'";
	$run=$db->query($sql);
	$count=mysqli_num_rows($run);
	if($count)
	{
		$row=mysqli_fetch_array($run);
		$db->query("update registration set forgot_code='0',password='".$_REQUEST['password']."' where id=".$row['id']); 
		$_SESSION['succ_msg']='Success! Password Changed.';
		echo "1";
		die;
	}
	else 
	{
		echo "0";
		die;
	}
}


else if(isset($_REQUEST['action']) && $_REQUEST['action']=='verify_otp'){
	/*echo $_SESSION['mobileNumber'];
	echo "@";
	echo $opt=implode("",$_REQUEST['otp']);
	die;*/
	$otp_mobile=$_SESSION['mobileNumber'];
	$mobile=trim($_REQUEST['mobile']);
	$mobile = ltrim($mobile,"+");
	$opt=$_REQUEST['otp'];
	if($otp_mobile==$mobile && $opt==$_SESSION['otp_code'])
	{
		echo "1";
		die;
	}
	else
	{
		echo "0";
		die;
	}
}
else if(isset($_REQUEST['action']) && $_REQUEST['action']=='forgot_phase'){
	$pin=trim($_REQUEST['pin']);
	$email=trim($_REQUEST['email']);
	$email = ltrim($email,"+");
    $sel="select * from registration where afp_pin='$pin' and (email='$email' || mobile='$email' || account_id='$email')";
    $run=$db->query($sel);
	//$data=$db->checkpin($_REQUEST['pin'],$_REQUEST['email']);
	$count=mysqli_num_rows($run);
	if($count)
	{
		echo "1";
	}
	else 
	{
		echo "0";
	}
}


?>