<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cropper</title>
    <link href="cropper.css" rel="stylesheet">
	<script src="jquery-3.3.1.min.js"></script>
    <style type="text/css">
        #cropperContainer{ width:180px; height:180px; position: relative; border:1px solid #ccc;}
    </style>
  </head>

  <body>
	
	<div class="container">
	    <div class="row mt centered">
			<div class="col-lg-4 ">
				<h4 class="centered"> DEMO </h4>
				<p class="centered"></p>
				<div id="cropperContainer"></div>
			</div>
		</div>
	</div>
	

    <!-- Bootstrap core JavaScript
    ================================================== -->
   	<script src="cropper.js"></script>
    <script>
		var cropperContainerOptions = {
				uploadUrl:'uploadAndSave.php',
				cropUrl:'cropAndSave.php',
				imgEyecandy:false,				
				loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
				onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
				onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
				onImgDrag: function(){ console.log('onImgDrag') },
				onImgZoom: function(){ console.log('onImgZoom') },
				onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
				onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
				onReset:function(){ console.log('onReset') },
				onError:function(errormessage){ console.log('onError:'+errormessage) }
		};
		new Cropper('cropperContainer', cropperContainerOptions);
	</script>
  </body>
</html>
