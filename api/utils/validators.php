<?php

function validateUploadedFile($targetDir, $fileInputName) {

    global $INVALID_FILE_ERROR_CODE, $LARGE_FILE_ERROR_CODE, $INVALID_IMAGE_TYPE_ERROR_CODE, $MAX_UPLOAD_FILE_SIZE;

    if (!isset($_FILES[$fileInputName])){
        return errorResponse($INVALID_FILE_ERROR_CODE);
    }

    $file = $_FILES[$fileInputName];
    $targetFile =  $targetDir.basename($file["name"]);
    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
  

    // Check if image file is a actual image or fake image
    $check = getimagesize($file["tmp_name"]);
    if ($check == false) {
        return errorResponse($INVALID_FILE_ERROR_CODE);
    }

    // Check file size
    if ($file["size"] > $MAX_UPLOAD_FILE_SIZE) {
        return errorResponse($LARGE_FILE_ERROR_CODE);
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        return errorResponse($INVALID_IMAGE_TYPE_ERROR_CODE);
    }

    return "";
}

function validateUsername($username){
    global $INVALID_USERNAME_ERROR_CODE;
    if (preg_match("/^[a-zA-Z0-9]{8,15}+$/", $username) != true){
        return errorResponse($INVALID_USERNAME_ERROR_CODE);
    }

    return "";
}

function validatePassword($password){
    global $INVALID_PASSWORD_ERROR_CODE;
    if (preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,20}$/", $password) != true){
        return errorResponse($INVALID_PASSWORD_ERROR_CODE);
    }

    return "";
}

function validateRequiredInput($input, $errorCode){

    if (strlen($input) < 5){
        return errorResponse($errorCode);
    }

    return "";
}