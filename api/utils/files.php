<?php

function saveUploadedFile($file, $targetDir)
{
    global $FAILED_UPLOADE_FILE_ERROR_CODE;

    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $targetFile = $targetDir.basename($file["name"]);

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return "";
    } 
    
    return errorResponse($FAILED_UPLOADE_FILE_ERROR_CODE);
}
