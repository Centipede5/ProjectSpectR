<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;

class ImageProcessController extends Controller
{
    /**
     * Refactored and Reviewed: 09/07/2018 (bp)
     */
    public function profileImageUpload () {
        LogIt::trace($_FILES["img"]);

        # Validation Checks
        ## 1) The User is logged in and they have the correct permissions
        if(Auth::guest()) {
            $response = array(
                "status" => 'error',
                "message" => 'LOGGED OUT: You are no longer logged in. Please Login and try again.',
            );
            LogIt::error("FAILED: Upload Profile Image UNAUTHORIZED - User Not Logged In");
            print json_encode($response);
            return;
        }

        LogIt::userLog("Uploading new Profile Image: " . $_FILES["img"]["name"]);
        LogIt::trace("PASSED: User Verification");

        ## 2) Image Upload has no errors
        if ($_FILES["img"]["error"] > 0) {
            $response = array(
                "status" => 'error',
                "message" => 'ERROR: '. $this->codeToMessage($_FILES["img"]["error"]),
            );
            print json_encode($response);
            return;
        }

        LogIt::trace("PASSED: Verify No Upload Errors");

        ## 3) Check Image MIME type
        $allowedMimes   = array("image/png", "image/jpeg");
        $mimeType       = $_FILES["img"]["type"];
        if ( !in_array($mimeType, $allowedMimes)) {
            $response = array(
                "status" => 'error',
                "message" => 'Incorrect MIME type uploaded. Please use a JPG or PNG image.',
            );

            LogIt::userLog("FAILED: Incorrect MIME Type Uploaded: " . $mimeType);

            print json_encode($response);
            return;
        }

        LogIt::trace("PASSED: File MIME Type");

        ## 4) Allow certain file extensions - PNG, JPEG, and GIF
        $allowedExts    = array("jpeg", "jpg", "JPEG", "JPG", "png", "PNG");
        $extension      = pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION);
        if ( !in_array($extension, $allowedExts)) {
            $response = array(
                "status" => 'error',
                "message" => 'Incorrect File type uploaded. Please use a JPG or PNG image.',
            );

            LogIt::userLog("FAILED: Incorrect File Type Uploaded");

            print json_encode($response);
            return;
        }

        LogIt::trace("PASSED: File Extension Check");

        ## 5) Check Size - larger than 400x400 and under 2MB
        $imgWidth       = getimagesize($_FILES["img"]["tmp_name"])[0];
        $imgHeight      = getimagesize($_FILES["img"]["tmp_name"])[1];
        $filesize       = filesize($_FILES["img"]["tmp_name"]);
        if($imgWidth < 400 || $imgHeight < 400 || $filesize < 10000){
            $response = array(
                "status" => 'error',
                "message" => 'Image Size is to small. Please Upload a larger image.',
            );

            LogIt::userLog("FAILED: Image Uploaded to small.");

            print json_encode($response);
            return;
        }

        LogIt::trace("PASSED: Image Size Greater than 400");

        ## 6) Check write Access to Directory
        $tempImagePath  = "temp/";
        if(is_writable($tempImagePath)){
            ## Clear out any Temp files that the user has created. Users may be uploading several times.
            $mask = $tempImagePath . "temp_" . Auth::user()->id . "*.*";
            array_map('unlink', glob($mask));

            $mask = "uploads/temp_" . Auth::user()->id . "*.*";
            array_map('unlink', glob($mask));

            LogIt::trace("PASSED: CLEARING OLD FILES");
        } else {
            $response = Array(
                "status" => 'error',
                "message" => 'Can`t upload File; no write Access'
            );
            LogIt::trace($response);

            print json_encode($response);
            return;
        }

        LogIt::trace("PASSED: Directory Path Writable");
        LogIt::info("=========== IMAGE VALIDATION PASSED ===========");

        /*
         * The Uploaded file has been validated and is CLEARED for processing
         */

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
        list($width, $height) = getimagesize( $_FILES["img"]["tmp_name"] );

        // TODO: Archiving the uncompressed / original files the user uploads can potentially become heavy and unnecessary. Need to decide on how to clean this up periodically.
        // 1) Rename the image for Archive - ID-DISPLAY_NAME-PURPOSE
        // Remove old files
        $mask = "../storage/user_uploads/" . Auth::user()->id . "*.*";
        array_map('unlink', glob($mask));
        $archivePath = "../storage/user_uploads/";
        $archiveImgName = Auth::user()->id . "-" . Auth::user()->display_name . "-avatar." . $extension;   // Original Image renamed and stored for admin reference
        copy($filename,  $archivePath . $archiveImgName);   // Copy Uploaded image to the archive

        // Moving image to PUBLIC to be edited
        $newImgName = "temp_" . Auth::user()->id . "-". rand(100,999) . ".". $extension;
        move_uploaded_file($filename,  $tempImagePath . $newImgName);   // Move the image to public to be edited

        $response = array(
            "status" => 'success',
            "url" => $tempImagePath.$newImgName,
            "width" => $width,
            "height" => $height
        );

        print json_encode($response);
    }

    /**
     * Every user will get 4 images saved for their user profile
     * 90x90    - Nav Bar and comments
     * 126x126  - Friends Widget
     * 400X400  - Profile Image
     * Original - Uncropped, but downsized
     */
    public function profileImageCrop () {
        // 90 = .51
        // 126 = .70
        // 400 = 2.25

        // Where the temp image is located
        $imgUrl = $_POST['imgUrl'];
        //$imgUrl = "public/temp/48-avatar.jpg";

        // rotation angle
        $angle = $_POST['rotation'];

        $jpeg_quality = 100;
        $output_temp_filename = "uploads/temp_" . Auth::user()->id."-".rand(100,999);
        $imgType = getimagesize($imgUrl);

        switch(strtolower($imgType['mime']))
        {
            case 'image/png':
                $source_image = imagecreatefrompng($imgUrl);
                $type = '.png';
                break;
            case 'image/jpeg':
                $source_image = imagecreatefromjpeg($imgUrl);
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
            LogIt::userLog("Error: Can`t write cropped File");
        }else{

            // TODO: Need to change this to renaming the old files and only remove them after the new images have been made. Works for now.
            ## Clear out any user files that the user has created.
            #        Users may have different file types that might
            #        get left in the folder.
            $mask = "uploads/" . Auth::user()->id . "*avatar*.*";
            array_map('unlink', glob($mask));

            LogIt::trace("PASSED: CLEARING OLD FILES");

            // original sizes
            $imgInitW = $_POST['imgInitW'];
            $imgInitH = $_POST['imgInitH'];

            ##########################################
            # Resize Original and Use for Profile Link
            if($imgInitH>=$imgInitW){
                $newImgW=400;
                $newImgH=round(($imgInitH * 400) / $imgInitW);
            } else {
                $newImgH=400;
                $newImgW=round(($imgInitW * 400) / $imgInitH);
            }

            $profileImage = Auth::user()->id . "-". substr(Auth::user()->uniqid, 2) . "-" . strtolower(env('APP_NAME')) . "-" . strtolower(Auth::user()->display_name) . "-" . "avatar".$type;
            $output_filename = "uploads/" . $profileImage;
            $resizedImage = imagecreatetruecolor($newImgW, $newImgH);
            imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $newImgW, $newImgH, $imgInitW, $imgInitH);
            if($type==".jpg"){
                imagejpeg($resizedImage, $output_filename, 100);
            } else if ($type==".png"){
                imagepng($resizedImage, $output_filename, 9);
            }

            // TODO: Refactor this into an array loop
            ############
            ## 400 x 400
            $imgW = $_POST['imgW']*2.25;
            $imgH = $_POST['imgH']*2.25;
            // offsets
            $imgY1 = $_POST['imgY1'] * 2.25;
            $imgX1 = $_POST['imgX1'] * 2.25;
            // crop box
            $cropW = $_POST['cropW'] * 2.25;
            $cropH = $_POST['cropH'] * 2.25;

            $output_filename = "uploads/" . Auth::user()->id . "-". substr(Auth::user()->uniqid, 2) . "-" . strtolower(env('APP_NAME')) . "-" . strtolower(Auth::user()->display_name) . "-" . "avatar-400x400".$type;

            $resizedImage = imagecreatetruecolor($imgW, $imgH);
            imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
            $final_image = imagecreatetruecolor($cropW, $cropH);
            imagecopyresampled($final_image, $resizedImage, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);

            if($type==".jpg"){
                imagejpeg($final_image, $output_filename, 100);
                imagejpeg($final_image, $output_temp_filename.$type, 10);
            } else if ($type==".png"){
                imagepng($final_image, $output_filename, 9);
                imagepng($final_image, $output_temp_filename.$type, 9);
            }

            ############
            ## 126 x 126
            $imgW = $_POST['imgW']*.71;
            $imgH = $_POST['imgH']*.71;
            // offsets
            $imgY1 = $_POST['imgY1'] * .71;
            $imgX1 = $_POST['imgX1'] * .71;
            // crop box
            $cropW = $_POST['cropW'] * .71;
            $cropH = $_POST['cropH'] * .71;
            $output_filename = "uploads/" . Auth::user()->id . "-". substr(Auth::user()->uniqid, 2) . "-" . strtolower(env('APP_NAME')) . "-" . strtolower(Auth::user()->display_name) . "-" . "avatar-126x126".$type;
            $resizedImage = imagecreatetruecolor($imgW, $imgH);
            imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
            $final_image = imagecreatetruecolor($cropW, $cropH);
            imagecopyresampled($final_image, $resizedImage, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);

            if($type==".jpg"){
                imagejpeg($final_image, $output_filename, 100);
            } else if ($type==".png"){
                imagepng($final_image, $output_filename, 9);
            }

            ############
            ## 400 x 400
            $imgW = $_POST['imgW']*.51;
            $imgH = $_POST['imgH']*.51;
            // offsets
            $imgY1 = $_POST['imgY1'] * .51;
            $imgX1 = $_POST['imgX1'] * .51;
            // crop box
            $cropW = $_POST['cropW'] * .51;
            $cropH = $_POST['cropH'] * .51;
            $output_filename = "uploads/" . Auth::user()->id . "-". substr(Auth::user()->uniqid, 2) . "-" . strtolower(env('APP_NAME')) . "-" . strtolower(Auth::user()->display_name) . "-" . "avatar-90x90".$type;
            $resizedImage = imagecreatetruecolor($imgW, $imgH);
            imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
            $final_image = imagecreatetruecolor($cropW, $cropH);
            imagecopyresampled($final_image, $resizedImage, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);

            if($type==".jpg"){
                imagejpeg($final_image, $output_filename, 100);
            } else if ($type==".png"){
                imagepng($final_image, $output_filename, 9);
            }

            if(Auth::user()->profile_image != $profileImage){
                LogIt::debug("UPDATING THE DB RECORD");
                $user = User::find(Auth::user()->id);
                $user->profile_image = $profileImage;
                $user->save();
            }

            $response = Array(
                "status" => 'success',
                "url" => $output_temp_filename.$type
            );
            LogIt::userLog("Profile Image Updated");
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
