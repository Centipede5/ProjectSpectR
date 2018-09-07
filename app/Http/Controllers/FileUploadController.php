<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\User;

class FileUploadController extends Controller
{
    public function uploads () {
# Validation Checks
        // 1) The User is logged in and they have the correct permissions
        // 2) Check Image MIME type
        // 3) Allow certain file extensions - PNG, JPEG, and GIF
        // 4) Check Size - larger than 400x400 and under 2MB

        ## Ok for upload!

# Process the Image
        // 0) Clear out any Temp files that the user has created. Users may be uploading several times.
        // 1) Rename the image - ID-UNIQID-RAND-DISPLAY_NAME-SITENAME-PURPOSE.jpg
        // 2) Resize and compress the source image - 400x*
        // 3) Move to the archive location
        //          - Override existing images
        // 4) Create the 3 cropped image sizes: 90, 126, and 400
        // 5) Upload/Copy new images to - AWS S3
        // 6) Update the "users" table with the new file name for the user images
        // 7) Delete all other user Avatars on AWS and the local set of images

        // Image Parameters
//             90x90
//             126x126
//             400x400

        //Parameters
        # Upload Location
        $target_dir = "../storage/user_uploads/";
        # Rename File
        $target_file = $target_dir . "USER_" . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }
// Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
// Check file size
        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
// Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
// Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        return view('blank-page');
    }

    public function profileImageUpload () {
        LogIt::info("STARTING IMAGE VALIDATION");

        # Validation Checks
        ## The User is logged in and they have the correct permissions
        if(Auth::guest()) {
            $response = array(
                "status" => 'error',
                "message" => 'LOGGED OUT: You are no longer logged in. Please Login and try again.',
            );
            LogIt::error("FAILED: Upload Profile Image UNAUTHORIZED - User Not Logged In");
            print json_encode($response);
            return;
        }

        LogIt::userLog("Uploading new Profile Image");
        LogIt::trace("PASSED: User Verification");

        ## Image Upload has no errors
        if ($_FILES["img"]["error"] > 0) {
            $response = array(
                "status" => 'error',
                "message" => 'ERROR: '. $this->codeToMessage($_FILES["img"]["error"]),
            );
            print json_encode($response);
            return;
        }
        LogIt::trace("PASSED: Verify No Upload Errors");

        $imagePath      = "temp/";
        $allowedExts    = array("jpeg", "jpg", "JPEG", "JPG", "png", "PNG");
        $allowedMimes   = array("image/png", "image/jpeg");
        $temp           = explode(".", $_FILES["img"]["name"]);
        $extension      = end($temp);
        $mimeType       = getimagesize($_FILES["img"]["tmp_name"])['mime'];
        $imgWidth       = getimagesize($_FILES["img"]["tmp_name"])[0];
        $imgHeight      = getimagesize($_FILES["img"]["tmp_name"])[1];
        $filesize       = filesize($_FILES["img"]["tmp_name"]);

        LogIt::trace(filesize($_FILES["img"]["tmp_name"]));

        ## Check Image MIME type
        if ( !in_array($mimeType, $allowedMimes)) {
            $response = array(
                "status" => 'error',
                "message" => 'Incorrect MIME type uploaded. Please use a JPG or PNG image.',
            );
            LogIt::error("FAILED: Incorrect MIME Type Uploaded: " . $mimeType);
            print json_encode($response);
            return;
        }
        LogIt::trace("PASSED: File MIME Type");

        ## Allow certain file extensions - PNG, JPEG, and GIF
        if ( !in_array($extension, $allowedExts)) {
            $response = array(
                "status" => 'error',
                "message" => 'Incorrect File type uploaded. Please use a JPG or PNG image.',
            );
            LogIt::error("FAILED: Incorrect File Type Uploaded");
            print json_encode($response);
            return;
        }
        LogIt::trace("PASSED: File Extension Check");

        ## Check Size - larger than 400x400 and under 2MB
        if($imgWidth < 400 || $imgHeight < 400 || $filesize < 10000){
            $response = array(
                "status" => 'error',
                "message" => 'Image Size is to small. Please Upload a larger image.',
            );
            LogIt::error("FAILED: Image Uploaded to small.");
            print json_encode($response);
            return;
        }
        LogIt::trace("PASSED: Image Size Greater than 400");

        ## Check write Access to Directory
        if(is_writable($imagePath)){
            ## Clear out any Temp files that the user has created. Users may be uploading several times.
            $mask = $imagePath . "temp_" . Auth::user()->id . "*.*";
            array_map('unlink', glob($mask));

            $mask = "uploads/temp_" . Auth::user()->id . "*.*";
            array_map('unlink', glob($mask));

            LogIt::trace("PASSED: CLEARING OLD FILES");
        } else {
            $response = Array(
                "status" => 'error',
                "message" => 'Can`t upload File; no write Access'
            );
            print json_encode($response);
            return;
        }
        LogIt::trace("PASSED: Directory Path Writable");

        LogIt::info("=============== VALIDATION PASSED ===============");

        # Process the Image

        // 1) Rename the image - ID-UNIQID-RAND-DISPLAY_NAME-SITENAME-PURPOSE.jpg
        // 2) Resize and compress the source image - 400x*
        // 3) Move to the archive location
        //          - Override existing images
        // 4) Create the 3 cropped image sizes: 90, 126, and 400
        // 5) Upload/Copy new images to - AWS S3
        // 6) Update the "users" table with the new file name for the user images
        // 7) Delete all other user Avatars on AWS and the local set of images

        $filename = $_FILES["img"]["tmp_name"];
        list($width, $height) = getimagesize( $filename );


        // 1) Rename the image for Archive - ID-UNIQID-SITENAME-DISPLAY_NAME-PURPOSE
        $archivePath = "../storage/user_uploads/";
        $archiveImgName = Auth::user()->id . "-avatar." . $extension;   // Orginal Image  renamed and stored for admin reference
        copy($filename,  $archivePath . $archiveImgName);   // Copy Uploaded image to the archive

        // Moving image to PUBLIC to be edited
        $newImgName = "temp_" . Auth::user()->id . "-". rand(100,999) . ".". $extension;
        move_uploaded_file($filename,  $imagePath . $newImgName);   // Move the image to public to be edited

        $response = array(
            "status" => 'success',
            "url" => $imagePath.$newImgName,
            "width" => $width,
            "height" => $height
        );

        print json_encode($response);
    }

    public function profileImageCrop () {
        // 90 = .51
        // 126 = .70
        // 400 = 2.25
        $imgUrl = $_POST['imgUrl'];

        // original sizes
        $imgInitW = $_POST['imgInitW'];
        $imgInitH = $_POST['imgInitH'];

        // rotation angle
        $angle = $_POST['rotation'];

        $jpeg_quality = 100;

        $output_temp_filename = "uploads/temp_" . Auth::user()->id."-".rand(100,999);


        $imgType = getimagesize($imgUrl);

        switch(strtolower($imgType['mime']))
        {
            case 'image/png':
                $img_r = imagecreatefrompng($imgUrl);
                $source_image = imagecreatefrompng($imgUrl);
                $type = '.png';
                break;
            case 'image/jpeg':
                $img_r = imagecreatefromjpeg($imgUrl);
                $source_image = imagecreatefromjpeg($imgUrl);
                error_log("jpg");
                $type = '.jpg';
                break;
//            case 'image/gif':
//                $img_r = imagecreatefromgif($imgUrl);
//                $source_image = imagecreatefromgif($imgUrl);
//                $type = '.gif';
//                break;
            default: die('image type not supported');
        }

        //Check write Access to Directory
        if(!is_writable(dirname($output_temp_filename))){
            $response = Array(
                "status" => 'error',
                "message" => 'Can`t write cropped File'
            );
        }else{

            ## Create 90x90
            // resized sizes
            $imgW = $_POST['imgW']*.51;
            $imgH = $_POST['imgH']*.51;
            // offsets
            $imgY1 = $_POST['imgY1'] * .51;
            $imgX1 = $_POST['imgX1'] * .51;
            // crop box
            $cropW = $_POST['cropW'] * .51;
            $cropH = $_POST['cropH'] * .51;
            $output_filename = "uploads/" . Auth::user()->id . "-". substr(Auth::user()->uniqid, 2) . "-" . strtolower(env('APP_NAME')) . "-" . strtolower(Auth::user()->display_name) . "-" . "avatar-90x90";
            // resize the original image to size of editor
            $resizedImage = imagecreatetruecolor($imgW, $imgH);
            imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
            // rotate the rezized image
            $rotated_image = imagerotate($resizedImage, -$angle, 0);
            // find new width & height of rotated image
            $rotated_width = imagesx($rotated_image);
            $rotated_height = imagesy($rotated_image);
            // diff between rotated & original sizes
            $dx = $rotated_width - $imgW;
            $dy = $rotated_height - $imgH;
            // crop rotated image to fit into original rezized rectangle
            $cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
            imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
            imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
            // crop image into selected area
            $final_image = imagecreatetruecolor($cropW, $cropH);
            imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
            imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
            // finally output png image
            //imagepng($final_image, $output_filename.$type, $png_quality);
            imagejpeg($final_image, $output_filename.$type, $jpeg_quality);

            ## Create 126x126
            // resized sizes
            $imgW = $_POST['imgW']*.71;
            $imgH = $_POST['imgH']*.71;
            // offsets
            $imgY1 = $_POST['imgY1'] * .71;
            $imgX1 = $_POST['imgX1'] * .71;
            // crop box
            $cropW = $_POST['cropW'] * .71;
            $cropH = $_POST['cropH'] * .71;
            $output_filename = "uploads/" . Auth::user()->id . "-". substr(Auth::user()->uniqid, 2) . "-" . strtolower(env('APP_NAME')) . "-" . strtolower(Auth::user()->display_name) . "-" . "avatar-126x126";
            // resize the original image to size of editor
            $resizedImage = imagecreatetruecolor($imgW, $imgH);
            imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
            // rotate the rezized image
            $rotated_image = imagerotate($resizedImage, -$angle, 0);
            // find new width & height of rotated image
            $rotated_width = imagesx($rotated_image);
            $rotated_height = imagesy($rotated_image);
            // diff between rotated & original sizes
            $dx = $rotated_width - $imgW;
            $dy = $rotated_height - $imgH;
            // crop rotated image to fit into original rezized rectangle
            $cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
            imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
            imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
            // crop image into selected area
            $final_image = imagecreatetruecolor($cropW, $cropH);
            imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
            imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
            // finally output png image
            //imagepng($final_image, $output_filename.$type, $png_quality);
            imagejpeg($final_image, $output_filename.$type, $jpeg_quality);

            ## Create 400x400
            $output_filename = "uploads/" . Auth::user()->id . "-". substr(Auth::user()->uniqid, 2) . "-" . strtolower(env('APP_NAME')) . "-" . strtolower(Auth::user()->display_name) . "-" . "avatar-400x400";
            // resized sizes
            $imgW = $_POST['imgW']*2.25;
            $imgH = $_POST['imgH']*2.25;
            // offsets
            $imgY1 = $_POST['imgY1'] * 2.25;
            $imgX1 = $_POST['imgX1'] * 2.25;
            // crop box
            $cropW = $_POST['cropW'] * 2.25;
            $cropH = $_POST['cropH'] * 2.25;

            // resize the original image to size of editor
            $resizedImage = imagecreatetruecolor($imgW, $imgH);
            imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
            // rotate the rezized image
            $rotated_image = imagerotate($resizedImage, -$angle, 0);
            // find new width & height of rotated image
            $rotated_width = imagesx($rotated_image);
            $rotated_height = imagesy($rotated_image);
            // diff between rotated & original sizes
            $dx = $rotated_width - $imgW;
            $dy = $rotated_height - $imgH;
            // crop rotated image to fit into original rezized rectangle
            $cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
            imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
            imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
            // crop image into selected area
            $final_image = imagecreatetruecolor($cropW, $cropH);
            imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
            imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
            // finally output png image
            //imagepng($final_image, $output_filename.$type, $png_quality);
            imagejpeg($final_image, $output_filename.$type, $jpeg_quality);
            imagejpeg($final_image, $output_temp_filename.$type, $jpeg_quality);

            if(Auth::user()->profile_image == "00-default-avatar.jpg"){
                LogIt::debug("UPDATING THE DB RECORD");
                $profileImage = Auth::user()->id . "-". substr(Auth::user()->uniqid, 2) . "-" . strtolower(env('APP_NAME')) . "-" . strtolower(Auth::user()->display_name) . "-" . "avatar.jpg";
                $user = User::find(Auth::user()->id);
                $user->profile_image = $profileImage;
                $user->save();
            }

            $response = Array(
                "status" => 'success',
                "url" => $output_temp_filename.$type
            );
        }
        unlink($imgUrl);
        print json_encode($response);
    }

    private function codeToMessage($code)
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
                $message = "The uploaded file exceeds the maximum size of " . ini_get('upload_max_filesize') . ". Please use a smaller image.";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "The uploaded file was only partially uploaded";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "No file was uploaded";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Missing a temporary folder";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Failed to write file to disk";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "File upload stopped by extension";
                break;

            default:
                $message = "Unknown upload error";
                break;
        }
        return $message;
    }
}
