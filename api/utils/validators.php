<?php

function validateUploadedFile($file, $targetFile) {

    $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

    global $INVALID_FILE_ERROR_CODE, $LARGE_FILE_ERROR_CODE, $INVALID_IMAGE_TYPE_ERROR_CODE, $MAX_UPLOAD_FILE_SIZE;

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

