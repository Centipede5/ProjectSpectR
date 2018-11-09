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
        (new ImageProcessController())->profileImageUpload();
    }

    public function profileImageCrop () {
        (new ImageProcessController())->profileImageCrop();
    }

    public function canopyImageUpload () {
        (new ImageProcessController())->canopyImageUpload();
    }

    public function canopyImageCrop () {
        (new ImageProcessController())->canopyImageCrop();
    }
    public function sliderImageUpload () {
        (new ImageProcessController())->sliderImageUpload();
    }

    public function sliderImageCrop () {
        (new ImageProcessController())->sliderImageCrop();
    }
}
