<?php include 'include/header.php';
include 'include/head.php';
?> 
<script src="js/recorder.js"></script>
<script>
        // Expose globally your audio_context, the recorder instance and audio_stream
        var audio_context;
        var recorder;
        var audio_stream;

        /**
         * Patch the APIs for every browser that supports them and check
         * if getUserMedia is supported on the browser. 
         * 
         */
        function Initialize() {
            try {
                // Monkeypatch for AudioContext, getUserMedia and URL
                window.AudioContext = window.AudioContext || window.webkitAudioContext;
                navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia;
                window.URL = window.URL || window.webkitURL;

                // Store the instance of AudioContext globally
                audio_context = new AudioContext;
                console.log('Audio context is ready !');
                console.log('navigator.getUserMedia ' + (navigator.getUserMedia ? 'available.' : 'not present!'));
            } catch (e) {
                alert('No web audio support in this browser!');
            }
        }
 
        /**
         * Starts the recording process by requesting the access to the microphone.
         * Then, if granted proceed to initialize the library and store the stream.
         *
         * It only stops when the method stopRecording is triggered.
         */
        function startRecording() {
            // Access the Microphone using the navigator.getUserMedia method to obtain a stream
			navigator.getUserMedia = (
				navigator.getUserMedia ||
				navigator.webkitGetUserMedia ||
				navigator.mozGetUserMedia ||
				navigator.msGetUserMedia
			);
            navigator.getUserMedia({ audio: true }, function (stream) {
                // Expose the stream to be accessible globally
                audio_stream = stream;
                // Create the MediaStreamSource for the Recorder library
                var input = audio_context.createMediaStreamSource(stream);
                console.log('Media stream succesfully created');

                // Initialize the Recorder Library
                recorder = new Recorder(input);
                console.log('Recorder initialised');

                // Start recording !
                recorder && recorder.record();
                console.log('Recording...');
                $('#start-btn').hide();
            	$('#stop-btn').show();
                // Disable Record button and enable stop button !
                document.getElementById("start-btn").disabled = true;
                document.getElementById("stop-btn").disabled = false;
            }, function (e) {
                console.error('No live audio input: ' + e);
            });
        }

        /**
         * Stops the recording process. The method expects a callback as first
         * argument (function) executed once the AudioBlob is generated and it
         * receives the same Blob as first argument. The second argument is
         * optional and specifies the format to export the blob either wav or mp3
         */
        function stopRecording(callback, AudioFormat) {
            // Stop the recorder instance
            recorder && recorder.stop();
            console.log('Stopped recording.');

            // Stop the getUserMedia Audio Stream !
            audio_stream.getAudioTracks()[0].stop();

            // Disable Stop button and enable Record button !
            document.getElementById("start-btn").disabled = false;
            document.getElementById("stop-btn").disabled = true;

            // Use the Recorder Library to export the recorder Audio as a .wav file
            // The callback providen in the stop recording method receives the blob
            if(typeof(callback) == "function"){

                /**
                 * Export the AudioBLOB using the exportWAV method.
                 * Note that this method exports too with mp3 if
                 * you provide the second argument of the function
                 */
                recorder && recorder.exportWAV(function (blob) {
                    callback(blob);

                    // create WAV download link using audio data blob
                    // createDownloadLink();

                    // Clear the Recorder to start again !
                    recorder.clear();
                }, (AudioFormat || "audio/wav"));
            }
        }
    </script>
	<script type="text/javascript" src="js/webcam.js"></script>
<link href="lib/css/emoji.css" rel="stylesheet">
<style>

.emoji-items a 
{
	padding:3px;
}
#stop-btn
{
	  -webkit-filter: invert(40%) grayscale(100%) brightness(100%) sepia(100%) hue-rotate(-50deg) saturate(400%) contrast(2);
      filter: grayscale(100%) brightness(100%) sepia(100%) hue-rotate(-50deg) saturate(600%) contrast(0.8);
}
</style>
<script>
$(window).load(function(){
	setInterval(update_contact_list,3000); 
});

$(document).ready(function(){
  $("#chat_users").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".my_contact_list .chat-selected").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});

</script>
<script language="JavaScript">
$(document).on('click','.cameras',function(){
	
	Webcam.set({
			width: 600,
			height: 460,
			image_format: 'jpeg',
			jpeg_quality: 90
		});
	var checkss=Webcam.attach( '#my_camera' );
	if(checkss)
	{
		$('#cameraModal').modal('show');
	}
});	
</script>
<script type="text/javascript" src="js/jquery.form.min.js"></script>
<div class="dashboard-content">
  	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3 side-menu">
				<div class="search-menu">
					<input type="text" id="chat_users" placeholder="Search here">
					<span class="search-ico"><a href="#"><i class="fa fa-search"></i></a></span>
				</div>
				<ul class="side-menu-list my_contact_list">
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
							  <p class="alert alert-danger text-center">No Chat Yet!</p>
							  <?php
						  }
					?>
						
				</ul>
			</div>
			<div class="col-sm-9 right-content right_chat">   
			
				<?php 
					if(isset($_REQUEST['user']))   
					{
						$data=$db->get_user_byId($_REQUEST['user']);
						$row=mysqli_fetch_assoc($data);
					?>
					<div class="main-right">
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
							<li><a href="javascript:void(0);" onclick="return Get_geo_location();" ><span><i  class="fa fa-map"></i></span><span>Location</span></a></li>
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
				?>
			</div>
			 
		</div>
	</div>
  </div>
  
<div id="cameraModal" style="top:20%" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Take From camera</h4>
      </div>
      <div class="modal-body">
		<div id="results"></div>
        <div id="my_camera"></div>
		<form>
			<button type="button"  onClick="take_snapshot()">Take Pic</button>
		</form>
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-success" >Upload</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
 
  <ol id="recordingsList" style="top:450px; position:relative; display:none;"></ol>
  <?php
if(isset($_REQUEST['info']))
{	?>
<script>
	$(document).ready(function(){
		$('.my_chatting<?php echo $_REQUEST['info']; ?>').trigger('click');
	});
</script><?php  
}
?>
<script>
function Get_geo_location()
{
	if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(showLocation);
    }else{ 
        $('#location').html('Geolocation is not supported by this browser.');
	}
}
function showLocation(position){
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
    /*$.ajax({
        type:'POST',
        url:'getLocation.php',
        data:'latitude='+latitude+'&longitude='+longitude,
        success:function(msg){
            if(msg){
               $("#location").html(msg);
            }else{
                $("#location").html('Not Available');
            }
        }
    }); */
}
</script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	<script src="lib/js/config.js"></script>
    <script src="lib/js/util.js"></script>
    <script src="lib/js/jquery.emojiarea.js"></script>
    <script src="lib/js/emoji-picker.js"></script>
    <!-- End emoji-picker JavaScript -->

    <script>
      $(function() {
	 
      });
    </script>

  </body>