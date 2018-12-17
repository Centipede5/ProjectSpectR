<?php
/**
 * Created by PhpStorm.
 * User: bplentl
 * Date: 8/24/18
 * Time: 11:37 AM
 */

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/main.css" rel="stylesheet">
    <link href="assets/css/croppic.css" rel="stylesheet">
</head>

<body>
<div class="container">
    <div class="row mt ">
        <div class="col-lg-4 ">
            <h4 class="centered"> FINAL </h4>
            <p class="centered"></p>
            <div id="cropContainerEyecandy"></div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="jquery-3.3.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>

<script src="croppic_fix2.js"></script>
<script>
    var croppicContainerEyecandyOptions = {
        uploadUrl:'upload',
        cropUrl:'crop',
        imgEyecandy:false,
        doubleZoomControls:false,
        rotateControls: true,
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

    new Croppic('cropContainerEyecandy', croppicContainerEyecandyOptions);

</script>
</body>
</html>

