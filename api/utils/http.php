<?php

function notFoundResponse()
{
    global $NOT_FOUND_STATUS_CODE;

    $response['status_code_header'] = $NOT_FOUND_STATUS_CODE;
    $response['body'] = null;
    return $response;
}

function defaultSuccessResponse(){
    
    $successResponse = array(
        "status" => true 
    );
    
    return $successResponse;
}

function errorResponse($code){
    global $ERROR_RESPONSE;
    
    $errorResponse = array (
        "code" => $code,
        "message" => $ERROR_RESPONSE[$code]
    );

    return $errorResponse;
}


